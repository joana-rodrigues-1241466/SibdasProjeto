<?php
require_once 'includes/funcoes.php';
redirect_if_not_logged();
start_session();
$nome = $_SESSION['utilizador'];
$success_message = $_SESSION['success_message'] ?? '';
unset($_SESSION['success_message']);
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include 'includes/menu.php'; ?>

    <main class="conteudo-privado">

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Bem-vindo, <?= htmlspecialchars($nome) ?></h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>
        </div>

        <p class="mensagem-listagem">Seleciona uma das áreas abaixo ou utiliza o menu lateral para navegar.</p>

        <div class="row g-4 mt-2">
            <div class="col-6 col-lg-3">
                <a href="/medivault/private/views/equipamentos/equipamentos.php" class="card-funcionalidade text-decoration-none d-block">
                    <i class="fa-solid fa-stethoscope icone-funcionalidade"></i>
                    <h3>Equipamentos</h3>
                    <div class="linha-card-funcionalidade"></div>
                    <p>Gerir equipamentos médicos do inventário hospitalar.</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="/medivault/private/views/fornecedores/fornecedores.php" class="card-funcionalidade text-decoration-none d-block">
                    <i class="fa-solid fa-truck-medical icone-funcionalidade"></i>
                    <h3>Fornecedores</h3>
                    <div class="linha-card-funcionalidade"></div>
                    <p>Gerir fornecedores associados aos equipamentos.</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="/medivault/private/views/localizacoes/localizacoes.php" class="card-funcionalidade text-decoration-none d-block">
                    <i class="fa-solid fa-location-dot icone-funcionalidade"></i>
                    <h3>Localizações</h3>
                    <div class="linha-card-funcionalidade"></div>
                    <p>Organizar a localização física dos equipamentos.</p>
                </a>
            </div>
            <div class="col-6 col-lg-3">
                <a href="/medivault/private/views/dashboard/dashboard.php" class="card-funcionalidade text-decoration-none d-block">
                    <i class="fa-solid fa-chart-line icone-funcionalidade"></i>
                    <h3>Dashboard</h3>
                    <div class="linha-card-funcionalidade"></div>
                    <p>Visualizar indicadores e resumo do inventário.</p>
                </a>
            </div>
        </div>

    </main>
</div>

<?php include 'includes/footer.php'; ?>