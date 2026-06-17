<!-- Menu lateral da área privada -->
<aside class="menu-lateral-privada">
    <h2>Menu</h2>

    <nav>
        <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico', 'Profissional de Saúde'])) : ?>
            <a href="/medivault/private/views/equipamentos/equipamentos.php">
                <i class="fa-solid fa-stethoscope"></i>
                Equipamentos
            </a>
        <?php endif; ?>

        <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico'])) : ?>
            <a href="/medivault/private/views/fornecedores/fornecedores.php">
                <i class="fa-solid fa-truck-medical"></i>
                Fornecedores
            </a>
        <?php endif; ?>

        <?php if (in_array($_SESSION['profile'], ['Administrador', 'Técnico', 'Profissional de Saúde'])) : ?>
            <a href="/medivault/private/views/localizacoes/localizacoes.php">
                <i class="fa-solid fa-location-dot"></i>
                Localizações
            </a>
        <?php endif; ?>

        <?php if ($_SESSION['profile'] === 'Administrador') : ?>
            <a href="/medivault/private/views/gestao_conteudos/gestao_conteudos.php">
                <i class="fa-solid fa-pen-to-square"></i>
                Gestão de Conteúdos
            </a>
        <?php endif; ?>

        <a href="/medivault/private/views/dashboard/dashboard.php">
            <i class="fa-solid fa-chart-line"></i>
            Dashboard
        </a>

        <a href="/medivault/public/index.php">
            <i class="fa-solid fa-right-from-bracket"></i>
            Sair
        </a>
    </nav>
</aside>