<?php
require_once __DIR__ . '/../config/config.php';
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessão | <?php echo APP_NAME; ?></title>

    <link rel="shortcut icon" href="/medivault/assets/imagens/LOGO.png" type="image/png">
    <link rel="stylesheet" href="/medivault/assets/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/medivault/assets/css/1241466.css">
</head>

<body class="pagina-login">

<main class="login-container">
    <section class="login-card">
        <h1 class="login-titulo">Iniciar Sessão</h1>
        <p class="login-subtitulo">
            Acesso reservado a profissionais de saúde autorizados.
        </p>
        <div class="linha-login"></div>
        <form class="form-login">
            <div class="mb-3 text-start">
                <label for="email-login" class="form-label">Email</label>
                <div class="input-login">
                    <i class="fa-regular fa-envelope"></i>
                    <input type="text" id="email-login" name="email" placeholder="exemplo@hospital.pt">
                </div>
            </div>
            <div class="mb-4 text-start">
                <label for="password-login" class="form-label">Palavra-passe</label>
                <div class="input-login">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password-login" name="password" placeholder="Insira a sua palavra-passe">
                    <i class="fa-regular fa-eye"></i>
                </div>
            </div>
            <div id="erros-formulario" class="erros-separador" style="display:none;">
                <ul id="lista-erros-formulario"></ul>
            </div>
            <button type="submit" class="btn botao-login-pagina">
                Entrar
            </button>
        </form>
        <a href="/medivault/public/index.php" class="voltar-inicio">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar à página inicial
        </a>
    </section>
</main>

    <script src="/medivault/assets/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/medivault/assets/js/1241466.js"></script>

</body>
</html>