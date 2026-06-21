<?php
// ============================================================
// MARCAR_LIDA.PHP
// Marca uma mensagem de contacto como lida, registando a data/
// hora e o utilizador (Administrador) que a marcou.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

if ($_SESSION['profile'] !== 'Administrador') {
    header('Location: ' . BASE_URL . '/private/home.php');
    exit;
}

// Desencriptar e validar o ID da mensagem recebido na URL
$idEncriptado = $_GET['id_mensagem'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/mensagens/mensagens.php');
    exit;
}

// Marcar a mensagem como lida
try {
    $ligacao = conectar_bd();

    date_default_timezone_set('Europe/Lisbon');

    $stmt = $ligacao->prepare("UPDATE mensagens_contacto SET lido = 1, lido_em = :lido_em, lido_por = :lido_por WHERE id = :id");
    $stmt->execute([
        ':lido_em' => date('Y-m-d H:i:s'),
        ':lido_por' => $_SESSION['utilizador_id'] ?? null,
        ':id' => $id
    ]);

    $_SESSION['mensagem_sucesso'] = 'Mensagem marcada como lida.';
    header('Location: ' . BASE_URL . '/private/views/mensagens/mensagens.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}