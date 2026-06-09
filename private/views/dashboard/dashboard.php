<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

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

        <!-- INDICADORES PRINCIPAIS -->
        <section class="grelha-indicadores-dashboard">

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard azul">
                    <i class="fa-solid fa-desktop"></i>
                </div>
                <div>
                    <p>Total de equipamentos</p>
                    <h2 id="totalEquipamentosDashboard">0</h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard verde">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div>
                    <p>Equipamentos ativos</p>
                    <h2 id="equipamentosAtivosDashboard">0</h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard laranja">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <div>
                    <p>Em manutenção</p>
                    <h2 id="equipamentosManutencaoDashboard">0</h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard cinzento">
                    <i class="fa-solid fa-pause"></i>
                </div>
                <div>
                    <p>Equipamentos inativos</p>
                    <h2 id="equipamentosInativosDashboard">0</h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard vermelho">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <p>Garantia expirada</p>
                    <h2 id="garantiasExpiradasDashboard">0</h2>
                    <span>equipamentos</span>
                </div>
            </div>

            <div class="card-indicador-dashboard">
                <div class="icone-indicador-dashboard roxo">
                    <i class="fa-solid fa-file-circle-xmark"></i>
                </div>
                <div>
                    <p>Sem documentação</p>
                    <h2 id="semDocumentacaoDashboard">0</h2>
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
                <div id="graficoServicosDashboard" class="grafico-barras-dashboard"></div>
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
                    <h2 id="dashboardCriticidadeElevada">0</h2>
                    <p>equipamentos</p>
                    <span id="dashboardPercentagemCriticidade">0% do total</span>
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
                    <tbody id="tabelaGarantiasDashboard"></tbody>
                </table>
            </div>

            <div class="card-dashboard">
                <h3>Distribuição por categoria</h3>
                <div id="categoriasDashboard" class="lista-distribuicao-dashboard"></div>
            </div>

        </section>

        <div class="rodape-dashboard">
            <span id="ultimaAtualizacaoDashboard"></span>

            <button type="button" onclick="inicializarDashboard()" class="botao-atualizar-dashboard">
                <i class="fa-solid fa-rotate-right"></i>
                Atualizar
            </button>
        </div>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>