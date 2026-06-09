<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <main class="conteudo-privado">

        <section class="gestao-conteudos">

            <h1 class="titulo-secao text-start">Gestão de Conteúdos</h1>
            <div class="linha-titulo"></div>

            <p class="texto-gestao">
                Nesta área reservada é possível atualizar conteúdos apresentados na área pública da MediVault,
                sem necessidade de editar diretamente o HTML.
            </p>

            <form class="form-gestao-conteudos">

                <div class="accordion accordion-gestao" id="accordionGestao">

                    <!-- HOME -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingHome">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseHome" aria-expanded="true" aria-controls="collapseHome">
                                Secção Home
                            </button>
                        </h2>

                        <div id="collapseHome" class="accordion-collapse collapse show"
                            aria-labelledby="headingHome" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-home-titulo" class="form-label">Título principal</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-home-titulo">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-home-texto" class="form-label">Texto introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-home-texto" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-home-botao" class="form-label">Texto do botão</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-home-botao">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- SOBRE -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSobre">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSobre" aria-expanded="false" aria-controls="collapseSobre">
                                Secção Sobre
                            </button>
                        </h2>

                        <div id="collapseSobre" class="accordion-collapse collapse" aria-labelledby="headingSobre"
                            data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-sobre-titulo" class="form-label">Título da secção</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-sobre-titulo">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-1" class="form-label">Texto 1</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-1" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-2" class="form-label">Texto 2</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-2" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-3" class="form-label">Texto 3</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-3" rows="3"></textarea>
                                </div>

                                <hr>

                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Card informativo da secção Sobre</h6>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-titulo" class="form-label">Título do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-titulo">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-1" class="form-label">Frase 1 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-1">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-2" class="form-label">Frase 2 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-2">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-3" class="form-label">Frase 3 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-3">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-4" class="form-label">Frase 4 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-4">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- FUNCIONALIDADES -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFuncionalidades">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFuncionalidades" aria-expanded="false"
                                aria-controls="collapseFuncionalidades">
                                Secção Funcionalidades
                            </button>
                        </h2>

                        <div id="collapseFuncionalidades" class="accordion-collapse collapse"
                            aria-labelledby="headingFuncionalidades" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-funcionalidades-titulo" class="form-label">Título da
                                        secção</label>
                                    <input type="text" class="form-control campo-contacto"
                                        id="editar-funcionalidades-titulo">
                                </div>

                                <div class="mb-4">
                                    <label for="editar-funcionalidades-texto" class="form-label">Texto
                                        introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-funcionalidades-texto"
                                        rows="3"></textarea>
                                </div>

                                <hr>

                                <h5 class="subtitulo-gestao">Cards de funcionalidades</h5>

                                <!-- FUNCIONALIDADE 1 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 1</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-1"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-1">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-1" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-1" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 2 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 2</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-2"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-2">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-2" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-2" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 3 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 3</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-3"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-3">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-3" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-3" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 4 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 4</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-4"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-4">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-4" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-4" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 5 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 5</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-5"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-5">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-5" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-5" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 6 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 6</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-6"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-6">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-6" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-6" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 7 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 7</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-7"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-7">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-7" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-7" rows="3"></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 8 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 8</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-8"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-8">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-8" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-8" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- CONTACTOS -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingContactos">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseContactos" aria-expanded="false"
                                aria-controls="collapseContactos">
                                Secção Contactos
                            </button>
                        </h2>

                        <div id="collapseContactos" class="accordion-collapse collapse"
                            aria-labelledby="headingContactos" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-contactos-titulo" class="form-label">Título da
                                        secção</label>
                                    <input type="text" class="form-control campo-contacto"
                                        id="editar-contactos-titulo">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-contactos-texto" class="form-label">Texto
                                        introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-contactos-texto"
                                        rows="3"></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RODAPÉ -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRodape">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRodape" aria-expanded="false"
                                aria-controls="collapseRodape">
                                Rodapé
                            </button>
                        </h2>

                        <div id="collapseRodape" class="accordion-collapse collapse" aria-labelledby="headingRodape"
                            data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-localizacao" class="form-label">Localização</label>
                                    <textarea class="form-control campo-contacto" id="editar-localizacao" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-horario" class="form-label">Horário</label>
                                    <textarea class="form-control campo-contacto" id="editar-horario" rows="3"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-email" class="form-label">Email</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-email">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-telefone">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="botoes-gestao">
                    <button type="submit" class="btn botao-principal">
                        Guardar Alterações
                    </button>

                    <button type="button" class="btn botao-secundario-gestao" id="repor-conteudos">
                        Repor Conteúdos Originais
                    </button>
                </div>

            </form>

            <a href="/medivault/public/index.php" class="voltar-inicio">
                <i class="fa-solid fa-arrow-left"></i>
                Voltar à página pública
            </a>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>