<?php
// ============================================================
// REATIVAR_LOCALIZACAO.PHP
// Reativa uma localização previamente desativada. Se existir um
// instantâneo dos equipamentos que estavam associados antes da
// desativação, permite ao utilizador escolher entre movê-los de
// volta para esta localização ou mantê-los onde estão atualmente.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

// Desencriptar e validar o ID da localização a reativar
$idLocalizacaoEncriptado = $_POST['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncriptado);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

$opcaoReassociacao = $_POST['opcao_reassociacao'] ?? 'nao_associar';

try {
    $ligacao = conectar_bd();

    // Obter o instantâneo de equipamentos guardado na desativação (se existir)
    $stmtSnapshot = $ligacao->prepare("SELECT snapshot_equipamentos FROM localizacoes WHERE id = :id");
    $stmtSnapshot->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmtSnapshot->execute();
    $snapshotJson = $stmtSnapshot->fetchColumn();
    $idsEquipamentosSnapshot = $snapshotJson ? json_decode($snapshotJson, true) : [];

    $totalReassociados = 0;

    // Se o utilizador escolheu mover de volta, e existem equipamentos no instantâneo
    if ($opcaoReassociacao === 'reassociar' && !empty($idsEquipamentosSnapshot)) {
        $stmtVerificarEquipamentoAtivo = $ligacao->prepare("SELECT id FROM equipamentos WHERE id = :id AND ativo = 1");
        $stmtMoverDeVolta = $ligacao->prepare("UPDATE equipamentos SET localizacao_id = :localizacao WHERE id = :id");

        foreach ($idsEquipamentosSnapshot as $idEquipamento) {
            // Só move equipamentos que ainda existem e estão ativos
            $stmtVerificarEquipamentoAtivo->execute([':id' => $idEquipamento]);
            if (!$stmtVerificarEquipamentoAtivo->fetch()) {
                continue;
            }

            $stmtMoverDeVolta->execute([':localizacao' => $idLocalizacao, ':id' => $idEquipamento]);
            $totalReassociados++;
        }
    }

    // Reativar a localização e limpar o instantâneo (já não é necessário)
    $stmtReativar = $ligacao->prepare("UPDATE localizacoes SET ativo = 1, snapshot_equipamentos = NULL WHERE id = :id");
    $stmtReativar->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmtReativar->execute();

    $ligacao = null;

    $_SESSION['mensagem_sucesso'] = $totalReassociados > 0
        ? "Localização reativada com sucesso. {$totalReassociados} equipamento(s) movido(s) de volta."
        : 'Localização reativada com sucesso.';

    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro: ' . $e->getMessage());
}