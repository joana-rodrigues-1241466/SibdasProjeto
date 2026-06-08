<!DOCTYPE html> <!-- Define que o documento usa HTML5 -->
<html lang="pt"> <!-- Define o idioma principal da página como português -->

<head> <!-- Início da zona de configurações da página -->
    <meta charset="UTF-8"> <!-- Permite usar acentos e caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->

    <title>Dashboard</title> <!-- Título que aparece no separador do navegador -->

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../../assets/bootstrap/bootstrap.min.css">

    <!-- Font Awesome: biblioteca de ícones usada no projeto -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- CSS próprio do projeto -->
    <link rel="stylesheet" href="../../../assets/css/1241466.css">
</head>

<body class="pagina-privada"> <!-- Corpo da página privada -->

    <!-- Barra superior da área privada -->
    <header class="navbar-privada">

        <div class="logo-privada">
            <img src="../../../assets/imagens/LOGO.png" alt="Logótipo MediVault" class="logo-navbar-privada">
            <span class="nome-navbar-privada">MediVault</span>
        </div>

        <div class="dropdown-utilizador-privado">
            <div style="display:flex; align-items:center; gap:1rem;">

                <button id="botao-historico-navbar" onclick="abrirHistoricoNavbar()" class="botao-historico-navbar">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </button>

                <div class="utilizador-privado">
                    <i class="fa-regular fa-user"></i>
                    <span>Profissional de saúde</span>
                    <i class="fa-solid fa-caret-down"></i>
                </div>

            </div>

            <div class="menu-utilizador-privado">
                <a href="alterar_password.html">
                    <i class="fa-solid fa-key"></i>
                    Alterar password
                </a>

                <a href="../../../public/index.html">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sair
                </a>
            </div>
        </div>

    </header>

    <div id="aviso-garantias-globais" style="display:none;"></div>

    <!-- Layout principal com menu lateral e conteúdo -->
    <div class="layout-privado">

        <!-- Menu lateral da área privada -->
        <aside class="menu-lateral-privada">
            <h2>Menu</h2>

            <nav>
                <a href="../equipamentos/equipamentos.html">
                    <i class="fa-solid fa-stethoscope"></i>
                    Equipamentos
                </a>

                <a href="../fornecedores/fornecedores.html">
                    <i class="fa-solid fa-truck-medical"></i>
                    Fornecedores
                </a>

                <a href="../localizacoes/localizacoes.html">
                    <i class="fa-solid fa-location-dot"></i>
                    Localizações
                </a>

                <a href="../gestao_conteudos/gestao_conteudos.html">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Gestão de Conteúdos
                </a>

                <a href="../dashboard/dashboard.html" class="ativo">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>

                <a href="../../../public/index.html">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sair
                </a>
            </nav>
        </aside>

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
                        <a href="../equipamentos/equipamentos.html" class="link-card-dashboard">Ver detalhes</a>
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
                    <a href="../equipamentos/equipamentos.html" class="botao-card-dashboard">Ver lista</a>
                </div>

                <div class="card-dashboard card-dashboard-grande">
                    <div class="cabecalho-card-dashboard">
                        <h3>Garantias a expirar nos próximos 30 dias</h3>
                        <a href="../equipamentos/equipamentos.html" class="link-card-dashboard">Ver todos</a>
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

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHistorico"
        aria-labelledby="offcanvasHistoricoLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasHistoricoLabel">
                <i class="fa-solid fa-clock-rotate-left" style="color:#0086a8; margin-right:8px;"></i>
                Histórico de movimentações de Equipamentos
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="../../../assets/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- JavaScript próprio do projeto -->
    <script src="../../../assets/js/1241466.js"></script>

</body>

</html>