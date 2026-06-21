<?php
// ============================================================
// CONFIRMAR_APAGAR_LOCALIZACAO.PHP
// Desativa (soft delete) uma localização. Se existirem
// equipamentos associados, exige que tenha sido escolhida uma
// localização de substituição (campo obrigatório no modal de
// confirmação), evitando equipamentos associados a uma
// localização inativa.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

// Desencriptar e validar o ID da localização a desativar
$idLocalizacaoEncriptado = $_POST['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncriptado);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

// Desencriptar a localização de substituição (se foi fornecida)
$novaLocalizacaoEncriptada = $_POST['nova_localizacao_id'] ?? null;
$novaLocalizacaoId = $novaLocalizacaoEncriptada ? aes_decrypt($novaLocalizacaoEncriptada) : null;

try {
    $ligacao = conectar_bd();

    // Verificar quantos equipamentos ativos estão associados a esta localização
    $stmtCount = $ligacao->prepare("SELECT COUNT(*) FROM equipamentos WHERE localizacao_id = :id AND ativo = 1");
    $stmtCount->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmtCount->execute();
    $totalEquipamentos = (int) $stmtCount->fetchColumn();

    // Se existirem equipamentos associados, a nova localização é obrigatória
    if ($totalEquipamentos > 0 && (!$novaLocalizacaoId || !is_numeric($novaLocalizacaoId))) {
        $_SESSION['mensagem_erro'] = 'É necessário escolher uma localização de substituição para os equipamentos associados.';
        header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
        exit;
    }

    // Guardar um instantâneo dos equipamentos associados antes de os mover,
    // para permitir repô-los facilmente ao reativar esta localização
    if ($totalEquipamentos > 0) {
        $stmtIdsEquipamentos = $ligacao->prepare("SELECT id FROM equipamentos WHERE localizacao_id = :id AND ativo = 1");
        $stmtIdsEquipamentos->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
        $stmtIdsEquipamentos->execute();
        $idsEquipamentosAssociados = $stmtIdsEquipamentos->fetchAll(PDO::FETCH_COLUMN);

        $stmtSnapshot = $ligacao->prepare("UPDATE localizacoes SET snapshot_equipamentos = :snapshot WHERE id = :id");
        $stmtSnapshot->execute([
            ':snapshot' => json_encode($idsEquipamentosAssociados),
            ':id' => $idLocalizacao
        ]);
    }

    // Mover os equipamentos associados para a nova localização
    if ($totalEquipamentos > 0) {
        $stmtMover = $ligacao->prepare("UPDATE equipamentos SET localizacao_id = :nova WHERE localizacao_id = :antiga AND ativo = 1");
        $stmtMover->bindParam(':nova', $novaLocalizacaoId, PDO::PARAM_INT);
        $stmtMover->bindParam(':antiga', $idLocalizacao, PDO::PARAM_INT);
        $stmtMover->execute();
    }

    // Desativar a localização
    $stmt = $ligacao->prepare("UPDATE localizacoes SET ativo = 0 WHERE id = :id");
    $stmt->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmt->execute();

    $ligacao = null;

    $_SESSION['mensagem_sucesso'] = $totalEquipamentos > 0
        ? "Localização desativada com sucesso. {$totalEquipamentos} equipamento(s) movido(s) para a nova localização."
        : 'Localização desativada com sucesso.';

    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro: ' . $e->getMessage());
}