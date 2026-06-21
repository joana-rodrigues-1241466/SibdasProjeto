<?php
// ============================================================
// EXPORTAR_JSON_LOCALIZACOES.PHP
// Gera e envia para download um ficheiro JSON com a listagem
// de todas as localizações ativas.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Obter os dados das localizações a exportar
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
        SELECT l.codigo, l.edificio, l.piso, l.servico, l.sala, l.observacoes
        FROM localizacoes l
        WHERE l.ativo = 1
        ORDER BY l.codigo
    ")->fetchAll(PDO::FETCH_ASSOC);

    $ligacao = null;
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    die('Erro ao ligar à base de dados.');
}

// Configurar os cabeçalhos HTTP para forçar o download do ficheiro JSON
header('Content-Type: application/json; charset=utf-8');
header('Content-Disposition: attachment; filename="listagem_localizacoes_' . date('Y-m-d') . '.json"');
header('Pragma: no-cache');
header('Expires: 0');

// Gerar o JSON formatado (legível) com acentos corretos
echo json_encode($resultados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;