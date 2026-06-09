<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

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
                <a href="fornecedores.php" class="botao-voltar-detalhes">
                    <i class="fa-solid fa-arrow-left"></i>
                    Voltar
                </a>
            </div>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>