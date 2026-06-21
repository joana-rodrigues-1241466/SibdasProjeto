<?php
// ============================================================
// REATIVAR_LOCALIZACAO.PHP
// Reativa uma localização previamente desativada, identificada
// por ID encriptado recebido via query string.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();

// Desencriptar e validar o ID da localização recebido na URL
$idEncriptado = $_GET['id_localizacao'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

// Reativar a localização na base de dados
try {
    $ligacao = conectar_bd();

    $stmt = $ligacao->prepare("UPDATE localizacoes SET ativo = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['mensagem_sucesso'] = 'Localização reativada com sucesso.';
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}