<?php
// ============================================================
// CONFIRMAR_APAGAR_FORNECEDOR.PHP
// Desativa (soft delete) um fornecedor. Como um equipamento pode
// ter vários fornecedores associados, a lógica é:
// - Se o equipamento tem outros fornecedores além deste, a
//   associação a este fornecedor é simplesmente removida.
// - Se este é o ÚNICO fornecedor associado a um equipamento, é
//   obrigatório escolher um fornecedor substituto (campo
//   obrigatório no modal de confirmação), evitando equipamentos
//   sem nenhum fornecedor associado.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

// Desencriptar e validar o ID do fornecedor a desativar
$idFornecedorEncriptado = $_POST['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncriptado);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

// Desencriptar o fornecedor de substituição (se foi fornecido)
$novoFornecedorEncriptado = $_POST['novo_fornecedor_id'] ?? null;
$novoFornecedorId = $novoFornecedorEncriptado ? aes_decrypt($novoFornecedorEncriptado) : null;

try {
    $ligacao = conectar_bd();

    // Localizar todos os equipamentos associados a este fornecedor,
    // e quantos fornecedores cada um deles tem no total
    $stmtEquipamentos = $ligacao->prepare("
        SELECT ef.equipamento_id,
               (SELECT COUNT(*) FROM equipamento_fornecedor ef2 WHERE ef2.equipamento_id = ef.equipamento_id) AS total_fornecedores
        FROM equipamento_fornecedor ef
        WHERE ef.fornecedor_id = :id
    ");
    $stmtEquipamentos->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtEquipamentos->execute();
    $equipamentosAssociados = $stmtEquipamentos->fetchAll(PDO::FETCH_ASSOC);

    // Separar os equipamentos onde este é o ÚNICO fornecedor associado
    $equipamentosComFornecedorUnico = array_filter($equipamentosAssociados, function ($eq) {
        return (int) $eq['total_fornecedores'] === 1;
    });

    // Guardar um instantâneo de TODOS os equipamentos associados antes da
    // desativação, para permitir reassociá-los facilmente ao reativar
    $idsEquipamentosAssociados = array_column($equipamentosAssociados, 'equipamento_id');
    $stmtSnapshot = $ligacao->prepare("UPDATE fornecedores SET snapshot_equipamentos = :snapshot WHERE id = :id");
    $stmtSnapshot->execute([
        ':snapshot' => json_encode($idsEquipamentosAssociados),
        ':id' => $idFornecedor
    ]);

    // Se houver equipamentos que ficariam sem nenhum fornecedor, exigir um substituto
    if (!empty($equipamentosComFornecedorUnico) && (!$novoFornecedorId || !is_numeric($novoFornecedorId))) {
        $_SESSION['mensagem_erro'] = 'É necessário escolher um fornecedor substituto para os equipamentos que ficariam sem nenhum fornecedor associado.';
        header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
        exit;
    }

    // Substituir o fornecedor nos equipamentos onde era o único associado
    if (!empty($equipamentosComFornecedorUnico)) {
        $stmtSubstituir = $ligacao->prepare("UPDATE equipamento_fornecedor SET fornecedor_id = :novo WHERE equipamento_id = :equipamento AND fornecedor_id = :antigo");
        foreach ($equipamentosComFornecedorUnico as $eq) {
            $stmtSubstituir->execute([
                ':novo' => $novoFornecedorId,
                ':equipamento' => $eq['equipamento_id'],
                ':antigo' => $idFornecedor
            ]);
        }
    }

    // Remover a associação deste fornecedor nos restantes equipamentos
    // (os que tinham apenas este fornecedor já foram atualizados acima)
    $stmtRemover = $ligacao->prepare("DELETE FROM equipamento_fornecedor WHERE fornecedor_id = :id");
    $stmtRemover->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtRemover->execute();

    // Desativar o fornecedor
    $stmtDesativar = $ligacao->prepare("UPDATE fornecedores SET ativo = 0 WHERE id = :id");
    $stmtDesativar->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtDesativar->execute();

    $ligacao = null;

    $_SESSION['mensagem_sucesso'] = !empty($equipamentosComFornecedorUnico)
        ? 'Fornecedor desativado com sucesso. ' . count($equipamentosComFornecedorUnico) . ' equipamento(s) tiveram o fornecedor substituído.'
        : 'Fornecedor desativado com sucesso.';

    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro: ' . $e->getMessage());
}