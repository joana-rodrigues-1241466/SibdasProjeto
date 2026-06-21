<?php
// ============================================================
// REATIVAR_EQUIPAMENTO.PHP
// Reativa um equipamento previamente desativado, identificado
// por ID encriptado recebido via query string, e regista a ação
// no histórico de alterações do equipamento.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();

// Desencriptar e validar o ID do equipamento recebido na URL
$idEncriptado = $_GET['id_equipamento'] ?? null;
$id = aes_decrypt($idEncriptado);

if (!$id || !is_numeric($id)) {
    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
}

// Reativar o equipamento e registar a alteração no histórico
try {
    $ligacao = conectar_bd();

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

    $_SESSION['mensagem_sucesso'] = 'Equipamento reativado com sucesso.';
    header('Location: ' . BASE_URL . '/private/views/equipamentos/equipamentos.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}