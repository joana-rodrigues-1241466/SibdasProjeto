<?php
// ============================================================
// EXPORTAR_EXCEL_FORNECEDORES.PHP
// Gera e envia para download um ficheiro CSV (compatível com
// Excel) com a listagem de todos os fornecedores ativos.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter os dados dos fornecedores a exportar
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
        SELECT f.codigo, f.nome_empresa, tf.designacao AS tipo_fornecedor,
               f.pessoa_contacto, f.telefone_pessoa_contacto,
               f.telefone, f.email, f.website,
               m.designacao AS morada, f.nif, f.observacoes
        FROM fornecedores f
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        LEFT JOIN moradas m ON f.morada_id = m.id
        WHERE f.ativo = 1
        ORDER BY f.codigo
    ")->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    die('Erro ao ligar à base de dados.');
}

// Configurar os cabeçalhos HTTP para forçar o download do ficheiro CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_fornecedores_' . date('Y-m-d') . '.csv"');
header('Pragma: no-cache');
header('Expires: 0');

// BOM para UTF-8 — garante que os acentos aparecem corretos no Excel
echo "\xEF\xBB\xBF";

$saida = fopen('php://output', 'w');

// Linha de cabeçalho do CSV
fputcsv($saida, [
    'Código', 'Nome da Empresa', 'Tipo de Fornecedor', 'Pessoa de Contacto',
    'Telefone de Contacto', 'Telefone Geral', 'Email', 'Website', 'Morada', 'NIF', 'Observações'
], ';');

// Uma linha por cada fornecedor
foreach ($resultados as $linha) {
    fputcsv($saida, [
        $linha['codigo'],
        $linha['nome_empresa'],
        $linha['tipo_fornecedor'],
        $linha['pessoa_contacto'],
        $linha['telefone_pessoa_contacto'],
        $linha['telefone'],
        $linha['email'],
        $linha['website'] ?? '',
        $linha['morada'],
        $linha['nif'],
        $linha['observacoes'] ?? '',
    ], ';');
}

fclose($saida);
exit;