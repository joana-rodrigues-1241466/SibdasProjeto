<?php
require_once __DIR__ . '/funcoes.php';
redirect_if_not_logged();
start_session();
$nome = $_SESSION['utilizador'];

$totalGarantiasAExpirar = 0;
try {
    $ligacaoAviso = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacaoAviso->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $resultadoAviso = $ligacaoAviso->query("
        SELECT COUNT(*) AS total
        FROM garantias_equipamentos
        WHERE data_fim IS NOT NULL
          AND data_fim >= CURDATE()
          AND data_fim <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)
    ")->fetch(PDO::FETCH_OBJ);

    $totalGarantiasAExpirar = (int) $resultadoAviso->total;

    $totalMensagensNaoLidas = 0;
    if ($_SESSION['profile'] === 'Administrador') {
        $resultadoMensagens = $ligacaoAviso->query("SELECT COUNT(*) AS total FROM mensagens_contacto WHERE lido = 0")->fetch(PDO::FETCH_OBJ);
        $totalMensagensNaoLidas = (int) $resultadoMensagens->total;
    }
} catch (PDOException $err) {
    $totalGarantiasAExpirar = 0;
    $totalMensagensNaoLidas = 0;
}

$ligacaoAviso = null;
?>

<!-- Navbar da área privada -->
<header class="navbar-privada">

    <div class="logo-privada">
        <img src="/medivault/assets/imagens/LOGO.png" alt="Logótipo MediVault" class="logo-navbar-privada">
        <span class="nome-navbar-privada"><?php echo APP_NAME; ?></span>
    </div>

    <div class="dropdown-utilizador-privado">
        <div style="display:flex; align-items:center; gap:1rem;">

            <button id="botao-historico-navbar" onclick="abrirHistoricoNavbar()" class="botao-historico-navbar">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </button>

            <?php if ($_SESSION['profile'] === 'Administrador') : ?>
                <a href="/medivault/private/views/mensagens/mensagens.php" class="botao-historico-navbar" style="position:relative; text-decoration:none;" title="Mensagens de Contacto">
                    <i class="fa-regular fa-envelope"></i>
                    <?php if ($totalMensagensNaoLidas > 0) : ?>
                        <span style="position:absolute; top:-4px; right:-6px; background:#dc3545; color:#fff; font-size:0.65rem; font-weight:700; border-radius:999px; padding:1px 5px; line-height:1.3; min-width:16px; text-align:center;">
                            <?= $totalMensagensNaoLidas ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>

            <!-- Offcanvas do histórico -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHistorico" aria-labelledby="offcanvasHistoricoLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasHistoricoLabel">
                        <i class="fa-solid fa-clock-rotate-left" style="color:#0086a8; margin-right:8px;"></i>
                        Histórico de movimentações de Equipamentos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
                <div class="offcanvas-body">
                    <p class="text-muted">Sem movimentações registadas.</p>
                </div>
            </div>

            <div class="utilizador-privado">
                <i class="fa-regular fa-user"></i>
                <span><?= htmlspecialchars($nome) ?></span>
                <i class="fa-solid fa-caret-down"></i>
            </div>

        </div>

        <div class="menu-utilizador-privado">
            <a href="/medivault/private/views/utilizadores/alterar_password.php">
                <i class="fa-solid fa-key"></i>
                Alterar password
            </a>

            <a href="/medivault/public/logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sair
            </a>
        </div>
    </div>

</header>

<?php if ($totalGarantiasAExpirar > 0) : ?>
    <div id="aviso-garantias-globais" style="display:flex;">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><?= $totalGarantiasAExpirar ?> equipamento<?= $totalGarantiasAExpirar !== 1 ? 's' : '' ?> com garantia a expirar nos próximos 30 dias.</span>
        <a href="/medivault/private/views/equipamentos/equipamentos.php">Ver equipamentos</a>
    </div>
<?php else : ?>
    <div id="aviso-garantias-globais" style="display:none;"></div>
<?php endif; ?>