<?php
// ============================================================
// LOCALIZACOES.PHP
// Listagem de todas as localizações, com pesquisa, filtros
// (edifício, piso, serviço, sala, equipamento associado),
// exportação para Excel e ações de consultar/editar/
// desativar/reativar cada localização.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter a listagem de localizações e os valores distintos para os filtros
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
    SELECT 
    l.id, l.codigo, l.edificio, l.piso, l.servico, l.sala, l.ativo,
        GROUP_CONCAT(DISTINCT e.id) AS equipamentos_ids,
        GROUP_CONCAT(DISTINCT CONCAT(e.codigo, ' - ', e.designacao) SEPARATOR ', ') AS equipamentos_nomes
    FROM localizacoes l
    LEFT JOIN equipamentos e ON e.localizacao_id = l.id
    GROUP BY l.id, l.codigo, l.edificio, l.piso, l.servico, l.sala, l.ativo
")->fetchAll(PDO::FETCH_OBJ);

    $edificios = $ligacao->query("SELECT DISTINCT edificio FROM localizacoes ORDER BY edificio")->fetchAll(PDO::FETCH_OBJ);
    $servicos = $ligacao->query("SELECT DISTINCT servico FROM localizacoes ORDER BY servico")->fetchAll(PDO::FETCH_OBJ);
    $pisos = $ligacao->query("SELECT DISTINCT piso FROM localizacoes ORDER BY piso")->fetchAll(PDO::FETCH_OBJ);
    $salas = $ligacao->query("SELECT DISTINCT sala FROM localizacoes ORDER BY sala")->fetchAll(PDO::FETCH_OBJ);

    $equipamentosFiltro = $ligacao->query("
        SELECT id, codigo, designacao
        FROM equipamentos
        ORDER BY codigo
    ")->fetchAll(PDO::FETCH_OBJ);

    $erro = '';
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $edificios = [];
    $servicos = [];
    $pisos = [];
    $salas = [];
    $equipamentosFiltro = [];
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Listagem de localizações -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Localizações</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="nova_localizacao.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Nova localização
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre as localizações físicas associadas aos equipamentos médicos.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaLocalizacoes" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por código da localização, edifício, piso, serviço/departamento ou sala/gabinete...">
                    <button type="button" id="botaoPesquisarLocalizacoes" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaLocalizacoes"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEdificioLocalizacao">Edifício</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroEdificioLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($edificios as $edificio) : ?>
                                    <option value="<?= htmlspecialchars($edificio->edificio) ?>"><?= htmlspecialchars($edificio->edificio) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroServicoLocalizacao">Serviço/Departamento</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroServicoLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($servicos as $servico) : ?>
                                    <option value="<?= htmlspecialchars($servico->servico) ?>"><?= htmlspecialchars($servico->servico) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroPisoLocalizacao">Piso</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroPisoLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($pisos as $piso) : ?>
                                    <option value="<?= htmlspecialchars($piso->piso) ?>"><?= htmlspecialchars($piso->piso) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroSalaLocalizacao">Sala/Gabinete</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroSalaLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($salas as $sala) : ?>
                                    <option value="<?= htmlspecialchars($sala->sala) ?>"><?= htmlspecialchars($sala->sala) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEquipamentoLocalizacao">Equipamento associado</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroEquipamentoLocalizacao" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($equipamentosFiltro as $equipamento) : ?>
                                    <option value="<?= htmlspecialchars($equipamento->id) ?>"><?= htmlspecialchars($equipamento->codigo . ' - ' . $equipamento->designacao) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">
                        <label>&nbsp;</label>
                        <button type="button" id="botaoLimparApenasFiltrosLocalizacoes"
                            class="botao-limpar-apenas-filtros" title="Limpar filtros">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>

        </section>

        <div class="acao-exportar-tabela">
            <a href="exportar_excel_localizacoes.php" class="link-exportar-excel">
                <i class="fa-solid fa-file-excel"></i>
                Exportar Listagem das Localizações
            </a>
        </div>

        <!-- Tabela de localizações (DataTables) -->
        <div class="tabela-privada">
            <table id="tabela-localizacoes">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Edifício</th>
                        <th>Piso</th>
                        <th>Serviço/Departamento</th>
                        <th>Sala/Gabinete</th>
                        <th style="display:none;">Equipamentos IDs</th>
                        <th style="display:none;">Equipamentos Nomes</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($erro)) : ?>
                        <tr>
                            <td colspan="6" class="text-center text-danger"><?= $erro ?></td>
                        </tr>
                    <?php elseif (count($resultados) == 0) : ?>
                        <tr>
                            <td colspan="6" class="text-muted">Não existem localizações registadas.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($resultados as $localizacao) : ?>
                            <tr>
                                <td><?= htmlspecialchars($localizacao->codigo) ?></td>
                                <td><?= htmlspecialchars($localizacao->edificio) ?></td>
                                <td><?= htmlspecialchars($localizacao->piso) ?></td>
                                <td><?= htmlspecialchars($localizacao->servico) ?></td>
                                <td><?= htmlspecialchars($localizacao->sala) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($localizacao->equipamentos_ids) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($localizacao->equipamentos_nomes) ?></td>
                                <td class="acoes-tabela-privada">

                                    <a href="/medivault/private/views/localizacoes/consultar_localizacao.php?id_localizacao=<?= aes_encrypt($localizacao->id) ?>" class="acao-tabela-privada" title="Consultar" style="color: #005fae;">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <a href="editar_localizacao.php?id_localizacao=<?= aes_encrypt($localizacao->id) ?>" class="acao-tabela-privada" title="Editar" style="color: #2a9d8f;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <?php if ($localizacao->ativo == 1) : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalEliminarLocalizacao" onclick="prepararEliminacaoLocalizacao('<?= aes_encrypt($localizacao->id) ?>', '<?= htmlspecialchars($localizacao->codigo . ' - ' . $localizacao->servico, ENT_QUOTES) ?>')" title="Eliminar" style="color: #dc3545;">
        <i class="fa-regular fa-trash-can"></i>
    </button>
<?php else : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalReativarLocalizacao" onclick="prepararReativacaoLocalizacao('<?= aes_encrypt($localizacao->id) ?>', '<?= htmlspecialchars($localizacao->codigo . ' - ' . $localizacao->servico, ENT_QUOTES) ?>')" title="Reativar" style="color: #9333ea;">
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

<!-- Modal eliminar localização -->
<div class="modal fade" id="modalEliminarLocalizacao" tabindex="-1" aria-labelledby="tituloModalEliminarLocalizacao"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarLocalizacao">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">
                <p id="textoModalEliminarLocalizacao">
                    Tem a certeza que pretende eliminar esta localização?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoLocalizacao()">
                    Eliminar
                </button>
            </div>

        </div>

    </div>

</div>

<!-- Modal reativar localização -->
<div class="modal fade" id="modalReativarLocalizacao" tabindex="-1" aria-labelledby="tituloModalReativarLocalizacao"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalReativarLocalizacao">
                    <i class="fa-solid fa-rotate-left"></i>
                    Confirmar reativação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>

            </div>

            <div class="modal-body">
                <p id="textoModalReativarLocalizacao">
                    Tem a certeza que pretende reativar esta localização?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn" style="background-color: #9333ea; color: #fff;" onclick="confirmarReativacaoLocalizacao()">
                    Reativar
                </button>
            </div>

        </div>

    </div>

</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    let tabela;

    // Inicialização da tabela de localizações com DataTables (paginação, pesquisa, etc.)
    $(document).ready(function() {
        tabela = $('#tabela-localizacoes').DataTable({
            pageLength: 5,
            pagingType: "full_numbers",
            dom: 'rtip',
            scrollX: true,
            search: {
                smart: false
            },
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
        $('#pesquisaLocalizacoes').on('input', function() {
            tabela.search($(this).val()).draw();
        });

        $('#botaoPesquisarLocalizacoes').on('click', function() {
            tabela.search($('#pesquisaLocalizacoes').val()).draw();
        });

        $('#botaoLimparApenasPesquisaLocalizacoes').on('click', function() {
            $('#pesquisaLocalizacoes').val('');
            tabela.search('').draw();
        });

        // Filtro edifício
        $('#filtroEdificioLocalizacao').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(1).search('').draw();
            } else {
                tabela.column(1).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro piso
        $('#filtroPisoLocalizacao').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(2).search('').draw();
            } else {
                tabela.column(2).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro serviço
        $('#filtroServicoLocalizacao').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(3).search('').draw();
            } else {
                tabela.column(3).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro sala
        $('#filtroSalaLocalizacao').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(4).search('').draw();
            } else {
                tabela.column(4).search('^' + valor + '$', true, false).draw();
            }
        });

        // Filtro equipamento associado
        $('#filtroEquipamentoLocalizacao').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(5).search('').draw();
            } else {
                tabela.column(5).search('(^|,)' + valor + '(,|$)', true, false).draw();
            }
        });

        // Limpar todos os filtros
        $('#botaoLimparApenasFiltrosLocalizacoes').on('click', function() {
            $('#filtroEdificioLocalizacao').val('');
            $('#filtroPisoLocalizacao').val('');
            $('#filtroServicoLocalizacao').val('');
            $('#filtroSalaLocalizacao').val('');
            $('#filtroEquipamentoLocalizacao').val('');
            tabela.columns().search('').draw();
        });
    });

    // Estado e funções de confirmação para eliminar (desativar) uma localização
    let idLocalizacaoEliminarEncriptado = null;

function prepararEliminacaoLocalizacao(idEncriptado, descricao) {
    idLocalizacaoEliminarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalEliminarLocalizacao");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende desativar a localização <strong>${descricao}</strong>?`;
    }
}

function confirmarEliminacaoLocalizacao() {
    if (!idLocalizacaoEliminarEncriptado) {
        return;
    }

    window.location.href = "confirmar_apagar_localizacao.php?id_localizacao=" + encodeURIComponent(idLocalizacaoEliminarEncriptado);
}

// Estado e funções de confirmação para reativar uma localização
let idLocalizacaoReativarEncriptado = null;

function prepararReativacaoLocalizacao(idEncriptado, descricao) {
    idLocalizacaoReativarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalReativarLocalizacao");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende reativar a localização <strong>${descricao}</strong>?`;
    }
}

function confirmarReativacaoLocalizacao() {
    if (!idLocalizacaoReativarEncriptado) {
        return;
    }

    window.location.href = "reativar_localizacao.php?id_localizacao=" + encodeURIComponent(idLocalizacaoReativarEncriptado);
}
</script>

<?php include '../../includes/footer.php'; ?>