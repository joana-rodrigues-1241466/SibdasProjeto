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

            <!-- Offcanvas do histórico -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasHistorico" aria-labelledby="offcanvasHistoricoLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasHistoricoLabel">
                        <i class="fa-solid fa-clock-rotate-left" style="color:#0086a8; margin-right:8px;"></i>
                        Histórico de movimentações de Equipamentos
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
                </div>
            </div>

            <div class="utilizador-privado">
                <i class="fa-regular fa-user"></i>
                <span>Profissional de saúde</span>
                <i class="fa-solid fa-caret-down"></i>
            </div>

        </div>

        <div class="menu-utilizador-privado">
            <a href="/medivault/private/views/utilizadores/alterar_password.php">
                <i class="fa-solid fa-key"></i>
                Alterar password
            </a>

            <a href="/medivault/public/index.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Sair
            </a>
        </div>
    </div>

</header>

<div id="aviso-garantias-globais" style="display:none;"></div>