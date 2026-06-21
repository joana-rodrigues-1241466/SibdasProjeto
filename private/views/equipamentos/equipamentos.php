<?php
// ============================================================
// EQUIPAMENTOS.PHP
// Listagem de todos os equipamentos, com pesquisa, filtros
// (estado, fornecedor, localização, categoria, criticidade),
// exportação para Excel e ações de consultar/editar/
// desativar/reativar cada equipamento.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter a listagem de equipamentos e os valores distintos para os filtros
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
SELECT 
    e.id,
    e.codigo,
    e.designacao,
    l.codigo AS localizacao,
    ee.designacao AS estado,
    c.designacao AS criticidade,
    cat.designacao AS categoria,
    e.ativo,
    GROUP_CONCAT(DISTINCT ef.fornecedor_id) AS fornecedores_ids,
    GROUP_CONCAT(DISTINCT CONCAT(f.codigo, ' - ', f.nome_empresa) SEPARATOR ', ') AS fornecedores_nomes
FROM equipamentos e
LEFT JOIN localizacoes l ON e.localizacao_id = l.id
LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
LEFT JOIN criticidades c ON e.criticidade_id = c.id
LEFT JOIN categorias cat ON e.categoria_id = cat.id
LEFT JOIN equipamento_fornecedor ef ON ef.equipamento_id = e.id
LEFT JOIN fornecedores f ON f.id = ef.fornecedor_id
GROUP BY e.id, e.codigo, e.designacao, l.codigo, ee.designacao, c.designacao, cat.designacao, e.ativo
")->fetchAll(PDO::FETCH_OBJ);

$fornecedoresFiltro = $ligacao->query("
        SELECT id, codigo, nome_empresa
        FROM fornecedores
        ORDER BY codigo
    ")->fetchAll(PDO::FETCH_OBJ);

    $localizacoesFiltro = $ligacao->query("
        SELECT id, codigo
        FROM localizacoes
        ORDER BY codigo
    ")->fetchAll(PDO::FETCH_OBJ);

    $erro = '';
} catch (PDOException $err) {
    $erro = "Aconteceu um erro na ligação.";
    $resultados = [];
    $fornecedoresFiltro = [];
    $localizacoesFiltro = [];
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Listagem de equipamentos -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

    <?php if (isset($_SESSION['sucesso']) && $_SESSION['sucesso'] === 'equipamento_atualizado') : ?>
    <div id="alerta-sucesso" class="alert alert-success text-center" role="alert">
        <i class="fa-solid fa-circle-check"></i>
        Equipamento atualizado com sucesso.
    </div>
    <script>
        setTimeout(function () {
            const alerta = document.getElementById('alerta-sucesso');
            if (alerta) {
                alerta.style.transition = 'opacity 0.5s ease';
                alerta.style.opacity = '0';
                setTimeout(function () { alerta.remove(); }, 500);
            }
        }, 3000);
    </script>
<?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Listagem de Equipamentos</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>

            <a href="novo_equipamento.php" class="botao-novo-registo-privada">
                <i class="fa-solid fa-plus"></i>
                Novo equipamento
            </a>
        </div>

        <p class="mensagem-listagem">
            Consulte, pesquise e filtre os equipamentos médicos registados no inventário hospitalar.
        </p>

        <!-- PESQUISA E FILTROS -->
        <section class="area-pesquisa-filtros">

            <div class="caixa-pesquisa-equipamentos">
                <h2>Pesquisa</h2>

                <div class="linha-pesquisa-equipamentos">
                    <input type="text" id="pesquisaEquipamentos" class="campo-pesquisa-equipamentos"
                        placeholder="Pesquisar por código, designação, marca, modelo, n.º de série, fornecedor ou localização...">

                    <button type="button" id="botaoPesquisarEquipamentos" class="botao-pesquisar-equipamentos">
                        Pesquisar
                    </button>

                    <button type="button" id="botaoLimparApenasPesquisaEquipamentos"
                        class="botao-limpar-equipamentos">
                        Limpar
                    </button>
                </div>
            </div>

            <div class="caixa-filtros-equipamentos">
                <h2>Filtros</h2>

                <div class="grelha-filtros-equipamentos">

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroEstadoEquipamento">
                            Estado atual
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
       <strong>Ativo</strong> - Equipamento operacional e disponível para utilização.<br><br>
       <strong>Em manutenção</strong> - Equipamento temporariamente indisponível devido a manutenção preventiva ou corretiva.<br><br>
       <strong>Inativo</strong> - Equipamento sem utilização atual, mas disponível para voltar ao serviço.<br><br>
       <strong>Em calibração</strong> - Equipamento em processo de calibração ou verificação metrológica.<br><br>
       <strong>Em quarentena</strong> - Equipamento isolado temporariamente para avaliação, descontaminação ou validação técnica.<br><br>
       <strong>Abatido</strong> - Equipamento retirado definitivamente de serviço e sem possibilidade de utilização.
       ">
                            </i>
                        </label>

                        <div class="select-filtro-wrapper">
                            <select id="filtroEstadoEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <option value="Ativo">Ativo</option>
                                <option value="Em manutenção">Em manutenção</option>
                                <option value="Inativo">Inativo</option>
                                <option value="Em calibração">Em calibração</option>
                                <option value="Em quarentena">Em quarentena</option>
                                <option value="Abatido">Abatido</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroFornecedorEquipamento">Fornecedor associado</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroFornecedorEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todos</option>
                                <?php foreach ($fornecedoresFiltro as $fornecedor) : ?>
                                    <option value="<?= htmlspecialchars($fornecedor->id) ?>"><?= htmlspecialchars($fornecedor->codigo . ' - ' . $fornecedor->nome_empresa) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroLocalizacaoEquipamento">Localização associada</label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroLocalizacaoEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <?php foreach ($localizacoesFiltro as $localizacao) : ?>
                                    <option value="<?= htmlspecialchars($localizacao->codigo) ?>"><?= htmlspecialchars($localizacao->codigo) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroCategoriaEquipamento">Categoria
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
        <strong>Monitorização</strong> - Equipamentos utilizados para monitorizar parâmetros fisiológicos e o estado clínico do paciente.<br><br>
        <strong>Suporte de vida</strong> - Equipamentos essenciais para manter ou substituir funções vitais do organismo.<br><br>
        <strong>Terapia</strong> - Equipamentos utilizados na administração de tratamentos e intervenções terapêuticas.<br><br>
        <strong>Diagnóstico</strong> - Equipamentos destinados à deteção, avaliação e diagnóstico de condições clínicas.<br><br>
        <strong>Laboratório</strong> - Equipamentos utilizados na análise e processamento de amostras laboratoriais.<br><br>
        <strong>Esterilização</strong> - Equipamentos destinados à limpeza, desinfeção e esterilização de materiais e dispositivos médicos.<br><br>
        <strong>Reabilitação</strong> - Equipamentos utilizados na recuperação funcional e reabilitação dos pacientes.
        ">
                            </i>
                        </label>
                        <div class="select-filtro-wrapper">
                            <select id="filtroCategoriaEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <option value="Monitorização">Monitorização</option>
                                <option value="Suporte de vida">Suporte de vida</option>
                                <option value="Terapia">Terapia</option>
                                <option value="Diagnóstico">Diagnóstico</option>
                                <option value="Laboratório">Laboratório</option>
                                <option value="Esterilização">Esterilização</option>
                                <option value="Reabilitação">Reabilitação</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos">
                        <label for="filtroCriticidadeEquipamento">Criticidade
                            <i class="fa-solid fa-circle-info" data-bs-toggle="popover"
                                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-html="true"
                                data-bs-content="
        <strong>Suporte de vida</strong> - Equipamento essencial para manter ou monitorizar funções vitais do paciente.<br><br>
        <strong>Alta</strong> - Equipamento cuja indisponibilidade afeta significativamente a prestação de cuidados de saúde.<br><br>
        <strong>Média</strong> - Equipamento importante, mas cuja indisponibilidade pode ser temporariamente compensada por alternativas.<br><br>
        <strong>Baixa</strong> - Equipamento de apoio com impacto reduzido na prestação de cuidados.
        ">
                            </i>
                        </label>

                        <div class="select-filtro-wrapper">
                            <select id="filtroCriticidadeEquipamento" class="campo-filtro-equipamentos">
                                <option value="">Todas</option>
                                <option value="Baixa">Baixa</option>
                                <option value="Média">Média</option>
                                <option value="Alta">Alta</option>
                                <option value="Suporte de vida">Suporte de vida</option>
                            </select>
                        </div>
                    </div>

                    <div class="grupo-filtro-equipamentos grupo-botao-limpar-filtros">
                        <label>&nbsp;</label>
                        <button type="button" id="botaoLimparApenasFiltrosEquipamentos"
                            class="botao-limpar-apenas-filtros" title="Limpar filtros">
                            <i class="fa-solid fa-filter-circle-xmark"></i>
                        </button>
                    </div>

                </div>
            </div>

        </section>

        <div class="acao-exportar-tabela">
            <a href="exportar_excel_equipamentos.php" class="link-exportar-excel">
                <i class="fa-solid fa-file-excel"></i>
                Exportar Listagem dos Equipamentos
            </a>
        </div>

        <!-- Tabela de equipamentos (DataTables) -->
        <div class="tabela-privada">
            <table id="tabela-equipamentos">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Designação</th>
                        <th>Localização</th>
                        <th>Estado atual</th>
                        <th>Criticidade</th>
                        <th style="display:none;">Categoria</th>
                        <th style="display:none;">Fornecedores IDs</th>
                        <th style="display:none;">Fornecedores Nomes</th>
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
                            <td colspan="6" class="text-muted">Não existem equipamentos registados.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($resultados as $equipamento) : ?>
                            <tr>
                                <td><?= htmlspecialchars($equipamento->codigo) ?></td>
                                <td><?= htmlspecialchars($equipamento->designacao) ?></td>
                                <td><?= htmlspecialchars($equipamento->localizacao) ?></td>
                                <td>
                                    <?php
                                    // Mapa de classes CSS para colorir o estado do equipamento
                                    $classesEstado = [
                                        'Ativo' => 'estado-ativo',
                                        'Em manutenção' => 'estado-manutencao',
                                        'Em calibração' => 'estado-calibracao',
                                        'Inativo' => 'estado-inativo',
                                        'Em quarentena' => 'estado-quarentena',
                                        'Abatido' => 'estado-abatido'
                                    ];
                                    $classeEstado = $classesEstado[$equipamento->estado] ?? '';
                                    ?>
                                    <span class="<?= $classeEstado ?>"><?= htmlspecialchars($equipamento->estado) ?></span>
                                </td>
                                <td>
                                    <?php
                                    // Mapa de classes CSS para colorir a criticidade do equipamento
                                    $classesCriticidade = [
                                        'Suporte de vida' => 'badge-criticidade-suporte',
                                        'Alta' => 'badge-criticidade-alta',
                                        'Média' => 'badge-criticidade-media',
                                        'Baixa' => 'badge-criticidade-baixa'
                                    ];
                                    $classeCriticidade = $classesCriticidade[$equipamento->criticidade] ?? '';
                                    ?>
                                    <span class="badge-detalhe <?= $classeCriticidade ?>"><?= htmlspecialchars($equipamento->criticidade) ?></span>
                                </td>

                                <td style="display:none;"><?= htmlspecialchars($equipamento->categoria) ?></td>

                                <td style="display:none;"><?= htmlspecialchars($equipamento->fornecedores_ids) ?></td>
                                <td style="display:none;"><?= htmlspecialchars($equipamento->fornecedores_nomes) ?></td>

                                <td class="acoes-tabela-privada">
                                    <a href="/medivault/private/views/equipamentos/consultar_equipamento.php?id_equipamento=<?= aes_encrypt($equipamento->id) ?>" class="acao-tabela-privada" title="Consultar" style="color: #005fae;">
    <i class="fa-regular fa-eye"></i>
</a>
                                    <a href="editar_equipamento.php?id_equipamento=<?= aes_encrypt($equipamento->id) ?>" class="acao-tabela-privada" title="Editar" style="color: #2a9d8f;">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <?php if ($equipamento->ativo == 1) : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalEliminarEquipamento" onclick="prepararEliminacaoEquipamento('<?= aes_encrypt($equipamento->id) ?>', '<?= htmlspecialchars($equipamento->designacao, ENT_QUOTES) ?>')" title="Eliminar" style="color: #dc3545;">
        <i class="fa-regular fa-trash-can"></i>
    </button>
<?php else : ?>
    <button class="acao-tabela-privada botao-acao-tabela" data-bs-toggle="modal" data-bs-target="#modalReativarEquipamento" onclick="prepararReativacaoEquipamento('<?= aes_encrypt($equipamento->id) ?>', '<?= htmlspecialchars($equipamento->designacao, ENT_QUOTES) ?>')" title="Reativar" style="color: #9333ea;">
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

<!-- Modal eliminar equipamento -->
<div class="modal fade" id="modalEliminarEquipamento" tabindex="-1" aria-labelledby="tituloModalEliminarEquipamento"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalEliminarEquipamento">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar eliminação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">

                <p id="textoModalEliminarEquipamento">
                    Tem a certeza que pretende eliminar este equipamento?
                </p>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-danger" onclick="confirmarEliminacaoEquipamento()">
                    Eliminar
                </button>

            </div>

        </div>

    </div>

</div>

<!-- Modal reativar equipamento -->
<div class="modal fade" id="modalReativarEquipamento" tabindex="-1" aria-labelledby="tituloModalReativarEquipamento"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="tituloModalReativarEquipamento">
                    <i class="fa-solid fa-rotate-left"></i>
                    Confirmar reativação
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <div class="modal-body">
                <p id="textoModalReativarEquipamento">
                    Tem a certeza que pretende reativar este equipamento?
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn" style="background-color: #9333ea; color: #fff;" onclick="confirmarReativacaoEquipamento()">
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
    $(document).ready(function() {
        // Inicialização da tabela de equipamentos com DataTables (paginação, pesquisa, etc.)
        var tabela = $('#tabela-equipamentos').DataTable({
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
                },
                aria: {
                    sortAscending: ": ative para classificar a coluna em ordem crescente.",
                    sortDescending: ": ative para classificar a coluna em ordem decrescente."
                }
            }
        });

        // Ligar caixa de pesquisa ao DataTables
        $('#pesquisaEquipamentos').on('input', function() {
            tabela.search($(this).val()).draw();
        });

        $('#botaoPesquisarEquipamentos').on('click', function() {
            tabela.search($('#pesquisaEquipamentos').val()).draw();
        });

        $('#botaoLimparApenasPesquisaEquipamentos').on('click', function() {
            $('#pesquisaEquipamentos').val('');
            tabela.search('').draw();
        });

        // Ligar filtro de estado ao DataTables
        $('#filtroEstadoEquipamento').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(3).search('').draw();
            } else {
                tabela.column(3).search('^' + valor + '$', true, false).draw();
            }
        });

        // Ligar filtro de criticidade ao DataTables
        $('#filtroCriticidadeEquipamento').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(4).search('').draw();
            } else {
                tabela.column(4).search('^' + valor + '$', true, false).draw();
            }
        });

        // Ligar filtro de categoria ao DataTables
        $('#filtroCategoriaEquipamento').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(5).search('').draw();
            } else {
                tabela.column(5).search('^' + valor + '$', true, false).draw();
            }
        });

        // Ligar filtro de fornecedor ao DataTables
        $('#filtroFornecedorEquipamento').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(6).search('').draw();
            } else {
                tabela.column(6).search('(^|,)' + valor + '(,|$)', true, false).draw();
            }
        });

        // Ligar filtro de localização ao DataTables
        $('#filtroLocalizacaoEquipamento').on('change', function() {
            var valor = $(this).val();
            if (valor === '') {
                tabela.column(2).search('').draw();
            } else {
                tabela.column(2).search('^' + valor + '$', true, false).draw();
            }
        });

       // Limpar filtros
        $('#botaoLimparApenasFiltrosEquipamentos').on('click', function() {
            $('#filtroEstadoEquipamento').val('');
            $('#filtroCriticidadeEquipamento').val('');
            $('#filtroCategoriaEquipamento').val('');
            $('#filtroFornecedorEquipamento').val('');
            $('#filtroLocalizacaoEquipamento').val('');
            tabela.columns().search('').draw();
        });

        // Reinicializar popovers
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function(el) {
            new bootstrap.Popover(el);
        });
    });

    // Estado e funções de confirmação para eliminar (desativar) um equipamento
    let idEquipamentoEliminarEncriptado = null;

function prepararEliminacaoEquipamento(idEncriptado, designacao) {
    idEquipamentoEliminarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalEliminarEquipamento");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende desativar o equipamento <strong>${designacao}</strong>?`;
    }
}

function confirmarEliminacaoEquipamento() {
    if (!idEquipamentoEliminarEncriptado) {
        return;
    }

    window.location.href = "confirmar_apagar_equipamento.php?id_equipamento=" + encodeURIComponent(idEquipamentoEliminarEncriptado);
}

// Estado e funções de confirmação para reativar um equipamento
let idEquipamentoReativarEncriptado = null;

function prepararReativacaoEquipamento(idEncriptado, designacao) {
    idEquipamentoReativarEncriptado = idEncriptado;
    const textoModal = document.getElementById("textoModalReativarEquipamento");
    if (textoModal) {
        textoModal.innerHTML =
            `Tem a certeza que pretende reativar o equipamento <strong>${designacao}</strong>?`;
    }
}

function confirmarReativacaoEquipamento() {
    if (!idEquipamentoReativarEncriptado) {
        return;
    }

    window.location.href = "reativar_equipamento.php?id_equipamento=" + encodeURIComponent(idEquipamentoReativarEncriptado);
}
</script>

<?php include '../../includes/footer.php'; ?>