<!DOCTYPE html> <!-- Define que o documento usa HTML5 -->
<html lang="pt"> <!-- Define o idioma principal da página como português -->

<head> <!-- Início da zona de configurações da página -->
    <meta charset="UTF-8"> <!-- Permite usar acentos e caracteres especiais -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Torna a página responsiva -->

    <title>Consultar Fornecedor</title> <!-- Título que aparece no separador do navegador -->

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

                <a href="../fornecedores/fornecedores.html" class="ativo">
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

                <a href="../dashboard/dashboard.html">
                    <i class="fa-solid fa-chart-line"></i>
                    Dashboard
                </a>

                <a href="../../../public/index.html">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Sair
                </a>
            </nav>
        </aside>

        <!-- Conteúdo principal -->
        <main class="conteudo-privado">

            <!-- Card dos detalhes do fornecedor -->
            <section class="detalhes-equipamento-privada">

                <!-- Título da ficha -->
                <div class="titulo-detalhes-equipamento">
                    <i class="fa-solid fa-truck-medical"></i>
                    <h1>Detalhes do Fornecedor</h1>
                </div>

                <hr>

                <!-- Dados Gerais -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-building"></i>
                    Dados Gerais
                </h5>

                <div class="grelha-detalhes-equipamento">

                    <div class="campo-detalhes">
                        <h3>Código do fornecedor</h3>
                        <p id="detalhe-codigo-fornecedor"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Nome da empresa</h3>
                        <p id="detalhe-nome-empresa"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>NIF</h3>
                        <p id="detalhe-nif"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Tipo de fornecedor</h3>
                        <p id="detalhe-tipo-fornecedor"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Website geral</h3>
                        <p id="detalhe-website"></p>
                    </div>

                </div>

                <!-- Contactos -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-phone"></i>
                    Contactos
                </h5>

                <div class="grelha-detalhes-equipamento">

                    <div class="campo-detalhes">
                        <h3>Contacto telefónico geral</h3>
                        <p id="detalhe-telefone"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Email geral</h3>
                        <p id="detalhe-email"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Pessoa de contacto</h3>
                        <p id="detalhe-pessoa-contacto"></p>
                    </div>

                    <div class="campo-detalhes">
                        <h3>Telefone da pessoa de contacto</h3>
                        <p id="detalhe-telefone-pessoa-contacto"></p>
                    </div>

                </div>

                <!-- Localização -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-location-dot"></i>
                    Localização
                </h5>

                <div class="grelha-detalhes-equipamento">

                    <div class="campo-detalhes">
                        <h3>Morada</h3>
                        <p id="detalhe-morada"></p>
                    </div>

                </div>

                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-stethoscope"></i>
                    Equipamentos Associados
                </h5>

                <div id="equipamentos-do-fornecedor"></div>

                <hr>

                <!-- Documentação do Fornecedor -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-file-medical"></i>
                    Documentação do Fornecedor
                </h5>

                <div class="accordion-documentacao">

                    <div class="accordion-item-doc">
                        <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                            <span>
                                <i class="fa-solid fa-file-medical"></i>
                                Documentação associada ao fornecedor
                            </span>
                            <div class="accordion-btn-doc-direita">
                                <span id="badge-accordion-doc-fornecedor-detalhe" class="badge-accordion-doc"></span>
                                <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                            </div>
                        </button>
                        <div class="accordion-body-doc" style="display:none;">
                            <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                <div class="campo-detalhes">
                                    <h3>Tipo de documento</h3>
                                    <p id="detalhe-tipo-doc-fornecedor"></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Nome do documento</h3>
                                    <p id="detalhe-nome-doc-fornecedor"></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Data do documento</h3>
                                    <p id="detalhe-data-doc-fornecedor"></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Validade</h3>
                                    <p id="detalhe-validade-doc-fornecedor"></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Ficheiro PDF</h3>
                                    <p id="detalhe-ficheiro-doc-fornecedor"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Observações -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h5>

                <div class="grelha-detalhes-equipamento">

                    <div class="campo-detalhes campo-detalhes-largo">
                        <h3>Observações</h3>
                        <p id="detalhe-observacoes-fornecedor"></p>
                    </div>

                </div>

                <!-- Botões -->
                <div class="botoes-detalhes-equipamento">
                    <a href="fornecedores.html" class="botao-voltar-detalhes">
                        <i class="fa-solid fa-arrow-left"></i>
                        Voltar
                    </a>
                </div>

            </section>

        </main>

    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHistorico" aria-labelledby="offcanvasHistoricoLabel">
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