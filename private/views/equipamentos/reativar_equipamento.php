<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idEncriptado = $_GET['id_equipamento'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
}

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmtCodigo = $ligacao->prepare("SELECT codigo FROM equipamentos WHERE id = :id");
    $stmtCodigo->execute([':id' => $id]);
    $codigoEquipamento = $stmtCodigo->fetchColumn();

    $stmt = $ligacao->prepare("UPDATE equipamentos SET ativo = 1 WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    registar_historico(
        $ligacao,
        $id,
        'Reativação',
        "Equipamento {$codigoEquipamento} reativado.",
        ['ativo' => 0],
        ['ativo' => 1]
    );

    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}