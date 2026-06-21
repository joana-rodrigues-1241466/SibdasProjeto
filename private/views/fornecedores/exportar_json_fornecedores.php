<?php
// ============================================================
// EXPORTAR_JSON_FORNECEDORES.PHP
// Gera e envia para download um ficheiro JSON com a listagem
// de todos os fornecedores ativos.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();

// Obter os dados dos fornecedores a exportar
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
        SELECT f.codigo, f.nome_empresa, f.nif, f.telefone, f.email, f.website,
               f.pessoa_contacto, f.telefone_pessoa_contacto,
               tf.designacao AS tipo_fornecedor, m.designacao AS morada
        FROM fornecedores f
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        LEFT JOIN moradas m ON f.morada_id = m.id
        WHERE f.ativo = 1
        ORDER BY f.codigo
    ")->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro ao ligar à base de dados.');
}

// Configurar os cabeçalhos HTTP para forçar o download do ficheiro JSON
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_fornecedores_' . date('Y-m-d') . '.json"');
header('Pragma: no-cache');
header('Expires: 0');

// Gerar o JSON formatado (legível) com acentos corretos
echo json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;