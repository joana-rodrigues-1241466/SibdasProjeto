<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-plus"></i>
                    Inserir nova localização
                </h1>
            </div>

            <hr>

            <form id="form-nova-localizacao" class="form-equipamento-privado">

                <!-- DADOS GERAIS -->
                <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                    <i class="fa-solid fa-location-dot"></i>
                    Dados Gerais
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código da localização</label>
                        <input type="text" class="form-control campo-formulario-privado" id="codigo" name="codigo">
                    </div>
                    <div class="col-md-8">
                        <label for="servico" class="form-label">Serviço / Departamento</label>
                        <input type="text" class="form-control campo-formulario-privado" id="servico"
                            name="servico">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="edificio" class="form-label">Edifício</label>
                        <input type="text" class="form-control campo-formulario-privado" id="edificio"
                            name="edificio">
                    </div>
                    <div class="col-md-4">
                        <label for="piso" class="form-label">Piso</label>
                        <input type="text" class="form-control campo-formulario-privado" id="piso" name="piso">
                    </div>
                    <div class="col-md-4">
                        <label for="sala" class="form-label">Sala / Gabinete</label>
                        <input type="text" class="form-control campo-formulario-privado" id="sala" name="sala">
                    </div>
                </div>

                <hr>

                <!-- OBSERVAÇÕES -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h5>

                <div class="mb-3">
                    <textarea class="form-control campo-formulario-privado" id="observacoes" name="observacoes"
                        rows="4"></textarea>
                </div>

                <div id="erros-formulario" class="erros-separador" style="display:none;">
                    <ul id="lista-erros-formulario"></ul>
                </div>

                <div class="botoes-formulario-privado">
                    <a href="localizacoes.php" class="botao-cancelar-privado">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="botao-guardar-privado">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar
                    </button>
                </div>

            </form>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>