<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal -->
    <main class="conteudo-privado">

        <!-- Card dos detalhes da localização -->
        <section class="detalhes-equipamento-privada">

            <!-- Título da ficha -->
            <div class="titulo-detalhes-equipamento">
                <i class="fa-solid fa-location-dot"></i>
                <h1>Detalhes da Localização</h1>
            </div>

            <hr>

            <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                <i class="fa-solid fa-building"></i>
                Dados Gerais
            </h5>

            <div class="grelha-detalhes-equipamento">
                <div class="campo-detalhes">
                    <h3>Código</h3>
                    <p id="detalhe-codigo-localizacao"></p>
                </div>
                <div class="campo-detalhes" style="grid-column: span 2;">
                    <h3>Serviço / Departamento</h3>
                    <p id="detalhe-servico"></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Edifício</h3>
                    <p id="detalhe-edificio"></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Piso</h3>
                    <p id="detalhe-piso"></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Sala / Gabinete</h3>
                    <p id="detalhe-sala"></p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-stethoscope"></i>
                Equipamentos Associados
            </h5>

            <div id="equipamentos-da-localizacao"></div>

            <hr>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-comment-medical"></i>
                Observações da localização
            </h5>

            <div class="campo-detalhes campo-detalhes-largo">
                <h3>Observações</h3>
                <p id="detalhe-observacoes-localizacao"></p>
            </div>

            <div class="botoes-detalhes-equipamento">
                <a href="localizacoes.php" class="botao-voltar-detalhes">
                    <i class="fa-solid fa-arrow-left"></i>
                    Voltar
                </a>
            </div>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>