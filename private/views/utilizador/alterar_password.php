<?php
// ============================================================
// ALTERAR_PASSWORD.PHP
// Permite ao utilizador autenticado alterar a sua própria
// palavra-passe, mediante confirmação da palavra-passe atual.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$erros = [];
$sucesso = false;

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO (submissão POST)
// --------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordAtual = $_POST['password_atual'] ?? '';
    $passwordNova = $_POST['password_nova'] ?? '';
    $passwordConfirmar = $_POST['password_confirmar'] ?? '';

    // Validações dos campos do formulário
    if (empty($passwordAtual)) {
        $erros[] = 'Introduza a sua palavra-passe atual.';
    }

    if (strlen($passwordNova) < 8 || strlen($passwordNova) > 14) {
        $erros[] = 'A nova palavra-passe deve ter entre 8 e 14 caracteres.';
    }

    if ($passwordNova !== $passwordConfirmar) {
        $erros[] = 'A confirmação da palavra-passe não coincide com a nova palavra-passe.';
    }

    // Se não houver erros de validação, verificar a password atual e atualizar
    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            $stmt = $ligacao->prepare("SELECT password_hash FROM utilizadores WHERE id = :id");
            $stmt->execute([':id' => $_SESSION['utilizador_id']]);
            $utilizador = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$utilizador || !password_verify($passwordAtual, $utilizador->password_hash)) {
                $erros[] = 'A palavra-passe atual está incorreta.';
            } else {
                $novoHash = password_hash($passwordNova, PASSWORD_BCRYPT);

                $stmtUpdate = $ligacao->prepare("UPDATE utilizadores SET password_hash = :hash WHERE id = :id");
                $stmtUpdate->execute([
                    ':hash' => $novoHash,
                    ':id' => $_SESSION['utilizador_id'],
                ]);

                $sucesso = true;
            }

            $ligacao = null;
        } catch (PDOException $e) {
            registar_erro_log($e->getMessage());
            $erros[] = 'Erro ao atualizar a palavra-passe. Tente novamente.';
        }
    }
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de alteração de palavra-passe -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="formulario-privado" style="max-width: 700px; margin-left: auto; margin-right: auto;">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-key"></i>
                    Alterar Palavra-passe
                </h1>
            </div>

            <hr>

            <?php if ($sucesso) : ?>
                <div class="alert alert-success text-center">
                    <i class="fa-solid fa-circle-check"></i> Palavra-passe alterada com sucesso.
                </div>
            <?php endif; ?>

            <?php if (!empty($erros)) : ?>
                <div class="alert alert-danger">
                    <?php foreach ($erros as $erro) : ?>
                        <div><?= htmlspecialchars($erro) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="alterar_password.php">

                <div class="campo-detalhes" style="border-bottom: none; padding-bottom: 0; margin-bottom: 0.75rem;">
                    <h3>Palavra-passe atual</h3>
                    <input type="password" class="form-control campo-formulario-privado" id="password_atual" name="password_atual" placeholder="Introduza a sua palavra-passe atual">
                </div>

                <div class="campo-detalhes" style="border-bottom: none; padding-bottom: 0; margin-bottom: 0.75rem;">
                    <h3>Nova palavra-passe</h3>
                    <input type="password" class="form-control campo-formulario-privado" id="password_nova" name="password_nova" placeholder="Entre 8 e 14 caracteres">
                </div>

                <div class="campo-detalhes" style="border-bottom: none; padding-bottom: 0; margin-bottom: 1.5rem;">
                    <h3>Confirmar nova palavra-passe</h3>
                    <input type="password" class="form-control campo-formulario-privado" id="password_confirmar" name="password_confirmar" placeholder="Repita a nova palavra-passe">
                </div>

                <div class="botoes-formulario-privado">
                    <a href="/medivault/private/home.php" class="botao-cancelar-privado">
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