<?php
// Inicia a sessão (necessário para usar $_SESSION)
session_start();

// Inicializa a variável que irá conter os erros de validação
$validation_errors = [];

// --------------------------------------------------------------------
// RECOLHA DE MENSAGENS TEMPORÁRIAS DA SESSÃO
// --------------------------------------------------------------------
// Verifica se existem erros de validação guardados na sessão
if (!empty($_SESSION['validation_errors'])) {
    $validation_errors = $_SESSION['validation_errors'];
    unset($_SESSION['validation_errors']);
}

// Inicializa a variável que irá conter erros de servidor
$server_error = [];

// Verifica se existe algum erro de servidor guardado na sessão
if (!empty($_SESSION['server_error'])) {
    $server_error = $_SESSION['server_error'];
    unset($_SESSION['server_error']);
}
?>
<?php include 'includes/header.php'; ?>

<main class="login-container">
    <section class="login-card">
        <div style="display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 1rem;">
            <img src="/medivault/assets/imagens/LOGO.png" alt="Logo MediVault" style="height: 90px;">
            <span style="font-size: 2.2rem; font-weight: 700; color: #003f78; letter-spacing: 3px;">MediVault</span>
        </div>
        <hr>
        <h1 class="login-titulo">Iniciar Sessão</h1>
        <p class="login-subtitulo">
            Acesso reservado a profissionais de saúde autorizados.
        </p>
        <div class="linha-login"></div>
        <form name="formulario" class="form-login" action="processa_iniciar_sessao.php" method="post">
            <div class="mb-3 text-start">
                <label for="email-login" class="form-label">Email</label>
                <div class="input-login">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="email" class="form-control" name="text_username" id="email-login" placeholder="exemplo@hospital.pt">
                </div>
            </div>
            <div class="mb-4 text-start">
                <label for="password-login" class="form-label">Palavra-passe</label>
                <div class="input-login">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" class="form-control" name="text_password" id="password-login" placeholder="Insira a sua palavra-passe">
                    <i class="fa-regular fa-eye" id="toggle-password-login"></i>
                </div>
            </div>

            <!-- -------------------------------------------------------------------- -->
            <!-- APRESENTAÇÃO DE MENSAGENS DE ERRO (VALIDAÇÃO E SERVIDOR) -->
            <!-- -------------------------------------------------------------------- -->
            <!-- Verifica se existem erros de validação -->
            <?php if (!empty($validation_errors)) : ?>
                <div class="alert alert-danger p-2 text-center">
                    <div><strong>Erros:</strong></div>
                    <?php foreach ($validation_errors as $error) : ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Verifica se existe um erro de servidor -->
            <?php if (!empty($server_error)) : ?>
                <div class="alert alert-danger p-2 text-center">
                    <div><?= htmlspecialchars($server_error) ?></div>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn botao-login-pagina">
                Entrar
            </button>

            <!-- Preenchimento automático (Fase de Testes) -->
            <div class="painel-modo-teste">
                <span class="badge-modo-teste">
                    <i class="fa-solid fa-flask"></i>
                    Modo de teste
                </span>
                <label for="select_preenchimento" class="form-label" style="font-size: 0.85rem;">
                    Preencher automaticamente com um utilizador
                </label>
                <div class="select-modo-teste">
                    <i class="fa-solid fa-user-gear"></i>
                    <select id="select_preenchimento">
                        <option value="">Selecionar utilizador...</option>
                        <optgroup label="Administrador">
                            <option value="admin@medivault.pt|Admin#2025!">Joana Rodrigues</option>
                        </optgroup>
                        <optgroup label="Técnico">
                            <option value="tecnico@medivault.pt|Agente#2025!">Rui Ferreira</option>
                        </optgroup>
                        <optgroup label="Profissional de Saúde">
                            <option value="profissional_saude@medivault.pt|Saude#2025!">Ana Silva</option>
                        </optgroup>
                    </select>
                </div>
            </div>
        </form>
        <a href="/medivault/public/index.php" class="voltar-inicio">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar à página inicial
        </a>
    </section>
</main>

<script src="/medivault/assets/bootstrap/bootstrap.bundle.min.js"></script>
<script>
    // Mostrar/ocultar password ao clicar no ícone do olho
    document.querySelector("#toggle-password-login").addEventListener('click', function() {
        const campo = document.querySelector("#password-login");
        const aMostrar = campo.type === "password";
        campo.type = aMostrar ? "text" : "password";
        this.classList.toggle("fa-eye", !aMostrar);
        this.classList.toggle("fa-eye-slash", aMostrar);
    });

    // Preenchimento automático para testes
    document.querySelector("#select_preenchimento").addEventListener('change', (e) => {
        if (!e.target.value) {
            return;
        }
        const [email, password] = e.target.value.split('|');
        const formulario = document.forms['formulario'];
        formulario['text_username'].value = email;
        formulario['text_password'].value = password;
    });
</script>
</body>

</html>