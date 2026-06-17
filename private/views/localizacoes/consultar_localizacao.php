<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

$idLocalizacaoEncriptado = $_GET['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncriptado);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare("SELECT * FROM localizacoes WHERE id = :id");
    $stmt->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmt->execute();
    $localizacao = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$localizacao) {
        echo "<p class='text-danger'>Localização não encontrada.</p>";
        exit;
    }

    $stmtEquip = $ligacao->prepare("
    SELECT e.codigo, e.designacao, ee.designacao AS estado, c.designacao AS criticidade
    FROM equipamentos e
    LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
    LEFT JOIN criticidades c ON e.criticidade_id = c.id
    WHERE e.localizacao_id = :id
    ORDER BY e.codigo
");
    $stmtEquip->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmtEquip->execute();
    $equipamentosAssociados = $stmtEquip->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    exit;
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- Conteúdo principal -->
    <main class="conteudo-privado">

        <!-- Card dos detalhes da localização -->
        <section class="detalhes-equipamento-privada">

            <!-- Título da ficha -->
            <div class="titulo-detalhes-equipamento">
    <i class="fa-solid fa-location-dot"></i>
    <h1>
    Detalhes da Localização
    <?php if ($localizacao['ativo'] == 1): ?>
        <span class="badge bg-success" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Ativo</span>
<?php else: ?>
    <span class="badge bg-secondary" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Inativo</span>
    <?php endif; ?>
</h1>
</div>

            <hr>

            <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                <i class="fa-solid fa-building"></i>
                Dados Gerais
            </h5>

            <div class="grelha-detalhes-equipamento">
                <div class="campo-detalhes">
                    <h3>Código</h3>
                    <p id="detalhe-codigo-localizacao"><?= htmlspecialchars($localizacao['codigo']) ?></p>
                </div>
                <div class="campo-detalhes" style="grid-column: span 2;">
                    <h3>Serviço / Departamento</h3>
                    <p id="detalhe-servico"><?= htmlspecialchars($localizacao['servico']) ?></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Edifício</h3>
                    <p id="detalhe-edificio"><?= htmlspecialchars($localizacao['edificio']) ?></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Piso</h3>
                    <p id="detalhe-piso"><?= htmlspecialchars($localizacao['piso']) ?></p>
                </div>
                <div class="campo-detalhes">
                    <h3>Sala / Gabinete</h3>
                    <p id="detalhe-sala"><?= htmlspecialchars($localizacao['sala']) ?></p>
                </div>
            </div>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-stethoscope"></i>
                Equipamentos Associados
            </h5>

            <div id="equipamentos-da-localizacao">
                <?php if (empty($equipamentosAssociados)) : ?>
                    <p class="text-muted">Não existem equipamentos associados a esta localização.</p>
                <?php else : ?>
                    <div class="tabela-privada">
                        <table>
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Designação</th>
                                    <th>Estado</th>
                                    <th>Criticidade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $classesCriticidadeAssociados = [
                                    'Suporte de vida' => 'badge-criticidade-suporte',
                                    'Alta' => 'badge-criticidade-alta',
                                    'Média' => 'badge-criticidade-media',
                                    'Baixa' => 'badge-criticidade-baixa'
                                ];
                                ?>
                                <?php foreach ($equipamentosAssociados as $equip) : ?>
                                    <?php
                                    $classesEstadoAssociados = [
                                        'Ativo' => 'estado-ativo',
                                        'Em manutenção' => 'estado-manutencao',
                                        'Em calibração' => 'estado-calibracao',
                                        'Inativo' => 'estado-inativo',
                                        'Em quarentena' => 'estado-quarentena',
                                        'Abatido' => 'estado-abatido'
                                    ];
                                    $classeCriticidadeAssoc = $classesCriticidadeAssociados[$equip['criticidade']] ?? '';
                                    $classeEstadoAssoc = $classesEstadoAssociados[$equip['estado']] ?? '';
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($equip['codigo']) ?></td>
                                        <td><?= htmlspecialchars($equip['designacao']) ?></td>
                                        <td><span class="<?= $classeEstadoAssoc ?>"><?= htmlspecialchars($equip['estado']) ?></span></td>
                                        <td>
    <span class="badge-detalhe <?= $classeCriticidadeAssoc ?>"><?= htmlspecialchars($equip['criticidade']) ?></span>
</td>
<td class="acoes-tabela-privada">
                                            <a href="/medivault/private/views/equipamentos/consultar_equipamento.php?id=<?= htmlspecialchars($equip['codigo']) ?>" title="Consultar" style="display: inline-block; padding: 4px 14px; border: 1px solid #005fae; border-radius: 6px; color: #005fae; text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                                Ver
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <hr>

            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-comment-medical"></i>
                Observações da localização
            </h5>

            <div class="campo-detalhes campo-detalhes-largo">
                <h3>Observações</h3>
                <p id="detalhe-observacoes-localizacao"><?= htmlspecialchars($localizacao['observacoes']) ?></p>
            </div>

            <div class="botoes-detalhes-equipamento">
                <a href="localizacoes.php" class="botao-voltar-detalhes">
                    <i class="fa-solid fa-arrow-left"></i>
                    Voltar
                </a>
            </div>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>