<?php
// ============================================================
// PROCESSA_INICIAR_SESSAO.PHP
// Processa a submissão do formulário de login: valida os dados
// recebidos, verifica as credenciais na base de dados e, se
// corretas, inicia a sessão do utilizador e redireciona para
// a página inicial da área privada.
// ============================================================

require_once 'includes/funcoes.php';
start_session();

// --------------------------------------------------------------------
// SEGURANÇA: Impede que o utilizador aceda diretamente a este script.
// Este ficheiro deve ser acedido apenas através de submissão de formulário (POST).
// Se for acedido diretamente (por URL), será redirecionado para o login.
// --------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: iniciar_sessao.php');
    return;
}

// --------------------------------------------------------------------
// RECOLHA DE DADOS DO FORMULÁRIO
// --------------------------------------------------------------------
// Verifica se o campo 'text_username' foi enviado via POST.
// Se sim, guarda-o na variável $username. Caso contrário, usa string vazia.
$username = isset($_POST['text_username']) ? $_POST['text_username'] : '';
// O mesmo para o campo da password.
$password = isset($_POST['text_password']) ? $_POST['text_password'] : '';

// --------------------------------------------------------------------
// VALIDAÇÃO DOS DADOS
// --------------------------------------------------------------------
// Inicializa um array vazio para guardar mensagens de erro de validação
$validation_errors = [];

// Verifica se o nome de utilizador (username) é um endereço de email válido
if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
    $validation_errors[] = 'O username tem que ser um email válido.';
}

// Verifica se o nome de utilizador tem um comprimento entre 5 e 50 caracteres
if (strlen($username) < 7 || strlen($username) > 50) {
    $validation_errors[] = 'O username deve ter entre 7 e 50 caracteres.';
}

// Verifica se a password tem um comprimento entre 6 e 12 caracteres
if (strlen($password) < 8 || strlen($password) > 14) {
    $validation_errors[] = 'A password deve ter entre 8 e 14 caracteres.';
}

// Se existirem erros de validação, guarda-os na sessão e redireciona
if (!empty($validation_errors)) {
    $_SESSION['validation_errors'] = $validation_errors;
    header('Location: iniciar_sessao.php');
    return;
}

// --------------------------------------------------------------------
// LIGAÇÃO REAL À BASE DE DADOS E VERIFICAÇÃO DO LOGIN
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();

    // Procurar o utilizador pelo email (desencriptado, porque está guardado encriptado na BD)
    $comando = $ligacao->prepare("
        SELECT u.id, u.nome, AES_DECRYPT(u.email, :chave) AS email, u.password_hash, u.ativo, p.designacao AS perfil
        FROM utilizadores u
        JOIN perfis_utilizador p ON p.id = u.perfil_id
        WHERE AES_DECRYPT(u.email, :chave) = :email
    ");
    $comando->execute([
        ':chave' => MYSQL_AES_KEY,
        ':email' => $username
    ]);
    $utilizador = $comando->fetch(PDO::FETCH_OBJ);

    // Verificar se existe, se está ativo, e se a password coincide com o hash guardado
    if (!$utilizador || !$utilizador->ativo || !password_verify($password, $utilizador->password_hash)) {
        $_SESSION['server_error'] = 'Login inválido';
        header('Location: iniciar_sessao.php');
        return;
    }

    // Atualizar a data/hora do último login
    $stmt = $ligacao->prepare("UPDATE utilizadores SET last_login = NOW() WHERE id = ?");
    $stmt->execute([$utilizador->id]);

    // Guardar os dados essenciais na sessão (email já desencriptado pela query)
    $_SESSION['utilizador'] = $utilizador->nome;
    $_SESSION['utilizador_id'] = $utilizador->id;
    $_SESSION['email'] = $utilizador->email;
    $_SESSION['profile'] = $utilizador->perfil;

} catch (PDOException $e) {
    $_SESSION['server_error'] = 'Erro ao ligar à base de dados.';
    header('Location: iniciar_sessao.php');
    return;
}

// Redireciona para a página principal privada
header('Location: home.php');
exit;
?>