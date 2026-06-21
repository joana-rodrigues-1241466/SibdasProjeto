<?php
// ============================================================
// REATIVAR_FORNECEDOR.PHP
// Reativa um fornecedor previamente desativado. Se existir um
// instantâneo dos equipamentos a que estava associado antes da
// desativação, permite ao utilizador escolher entre reassociar
// o fornecedor a esses equipamentos ou não associar a nenhum.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

// Desencriptar e validar o ID do fornecedor a reativar
$idFornecedorEncriptado = $_POST['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncriptado);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

$opcaoReassociacao = $_POST['opcao_reassociacao'] ?? 'nao_associar';

try {
    $ligacao = conectar_bd();

    // Obter o instantâneo de equipamentos guardado na desativação (se existir)
    $stmtSnapshot = $ligacao->prepare("SELECT snapshot_equipamentos FROM fornecedores WHERE id = :id");
    $stmtSnapshot->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtSnapshot->execute();
    $snapshotJson = $stmtSnapshot->fetchColumn();
    $idsEquipamentosSnapshot = $snapshotJson ? json_decode($snapshotJson, true) : [];

    $totalReassociados = 0;

    // Se o utilizador escolheu reassociar, e existem equipamentos no instantâneo
    if ($opcaoReassociacao === 'reassociar' && !empty($idsEquipamentosSnapshot)) {
        // Obter os dados de contacto gerais do fornecedor, para preencher os
        // campos obrigatórios da associação (morada, pessoa e telefone de contacto)
        $stmtDadosFornecedor = $ligacao->prepare("SELECT morada_id, pessoa_contacto, telefone_pessoa_contacto FROM fornecedores WHERE id = :id");
        $stmtDadosFornecedor->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
        $stmtDadosFornecedor->execute();
        $dadosFornecedor = $stmtDadosFornecedor->fetch(PDO::FETCH_ASSOC);

        $stmtVerificarEquipamentoAtivo = $ligacao->prepare("SELECT id FROM equipamentos WHERE id = :id AND ativo = 1");
        $stmtVerificarAssociacaoExistente = $ligacao->prepare("SELECT 1 FROM equipamento_fornecedor WHERE equipamento_id = :equipamento AND fornecedor_id = :fornecedor");
        $stmtReassociar = $ligacao->prepare("
            INSERT INTO equipamento_fornecedor (equipamento_id, fornecedor_id, morada_id, pessoa_contacto, telefone_pessoa_contacto)
            VALUES (:equipamento, :fornecedor, :morada, :pessoa, :telefone)
        ");

        foreach ($idsEquipamentosSnapshot as $idEquipamento) {
            // Só reassocia a equipamentos que ainda existem e estão ativos
            $stmtVerificarEquipamentoAtivo->execute([':id' => $idEquipamento]);
            if (!$stmtVerificarEquipamentoAtivo->fetch()) {
                continue;
            }

            // Evitar duplicar a associação, caso já tenha sido recriada manualmente entretanto
            $stmtVerificarAssociacaoExistente->execute([':equipamento' => $idEquipamento, ':fornecedor' => $idFornecedor]);
            if ($stmtVerificarAssociacaoExistente->fetch()) {
                continue;
            }

            $stmtReassociar->execute([
                ':equipamento' => $idEquipamento,
                ':fornecedor' => $idFornecedor,
                ':morada' => $dadosFornecedor['morada_id'],
                ':pessoa' => $dadosFornecedor['pessoa_contacto'],
                ':telefone' => $dadosFornecedor['telefone_pessoa_contacto']
            ]);
            $totalReassociados++;
        }
    }

    // Reativar o fornecedor e limpar o instantâneo (já não é necessário)
    $stmtReativar = $ligacao->prepare("UPDATE fornecedores SET ativo = 1, snapshot_equipamentos = NULL WHERE id = :id");
    $stmtReativar->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtReativar->execute();

    $ligacao = null;

    $_SESSION['mensagem_sucesso'] = $totalReassociados > 0
        ? "Fornecedor reativado com sucesso. Reassociado a {$totalReassociados} equipamento(s)."
        : 'Fornecedor reativado com sucesso.';

    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro: ' . $e->getMessage());
}