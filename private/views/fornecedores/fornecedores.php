<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    GROUP_CONCAT(DISTINCT e.id) AS equipamentos_ids,
    GROUP_CONCAT(DISTINCT CONCAT(e.codigo, ' - ', e.designacao) SEPARATOR ', ') AS equipamentos_nomes
FROM fornecedores f
LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
LEFT JOIN moradas m ON f.morada_id = m.id
LEFT JOIN equipamento_fornecedor ef ON ef.fornecedor_id = f.id
LEFT JOIN equipamentos e ON e.id = ef.equipamento_id
GROUP BY f.id, f.codigo, f.nome_empresa, tf.designacao, f.pessoa_contacto, f.telefone_pessoa_contacto, m.designacao, f.ativo
")->fetchAll(PDO::FETCH_OBJ);

    $nomes = $ligacao->query("SELECT nome_empresa FROM fornecedores ORDER BY nome_empresa")->fetchAll(PDO::FETCH_OBJ);
    $pessoas = $ligacao->query("SELECT pessoa_contacto FROM fornecedores ORDER BY pessoa_contacto")->fetchAll(PDO::FETCH_OBJ);

    $equipamentosFiltro = $ligacao->query("
        SELECT id, codigo, designacao
        FROM equipamentos
        ORDER BY codigo
    ")->fetchAll(PDO::FETCH_OBJ);

    $erro = '';
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $nomes = [];
    $pessoas = [];
    $equipamentosFiltro = [];
}

$ligacao = null;

?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal da área privada -->
    <main class="conteudo-privado">

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
                        placeholder="Pesquisar por código, nome da empresa, NIF, contacto telefónico, email, morada, website, pessoa de contacto ou tipo de fornecedor...">
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
                <i class="fa-solid fa-file-excel"></i>
                Exportar Listagem dos Fornecedores
            </a>
        </div>

        <div class="tabela-privada">
            <table id="tabela-fornecedores">
                <thead>
                    <tr>
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
                            <tr>
                                <td><?= htmlspecialchars($fornecedor->nome_empresa) ?></td>
                                <td><?= htmlspecialchars($fornecedor->tipo_fornecedor) ?></td>
                                <td><?= htmlspecialchars($fornecedor->pessoa_contacto) ?></td>
                                <td><?= htmlspecialchars($fornecedor->telefone_pessoa_contacto) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->morada) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->equipamentos_ids) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($fornecedor->equipamentos_nomes) ?></td>

                                <td class="acoes-tabela-privada">
                                    <a href="/medivault/private/views/fornecedores/consultar_fornecedor.php?id_fornecedor=<?= aes_encrypt($fornecedor->id) ?>" class="acao-tabela-privada" title="Consultar" style="color: #005fae;">
    <i class="fa-regular fa-eye"></i>
</a>
                                    <a href="editar_fornecedor.php?id_fornecedor=<?= aes_encrypt($fornecedor->id) ?>" class="acao-tabela-privada" title="Editar" style="color: #2a9d8f;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <?php if ($fornecedor->ativo == 1) : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalEliminarFornecedor" onclick="prepararEliminacaoFornecedor('<?= aes_encrypt($fornecedor->id) ?>', '<?= htmlspecialchars($fornecedor->nome_empresa, ENT_QUOTES) ?>')" title="Eliminar" style="color: #dc3545;">
        <i class="fa-regular fa-trash-can"></i>
    </button>
<?php else : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalReativarFornecedor" onclick="prepararReativacaoFornecedor('<?= aes_encrypt($fornecedor->id) ?>', '<?= htmlspecialchars($fornecedor->nome_empresa, ENT_QUOTES) ?>')" title="Reativar" style="color: #9333ea;">
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

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarFornecedor">

                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">

                <p id="textoModalEliminarFornecedor">
                    Tem a certeza que pretende eliminar este fornecedor?
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoFornecedor()">

                    Eliminar

                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal reativar fornecedor -->
<div class="modal fade" id="modalReativarFornecedor" tabindex="-1" aria-labelledby="tituloModalReativarFornecedor"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalReativarFornecedor">
                    <i class="fa-solid fa-rotate-left"></i>
                    Confirmar reativação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">
                <p id="textoModalReativarFornecedor">
                    Tem a certeza que pretende reativar este fornecedor?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn" style="background-color: #9333ea; color: #fff;" onclick="confirmarReativacaoFornecedor()">
                    Reativar
                </button>
            </div>

        </div>

    </div>

</div>

<script>
    let tabela;

    $(document).ready(function() {
        tabela = $('#tabela-fornecedores').DataTable({
            pageLength: 5,
            pagingType: "full_numbers",
            dom: 'rtip',
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

        // Pesquisa
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

        // Limpar filtros
        $('#botaoLimparApenasFiltrosFornecedores').on('click', function() {
            $('#filtroTipoFornecedor').val('');
            $('#filtroNomeEmpresa').val('');
            $('#filtroMoradaFornecedor').val('');
            $('#filtroPessoaContacto').val('');
            $('#filtroEquipamentoFornecedor').val('');
            tabela.columns().search('').draw();
        });
    });

    let idFornecedorEliminarEncriptado = null;

function prepararEliminacaoFornecedor(idEncriptado, nomeEmpresa) {
    idFornecedorEliminarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalEliminarFornecedor");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende desativar o fornecedor <strong>${nomeEmpresa}</strong>?`;
    }
}

function confirmarEliminacaoFornecedor() {
    if (!idFornecedorEliminarEncriptado) {
        return;
    }

    window.location.href = "confirmar_apagar_fornecedor.php?id_fornecedor=" + encodeURIComponent(idFornecedorEliminarEncriptado);
}

let idFornecedorReativarEncriptado = null;

function prepararReativacaoFornecedor(idEncriptado, nomeEmpresa) {
    idFornecedorReativarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalReativarFornecedor");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende reativar o fornecedor <strong>${nomeEmpresa}</strong>?`;
    }
}

function confirmarReativacaoFornecedor() {
    if (!idFornecedorReativarEncriptado) {
        return;
    }

    window.location.href = "reativar_fornecedor.php?id_fornecedor=" + encodeURIComponent(idFornecedorReativarEncriptado);
}
</script>

<?php include '../../includes/footer.php'; ?>