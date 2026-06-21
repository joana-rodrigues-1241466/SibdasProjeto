<?php
// ============================================================
// CONFIRMAR_APAGAR_FORNECEDOR.PHP
// Desativa (soft delete) um fornecedor identificado por ID
// encriptado, recebido via query string. Não apaga o registo
// da base de dados — apenas marca ativo = 0, para preservar o
// histórico de equipamentos associados.
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

// Desativar o fornecedor na base de dados
try {
    $ligacao = conectar_bd();

    $stmt = $ligacao->prepare("UPDATE fornecedores SET ativo = 0 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['mensagem_sucesso'] = 'Fornecedor desativado com sucesso.';
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}