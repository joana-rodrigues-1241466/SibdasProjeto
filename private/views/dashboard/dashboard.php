<?php
// ============================================================
// DASHBOARD.PHP
// Painel de indicadores com uma visão rápida do estado global
// do parque tecnológico: totais por estado, distribuição por
// serviço/categoria, equipamentos de criticidade elevada e
// garantias a expirar nos próximos 30 dias.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Calcular todos os indicadores e dados dos gráficos apresentados na dashboard
try {
    $ligacao = conectar_bd();

    // Indicadores principais
    $totalEquipamentos = $ligacao->query("SELECT COUNT(*) FROM equipamentos WHERE ativo = 1")->fetchColumn();

    $equipamentosAtivos = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        JOIN estados_equipamento ee ON e.estado_id = ee.id
        WHERE e.ativo = 1 AND ee.designacao = 'Ativo'
    ")->fetchColumn();

    $equipamentosManutencao = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        JOIN estados_equipamento ee ON e.estado_id = ee.id
        WHERE e.ativo = 1 AND ee.designacao = 'Em manutenção'
    ")->fetchColumn();

    $equipamentosInativos = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        JOIN estados_equipamento ee ON e.estado_id = ee.id
        WHERE e.ativo = 1 AND ee.designacao = 'Inativo'
    ")->fetchColumn();

    $garantiasExpiradas = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        JOIN garantias_equipamentos g ON g.equipamento_id = e.id
        WHERE e.ativo = 1 AND g.data_fim < CURDATE()
    ")->fetchColumn();

    $semDocumentacao = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        WHERE e.ativo = 1
        AND NOT EXISTS (SELECT 1 FROM documentacao_equipamentos de WHERE de.equipamento_id = e.id)
    ")->fetchColumn();

    // Equipamentos por serviço (top 6, para o gráfico de barras)
    $servicosChart = $ligacao->query("
        SELECT COALESCE(l.servico, 'Não definido') AS servico, COUNT(*) AS total
        FROM equipamentos e
        LEFT JOIN localizacoes l ON e.localizacao_id = l.id
        WHERE e.ativo = 1
        GROUP BY servico
        ORDER BY total DESC
        LIMIT 6
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Calcular a altura em pixéis de cada barra, proporcional ao valor máximo
    $maximoServico = !empty($servicosChart) ? max(array_column($servicosChart, 'total')) : 1;
    $alturaMaximaPx = 160;
    foreach ($servicosChart as &$s) {
        $s['altura'] = max((int) round(($s['total'] / $maximoServico) * $alturaMaximaPx), 8);
    }
    unset($s);

    // Distribuição por categoria
    $categoriasChart = $ligacao->query("
        SELECT COALESCE(cat.designacao, 'Não definida') AS categoria, COUNT(*) AS total
        FROM equipamentos e
        LEFT JOIN categorias cat ON e.categoria_id = cat.id
        WHERE e.ativo = 1
        GROUP BY categoria
        ORDER BY total DESC
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Criticidade elevada (Alta + Suporte de vida)
    $criticidadeElevada = $ligacao->query("
        SELECT COUNT(*) FROM equipamentos e
        JOIN criticidades c ON e.criticidade_id = c.id
        WHERE e.ativo = 1 AND c.designacao IN ('Alta', 'Suporte de vida')
    ")->fetchColumn();

    $percentagemCriticidade = $totalEquipamentos > 0 ? round(($criticidadeElevada / $totalEquipamentos) * 100) : 0;

    // Garantias a expirar nos próximos 30 dias
    $garantiasAExpirar = $ligacao->query("
        SELECT
            e.codigo,
            e.designacao,
            g.data_fim,
            DATEDIFF(g.data_fim, CURDATE()) AS dias_restantes,
            (
                SELECT f.nome_empresa
                FROM equipamento_fornecedor ef
                JOIN fornecedores f ON f.id = ef.fornecedor_id
                WHERE ef.equipamento_id = e.id
                ORDER BY f.codigo
                LIMIT 1
            ) AS fornecedor
        FROM equipamentos e
        JOIN garantias_equipamentos g ON g.equipamento_id = e.id
        WHERE e.ativo = 1
        AND g.data_fim BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
        ORDER BY g.data_fim ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

    $erroDashboard = '';
} catch (PDOException $e) {
    $erroDashboard = "Erro ao carregar os dados da dashboard: " . $e->getMessage();
    $totalEquipamentos = $equipamentosAtivos = $equipamentosManutencao = $equipamentosInativos = 0;
    $garantiasExpiradas = $semDocumentacao = $criticidadeElevada = $percentagemCriticidade = 0;
    $servicosChart = $categoriasChart = $garantiasAExpirar = [];
}

$ligacao = null;

// Paleta de cores usada no gráfico de barras por serviço
$coresServicos = ['#005fae', '#0086a8', '#2a9d8f', '#f4a261', '#e76f51', '#7b61ff'];
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Painel de indicadores (dashboard) -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Dashboard</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>
        </div>

        <p class="mensagem-listagem">
            Visão rápida e sintética do estado global do parque tecnológico hospitalar.
        </p>

        <?php if (!empty($erroDashboard)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erroDashboard) ?></div>
        <?php endif; ?>

        <!-- INDICADORES PRINCIPAIS -->
        <section class="grelha-indicadores-dashboard">

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard azul">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <div>
                    <p>Total de equipamentos</p>
                    <h2 id="totalEquipamentosDashboard"><?= $totalEquipamentos ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard verde">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <p>Equipamentos ativos</p>
                    <h2 id="equipamentosAtivosDashboard"><?= $equipamentosAtivos ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard laranja">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <div>
                    <p>Em manutenção</p>
                    <h2 id="equipamentosManutencaoDashboard"><?= $equipamentosManutencao ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard cinzento">
                    <i class="fa-solid fa-pause"></i>
                </div>
                <div>
                    <p>Equipamentos inativos</p>
                    <h2 id="equipamentosInativosDashboard"><?= $equipamentosInativos ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard vermelho">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <p>Garantia expirada</p>
                    <h2 id="garantiasExpiradasDashboard"><?= $garantiasExpiradas ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard roxo">
                    <i class="fa-solid fa-file-circle-xmark"></i>
                </div>
                <div>
                    <p>Sem documentação</p>
                    <h2 id="semDocumentacaoDashboard"><?= $semDocumentacao ?></h2>
                    <span>equipamentos</span>
                </div>
            </div>

        </section>

        <!-- ÁREA PRINCIPAL DA DASHBOARD -->
        <section class="grelha-dashboard">

            <div class="card-dashboard card-dashboard-grande">
                <div class="cabecalho-card-dashboard">
                    <h3>Equipamentos por serviço</h3>
                    <a href="/medivault/private/views/equipamentos/equipamentos.php" class="link-card-dashboard">Ver detalhes</a>
                </div>
                <div id="graficoServicosDashboard" class="grafico-barras-dashboard">
                    <?php if (empty($servicosChart)) : ?>
                        <p class="text-muted">Sem dados de serviços.</p>
                    <?php else : ?>
                        <div style="display:flex; align-items:flex-end; gap:1.4rem; height:200px; border-bottom:1px solid #d7e1ec; width:100%;">
                            <?php foreach ($servicosChart as $s) : ?>
                                <div class="barra-servico-dashboard" style="height:100%;">
                                    <span class="valor"><?= $s['total'] ?></span>
                                    <div class="barra" style="height: <?= $s['altura'] ?>px;"></div>
                                    <span class="label"><?= htmlspecialchars($s['servico']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card-dashboard card-criticidade-dashboard">
                <h3>Equipamentos de criticidade elevada
                    <i class="fa-solid fa-circle-info" data-bs-toggle="popover" data-bs-trigger="hover focus"
                        data-bs-placement="top" data-bs-html="true"
                        data-bs-content="Este indicador inclui todos os equipamentos classificados com criticidade <strong>Suporte de vida</strong> ou <strong>Alta</strong>, por apresentarem maior impacto na prestação de cuidados de saúde em caso de indisponibilidade.">
                    </i>
                </h3>
                <div class="numero-destaque-dashboard criticidade-conteudo-dashboard">
                    <div class="icone-criticidade-dashboard">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h2 id="dashboardCriticidadeElevada"><?= $criticidadeElevada ?></h2>
                    <p>equipamentos</p>
                    <span id="dashboardPercentagemCriticidade"><?= $percentagemCriticidade ?>% do total</span>
                </div>
                <a href="/medivault/private/views/equipamentos/equipamentos.php" class="link-card-dashboard">Ver lista</a>
            </div>

            <div class="card-dashboard card-dashboard-grande">
                <div class="cabecalho-card-dashboard">
                    <h3>Garantias a expirar nos próximos 30 dias</h3>
                    <a href="/medivault/private/views/equipamentos/equipamentos.php" class="link-card-dashboard">Ver todos</a>
                </div>
                <table class="tabela-dashboard">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Designação</th>
                            <th>Fornecedor</th>
                            <th>Fim da garantia</th>
                            <th>Dias restantes</th>
                        </tr>
                    </thead>
                    <tbody id="tabelaGarantiasDashboard">
                        <?php if (empty($garantiasAExpirar)) : ?>
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma garantia a expirar nos próximos 30 dias.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($garantiasAExpirar as $g) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($g['codigo']) ?></td>
                                    <td><?= htmlspecialchars($g['designacao']) ?></td>
                                    <td><?= htmlspecialchars($g['fornecedor'] ?? 'Não definido') ?></td>
                                    <td><?= date('d/m/Y', strtotime($g['data_fim'])) ?></td>
                                    <td><?= $g['dias_restantes'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-dashboard">
                <h3>Distribuição por categoria</h3>
                <div id="categoriasDashboard" class="lista-distribuicao-dashboard">
                    <?php foreach ($categoriasChart as $cat) : ?>
                        <?php $percentagemCat = $totalEquipamentos > 0 ? round(($cat['total'] / $totalEquipamentos) * 100) : 0; ?>
                        <div class="item-distribuicao-dashboard">
                            <span class="nome"><?= htmlspecialchars($cat['categoria']) ?></span>
                            <span class="valor"><?= $cat['total'] ?> (<?= $percentagemCat ?>%)</span>
                            <div class="barra-distribuicao-dashboard">
                                <span style="width: <?= $percentagemCat ?>%;"></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>

        <div class="rodape-dashboard">
            <span id="ultimaAtualizacaoDashboard">Última atualização: <?= date('d/m/Y H:i') ?></span>

            <button type="button" onclick="location.reload()" class="botao-atualizar-dashboard">
                <i class="fa-solid fa-rotate-right"></i>
                Atualizar
            </button>
        </div>

    </main>

</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    // Ativar os popovers do Bootstrap (tooltips informativos)
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
            new bootstrap.Popover(el);
        });
    });
</script>

<?php include '../../includes/footer.php'; ?>