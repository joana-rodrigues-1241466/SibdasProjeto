<?php
// ============================================================
// HOME.PHP
// Página inicial da área privada, apresentada após o login.
// Mostra um conjunto de "cards" de atalho para as principais
// funcionalidades, filtrados consoante o perfil do utilizador
// em sessão.
// ============================================================

require_once 'includes/funcoes.php';
redirect_if_not_logged();
start_session();

// Dados do utilizador em sessão e mensagem de sucesso (ex: vinda do login)
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

        <?php if (!empty($success_message)) : ?>
        <div id="alerta-sucesso" class="alert alert-success text-center" role="alert">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars($success_message) ?>
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
        <?php endif; ?>

        <p class="mensagem-listagem">Seleciona uma das áreas abaixo ou utiliza o menu lateral para navegar.</p>

        <!-- Cards de atalho, visíveis consoante o perfil do utilizador -->
        <div class="row g-4 mt-2">
            <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico', 'Profissional de Saúde'])) : ?>
                <div class="col-6 col-lg-3">
                    <a href="<?= BASE_URL ?>/private/views/equipamentos/equipamentos.php" class="card-funcionalidade text-decoration-none d-block">
                        <i class="fa-solid fa-stethoscope icone-funcionalidade"></i>
                        <h3>Equipamentos</h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p>Gerir equipamentos médicos do inventário hospitalar.</p>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico'])) : ?>
                <div class="col-6 col-lg-3">
                    <a href="<?= BASE_URL ?>/private/views/fornecedores/fornecedores.php" class="card-funcionalidade text-decoration-none d-block">
                        <i class="fa-solid fa-truck-medical icone-funcionalidade"></i>
                        <h3>Fornecedores</h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p>Gerir fornecedores associados aos equipamentos.</p>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico', 'Profissional de Saúde'])) : ?>
                <div class="col-6 col-lg-3">
                    <a href="<?= BASE_URL ?>/private/views/localizacoes/localizacoes.php" class="card-funcionalidade text-decoration-none d-block">
                        <i class="fa-solid fa-location-dot icone-funcionalidade"></i>
                        <h3>Localizações</h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p>Organizar a localização física dos equipamentos.</p>
                    </a>
                </div>
            <?php endif; ?>

            <div class="col-6 col-lg-3">
                <a href="<?= BASE_URL ?>/private/views/dashboard/dashboard.php" class="card-funcionalidade text-decoration-none d-block">
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