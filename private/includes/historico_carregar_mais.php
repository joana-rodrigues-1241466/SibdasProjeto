<?php
require_once __DIR__ . '/funcoes.php';
redirect_if_not_logged();

header('Content-Type: application/json; charset=utf-8');

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limite = 15;

$classesTipoAlteracao = [
    'Criação' => 'background:#e8f7ef; color:#198754;',
    'Edição' => 'background:#e7f1ff; color:#0d6efd;',
    'Eliminação' => 'background:#fdecea; color:#dc3545;',
    'Reativação' => 'background:#f3e8ff; color:#9333ea;',
];

$rotulosCamposHistorico = [
    'designacao' => 'Designação',
    'categoria' => 'Categoria',
    'marca' => 'Marca',
    'modelo' => 'Modelo',
    'numero_serie' => 'N.º de série',
    'fabricante' => 'Fabricante',
    'ano_fabrico' => 'Ano de fabrico',
    'estado' => 'Estado',
    'criticidade' => 'Criticidade',
    'observacoes' => 'Observações',
];

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare("
        SELECT h.id, h.equipamento_id, h.descricao, h.data_alteracao, h.dados_anteriores, h.dados_novos,
               e.codigo AS equipamento_codigo, e.designacao AS equipamento_designacao,
               ta.designacao AS tipo_alteracao, u.nome AS utilizador_nome
        FROM historico_equipamentos h
        JOIN equipamentos e ON e.id = h.equipamento_id
        JOIN tipos_alteracao ta ON ta.id = h.tipo_alteracao_id
        LEFT JOIN utilizadores u ON u.id = h.utilizador_id
        ORDER BY h.data_alteracao DESC
        LIMIT :limite OFFSET :offset
    ");
    $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($entradas as $mov) {
        $html .= renderizar_entrada_historico($mov, $classesTipoAlteracao, $rotulosCamposHistorico);
    }

    echo json_encode([
        'html' => $html,
        'hasMore' => count($entradas) === $limite,
    ]);
} catch (PDOException $e) {
    echo json_encode(['html' => '', 'hasMore' => false]);
}

$ligacao = null;