<?php
// ============================================================
// REATIVAR_FORNECEDOR.PHP
// Reativa um fornecedor previamente desativado, identificado por
// ID encriptado recebido via query string.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Desencriptar e validar o ID do fornecedor recebido na URL
$idEncriptado = $_GET['id_fornecedor'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

// Reativar o fornecedor na base de dados
try {
    $ligacao = conectar_bd();

    $stmt = $ligacao->prepare("UPDATE fornecedores SET ativo = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}