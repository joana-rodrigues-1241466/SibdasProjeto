<?php
// ============================================================
// FORNECEDORES.PHP
// Listagem de todos os fornecedores, com pesquisa, filtros
// (tipo, nome da empresa, morada, pessoa de contacto,
// equipamento associado), exportação para Excel e ações de
// consultar/editar/desativar/reativar cada fornecedor.
// ============================================================

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter a listagem de fornecedores e os valores distintos para os filtros
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
SELECT
    f.id, 
    f.codigo,
    f.nome_empresa,
    tf.designacao AS tipo_fornecedor,
    f.pessoa_contacto,
    f.telefone_pessoa_contacto,
    m.designacao AS morada,
    f.ativo,
    f.snapshot_equipamentos,
    GROUP_CONCAT(DISTINCT e.id) AS equipamentos_ids,
    GROUP_CONCAT(DISTINCT CONCAT(e.codigo, ' - ', e.designacao) SEPARATOR ', ') AS equipamentos_nomes
FROM fornecedores f
LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
LEFT JOIN moradas m ON f.morada_id = m.id
LEFT JOIN equipamento_fornecedor ef ON ef.fornecedor_id = f.id
LEFT JOIN equipamentos e ON e.id = ef.equipamento_id
GROUP BY f.id, f.codigo, f.nome_empresa, tf.designacao, f.pessoa_contacto, f.telefone_pessoa_contacto, m.designacao, f.ativo, f.snapshot_equipamentos
")->fetchAll(PDO::FETCH_OBJ);

    $nomes = $ligacao->query("SELECT nome_empresa FROM fornecedores ORDER BY nome_empresa")->fetchAll(PDO::FETCH_OBJ);
    $pessoas = $ligacao->query("SELECT pessoa_contacto FROM fornecedores ORDER BY pessoa_contacto")->fetchAll(PDO::FETCH_OBJ);

    $equipamentosFiltro = $ligacao->query("
    SELECT id, codigo, designacao
    FROM equipamentos
    WHERE ativo = 1
    ORDER BY codigo
")->fetchAll(PDO::FETCH_OBJ);

    // Para cada fornecedor, contar quantos equipamentos o têm como ÚNICO fornecedor associado
    // (esses equipamentos exigem substituto obrigatório ao desativar o fornecedor)
    $fornecedoresComEquipamentoUnico = $ligacao->query("
        SELECT fornecedor_id, COUNT(*) AS total
        FROM equipamento_fornecedor
        WHERE equipamento_id IN (
            SELECT equipamento_id FROM equipamento_fornecedor GROUP BY equipamento_id HAVING COUNT(*) = 1
        )
        GROUP BY fornecedor_id
    ")->fetchAll(PDO::FETCH_KEY_PAIR);

    $erro = '';
} catch (PDOException $err) {
    registar_erro_log($err->getMessage());
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $nomes = [];
    $pessoas = [];
    $equipamentosFiltro = [];
    $fornecedoresComEquipamentoUnico = [];
}

$ligacao = null;

?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Listagem de fornecedores -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <?php if (!empty($_SESSION['mensagem_erro'])) : ?>
            <div id="alerta-erro" class="alert alert-danger text-center" role="alert">
                <i class="fa-solid fa-circle-exclamation"></i>
                <?= htmlspecialchars($_SESSION['mensagem_erro']) ?>
            </div>
            <script>
                setTimeout(function() {
                    const alerta = document.getElementById('alerta-erro');
                    if (alerta) {
                        alerta.style.transition = 'opacity 0.5s ease';
                        alerta.style.opacity = '0';
                        setTimeout(function() {
                            alerta.remove();
                        }, 500);
                    }
                }, 4000);
            </script>
            <?php unset($_SESSION['mensagem_erro']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['mensagem_sucesso'])) : ?>
            <div id="alerta-sucesso" class="alert alert-success text-center" role="alert">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_SESSION['mensagem_sucesso']) ?>
            </div>
            <script>
                setTimeout(function() {
                    const alerta = document.getElementById('alerta-sucesso');
                    if (alerta) {
                        alerta.style.transition = 'opacity 0.5s ease';
                        alerta.style.opacity = '0';
                        setTimeout(function() {
                            alerta.remove();
                        }, 500);
                    }
                }, 3000);
            </script>
            <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Fornecedores</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="novo_fornecedor.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Novo fornecedor
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre os fornecedores associados aos equipamentos médicos do inventário
            hospitalar.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaFornecedores" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por nome da empresa, tipo de fornecedor, morada, pessoa de contacto, telefone da pessoa de contacto, equipamento associado...">
                    <button type="button" id="botaoPesquisarFornecedores" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaFornecedores"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroTipoFornecedor">
                            Tipo de fornecedor
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroTipoFornecedor" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                                <option value="Fabricante">
                                    Fabricante
                                </option>

                                <option value="Distribuidor ou Fornecedor comercial">
                                    Distribuidor ou Fornecedor comercial
                                </option>

                                <option value="Empresa de assistência técnica">
                                    Empresa de assistência técnica
                                </option>

                                <option value="Fornecedor de consumíveis ou acessórios">
                                    Fornecedor de consumíveis ou acessórios
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroNomeEmpresa">
                            Nome da empresa
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroNomeEmpresa" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <?php foreach ($nomes as $nome) : ?>
                                    <option value="<?= htmlspecialchars($nome->nome_empresa) ?>"><?= htmlspecialchars($nome->nome_empresa) ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroMoradaFornecedor">
                            Morada
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroMoradaFornecedor" class="campo-filtro-equipamentos">

                                <option value="">Todos</option>

                                <option value="Aveiro">Aveiro, Portugal</option>
                                <option value="Beja">Beja, Portugal</option>
                                <option value="Braga">Braga, Portugal</option>
                                <option value="Bragança">Bragança, Portugal</option>
                                <option value="Castelo Branco">Castelo Branco, Portugal</option>
                                <option value="Coimbra">Coimbra, Portugal</option>
                                <option value="Évora">Évora, Portugal</option>
                                <option value="Faro">Faro, Portugal</option>
                                <option value="Guarda">Guarda, Portugal</option>
                                <option value="Leiria">Leiria, Portugal</option>
                                <option value="Lisboa">Lisboa, Portugal</option>
                                <option value="Portalegre">Portalegre, Portugal</option>
                                <option value="Porto">Porto, Portugal</option>
                                <option value="Santarém">Santarém, Portugal</option>
                                <option value="Setúbal">Setúbal, Portugal</option>
                                <option value="Viana do Castelo">Viana do Castelo, Portugal</option>
                                <option value="Vila Real">Vila Real, Portugal</option>
                                <option value="Viseu">Viseu, Portugal</option>
                                <option value="Região Autónoma dos Açores">Região Autónoma dos Açores, Portugal
                                </option>
                                <option value="Região Autónoma da Madeira">Região Autónoma da Madeira, Portugal
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">

                        <label for="filtroPessoaContacto">
                            Pessoa de contacto
                        </label>

                        <div class="select-filtro-wrapper">

                            <select id="filtroPessoaContacto" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <?php foreach ($pessoas as $pessoa) : ?>
                                    <option value="<?= htmlspecialchars($pessoa->pessoa_contacto) ?>"><?= htmlspecialchars($pessoa->pessoa_contacto) ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>

                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEquipamentoFornecedor">
                            Equipamento associado
                        </label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroEquipamentoFornecedor" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($equipamentosFiltro as $equipamento) : ?>
                                    <option value="<?= htmlspecialchars($equipamento->id) ?>"><?= htmlspecialchars($equipamento->codigo . ' - ' . $equipamento->designacao) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">
                        <label>&nbsp;</label>
                        <button type="button" id="botaoLimparApenasFiltrosFornecedores"
                            class="botao-limpar-apenas-filtros" title="Limpar filtros">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>

                </div>
            </div>

        </section>

        <div class="acao-exportar-tabela">
            <a href="exportar_excel_fornecedores.php" class="link-exportar-excel">
                <i class="fa-solid fa-file-csv"></i>
                Exportar CSV
            </a>
            <a href="exportar_json_fornecedores.php" class="link-exportar-excel" style="margin-left: 1rem; color: #f08c00;">
                <i class="fa-solid fa-file-code"></i>
                Exportar JSON
            </a>
            <a href="exportar_pdf_fornecedores.php" target="_blank" class="link-exportar-pdf" style="margin-left: 1rem;">
                <i class="fa-solid fa-file-pdf"></i>
                Exportar PDF
            </a>
        </div>

        <!-- Tabela de fornecedores (DataTables) -->
        <div class="tabela-privada">
            <table id="tabela-fornecedores">
                <thead>
                    <tr>
                        <th style="display:none;">Código</th>
                        <th>Nome da empresa</th>
                        <th>Tipo de fornecedor</th>
                        <th>Pessoa de contacto</th>
                        <th>Telefone de contacto</th>
                        <th style="display:none;">Morada</th>
                        <th style="display:none;">Equipamentos IDs</th>
                        <th style="display:none;">Equipamentos Nomes</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($erro)) : ?>
                        <tr>
                            <td colspan="5" class="text-center text-danger"><?= $erro ?></td>
                        </tr>
                    <?php elseif (count($resultados) == 0) : ?>
                        <tr>
                            <td colspan="5" class="text-muted">Não existem fornecedores registados.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($resultados as $fornecedor) : ?>
                            <tr class="<?= $fornecedor->ativo == 0 ? 'linha-inativa' : '' ?>">
                                <td style="display:none;">
                                    <?= htmlspecialchars($fornecedor->codigo) ?>
                                </td>
                                <td><?= htmlspecialchars($fornecedor->nome_empresa) ?></td>
                                <td><?= htmlspecialchars($fornecedor->tipo_fornecedor) ?></td>
                                <td><?= htmlspecialchars($fornecedor->pessoa_contacto) ?></td>
                                <td><?= htmlspecialchars($fornecedor->telefone_pessoa_contacto) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->morada) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->equipamentos_ids) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->equipamentos_nomes) ?></td>

                                <td class="acoes-tabela-privada">
                                    <a href="<?= BASE_URL ?>/private/views/fornecedores/consultar_fornecedor.php?id_fornecedor=<?= aes_encrypt($fornecedor->id) ?>" class="acao-tabela-privada" title="Consultar" style="color: #005fae;">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <?php if ($fornecedor->ativo == 1) : ?>
                                        <a href="editar_fornecedor.php?id_fornecedor=<?= aes_encrypt($fornecedor->id) ?>" class="acao-tabela-privada" title="Editar" style="color: #2a9d8f;">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($fornecedor->ativo == 1) : ?>
                                        <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalEliminarFornecedor" onclick="prepararEliminacaoFornecedor('<?= aes_encrypt($fornecedor->id) ?>', '<?= htmlspecialchars($fornecedor->nome_empresa, ENT_QUOTES) ?>', <?= isset($fornecedoresComEquipamentoUnico[$fornecedor->id]) ? 'true' : 'false' ?>)" title="Eliminar" style="color: #dc3545;">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    <?php else : ?>

                                        <?php
                                        $totalSnapshot = !empty($fornecedor->snapshot_equipamentos) ? count(json_decode($fornecedor->snapshot_equipamentos, true)) : 0;
                                        ?>
                                        <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalReativarFornecedor" onclick="prepararReativacaoFornecedor('<?= aes_encrypt($fornecedor->id) ?>', '<?= htmlspecialchars($fornecedor->nome_empresa, ENT_QUOTES) ?>', <?= $totalSnapshot ?>)" title="Reativar" style="color: #9333ea;">
                                            <i class="fa-solid fa-rotate-left"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </main>

</div>

<!-- Modal eliminar fornecedor -->
<div class="modal fade" id="modalEliminarFornecedor" tabindex="-1" aria-labelledby="tituloModalEliminarFornecedor"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form id="formEliminarFornecedor" method="POST" action="confirmar_apagar_fornecedor.php">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModalEliminarFornecedor">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Confirmar eliminação
                        <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                            data-bs-trigger="hover focus" data-bs-placement="left" data-bs-html="true"
                            data-bs-content="
        <strong>Ativo</strong> - O fornecedor ainda presta serviços ao hospital, podendo ser associado a equipamentos.<br><br>
        <strong>Inativo</strong> - A relação com o fornecedor terminou, deixando de fazer parte deste sistema de gestão.">
                        </i>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <p id="textoModalEliminarFornecedor">
                        Tem a certeza que pretende eliminar este fornecedor?
                    </p>

                    <input type="hidden" name="id_fornecedor" id="inputIdFornecedorEliminar">

                    <div id="blocoSubstituicaoFornecedor" style="display:none; margin-top: 1rem;">
                        <label for="selectFornecedorSubstituto" class="form-label" style="font-weight:600;">
                            Este fornecedor é o único associado a um ou mais equipamentos. Escolha um substituto:
                        </label>
                        <select id="selectFornecedorSubstituto" name="novo_fornecedor_id" class="form-select">
                            <option value="" selected disabled>Escolha um fornecedor...</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Eliminar
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<!-- Modal reativar fornecedor -->
<div class="modal fade" id="modalReativarFornecedor" tabindex="-1" aria-labelledby="tituloModalReativarFornecedor"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form id="formReativarFornecedor" method="POST" action="reativar_fornecedor.php">

                <div class="modal-header">

                    <h5 class="modal-title" id="tituloModalReativarFornecedor">
                        <i class="fa-solid fa-rotate-left"></i>
                        Confirmar reativação
                        <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                            data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                            style="font-size: 0.9rem; cursor: pointer; vertical-align: middle;"
                            data-bs-content="
    <strong>Ativo</strong> - O fornecedor ainda presta serviços ao hospital, podendo ser associado a equipamentos.<br><br>
    <strong>Inativo</strong> - A relação com o fornecedor terminou, deixando de fazer parte deste sistema de gestão até ser reativado.">
                        </i>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>

                <div class="modal-body">
                    <p id="textoModalReativarFornecedor">
                        Tem a certeza que pretende reativar este fornecedor?
                    </p>

                    <input type="hidden" name="id_fornecedor" id="inputIdFornecedorReativar">

                    <div id="blocoReassociacaoFornecedor" style="display:none; margin-top: 1rem;">
                        <label class="form-label" style="font-weight:600;">
                            Este fornecedor estava associado a <span id="totalEquipamentosReassociar"></span> equipamento(s) antes de ser desativado. O que pretende fazer?
                        </label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opcao_reassociacao" id="opcaoReassociar" value="reassociar" checked>
                            <label class="form-check-label" for="opcaoReassociar">
                                Reassociar aos equipamentos anteriores
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="opcao_reassociacao" id="opcaoNaoAssociar" value="nao_associar">
                            <label class="form-check-label" for="opcaoNaoAssociar">
                                Não associar a nenhum equipamento
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn" style="background-color: #9333ea; color: #fff;">
                        Reativar
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    let tabela;

    // Inicialização da tabela de fornecedores com DataTables (paginação, pesquisa, etc.)
    $(document).ready(function() {
        tabela = $('#tabela-fornecedores').DataTable({
            pageLength: 5,
            pagingType: "full_numbers",
            dom: 'rtip',
            scrollX: true,
            language: {
                decimal: "",
                emptyTable: "Sem dados disponíveis na tabela.",
                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                infoFiltered: "(Filtrando _MAX_ total de registos)",
                infoPostFix: "",
                thousands: ",",
                lengthMenu: "Mostrando _MENU_ registos por página.",
                loadingRecords: "Carregando...",
                processing: "Processando...",
                search: "Filtrar:",
                zeroRecords: "Nenhum registo encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                }
            }
        });

        // Pesquisa livre na tabela
        $('#pesquisaFornecedores').on('input', function() {
            tabela.search($(this).val()).draw();
        });

        $('#botaoPesquisarFornecedores').on('click', function() {
            tabela.search($('#pesquisaFornecedores').val()).draw();
        });

        $('#botaoLimparApenasPesquisaFornecedores').on('click', function() {
            $('#pesquisaFornecedores').val('');
            tabela.search('').draw();
        });

        // Filtro tipo de fornecedor
        $('#filtroTipoFornecedor').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(1).search('').draw();
            } else {
                tabela.column(1).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro nome da empresa
        $('#filtroNomeEmpresa').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(0).search('').draw();
            } else {
                tabela.column(0).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro pessoa de contacto
        $('#filtroPessoaContacto').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(2).search('').draw();
            } else {
                tabela.column(2).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro morada
        $('#filtroMoradaFornecedor').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(4).search('').draw();
            } else {
                tabela.column(4).search(valor, false, false).draw();
            }
        });

        // Filtro equipamento associado
        $('#filtroEquipamentoFornecedor').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(5).search('').draw();
            } else {
                tabela.column(5).search('(^|,)' + valor + '(,|$)', true, false).draw();
            }
        });

        // Limpar todos os filtros
        $('#botaoLimparApenasFiltrosFornecedores').on('click', function() {
            $('#filtroTipoFornecedor').val('');
            $('#filtroNomeEmpresa').val('');
            $('#filtroMoradaFornecedor').val('');
            $('#filtroPessoaContacto').val('');
            $('#filtroEquipamentoFornecedor').val('');
            tabela.columns().search('').draw();
        });

        // Ativar os popovers do Bootstrap (tooltips informativos)
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function(el) {
            new bootstrap.Popover(el);
        });
    });

    // Lista de todos os fornecedores ativos, para preencher o select de substituição
    const TODOS_FORNECEDORES_ATIVOS = <?php
                                        $opcoesFornecedores = [];
                                        foreach ($resultados as $forn) {
                                            if ($forn->ativo == 1) {
                                                $opcoesFornecedores[] = ['id' => aes_encrypt($forn->id), 'label' => $forn->nome_empresa];
                                            }
                                        }
                                        echo json_encode($opcoesFornecedores);
                                        ?>;

    // Prepara o modal de eliminação: mostra/esconde e preenche o select
    // de substituição consoante haja ou não equipamentos só com este fornecedor
    function prepararEliminacaoFornecedor(idEncriptado, nomeEmpresa, temEquipamentoUnico) {
        document.getElementById("inputIdFornecedorEliminar").value = idEncriptado;

        const textoModal = document.getElementById("textoModalEliminarFornecedor");
        if (textoModal) {
            textoModal.innerHTML =
                `Tem a certeza que pretende desativar o fornecedor <strong>${nomeEmpresa}</strong>?`;
        }

        const bloco = document.getElementById("blocoSubstituicaoFornecedor");
        const select = document.getElementById("selectFornecedorSubstituto");

        if (temEquipamentoUnico) {
            bloco.style.display = "block";
            select.required = true;

            select.innerHTML = '<option value="" selected disabled>Escolha um fornecedor...</option>';
            TODOS_FORNECEDORES_ATIVOS.forEach(function(forn) {
                if (forn.id !== idEncriptado) {
                    const opcao = document.createElement("option");
                    opcao.value = forn.id;
                    opcao.textContent = forn.label;
                    select.appendChild(opcao);
                }
            });
        } else {
            bloco.style.display = "none";
            select.required = false;
            select.value = "";
        }
    }

    // Prepara o modal de reativação: mostra a escolha de reassociação
    // só se existirem equipamentos guardados no instantâneo
    function prepararReativacaoFornecedor(idEncriptado, nomeEmpresa, totalEquipamentosSnapshot) {
        document.getElementById("inputIdFornecedorReativar").value = idEncriptado;

        const textoModal = document.getElementById("textoModalReativarFornecedor");
        if (textoModal) {
            textoModal.innerHTML =
                `Tem a certeza que pretende reativar o fornecedor <strong>${nomeEmpresa}</strong>?`;
        }

        const bloco = document.getElementById("blocoReassociacaoFornecedor");

        if (totalEquipamentosSnapshot > 0) {
            bloco.style.display = "block";
            document.getElementById("totalEquipamentosReassociar").textContent = totalEquipamentosSnapshot;
        } else {
            bloco.style.display = "none";
        }
    }
</script>

<?php include '../../includes/footer.php'; ?>