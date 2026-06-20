<?php
// ============================================================
// CONSULTAR_FORNECEDOR.PHP
// Apresenta a ficha de detalhes de um fornecedor, identificado
// por ID encriptado recebido via query string, incluindo os
// equipamentos associados e a documentação anexada (se existir).
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Desencriptar e validar o ID do fornecedor recebido na URL
$idFornecedorEncriptado = $_GET['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncriptado);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

// Obter os dados do fornecedor, os equipamentos associados e a documentação
try {
    $ligacao = conectar_bd();

    $stmt = $ligacao->prepare("
        SELECT f.*, tf.designacao AS tipo_fornecedor, m.designacao AS morada
        FROM fornecedores f
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        LEFT JOIN moradas m ON f.morada_id = m.id
        WHERE f.id = :id
    ");
    $stmt->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fornecedor) {
        echo "<p class='text-danger'>Fornecedor não encontrado.</p>";
        exit;
    }

    $stmtEquip = $ligacao->prepare("
        SELECT e.codigo, e.designacao, ee.designacao AS estado, c.designacao AS criticidade
        FROM equipamento_fornecedor ef
        JOIN equipamentos e ON e.id = ef.equipamento_id
        LEFT JOIN estados_equipamento ee ON e.estado_id = ee.id
        LEFT JOIN criticidades c ON e.criticidade_id = c.id
        WHERE ef.fornecedor_id = :id
        ORDER BY e.codigo
    ");
    $stmtEquip->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtEquip->execute();
    $equipamentosAssociados = $stmtEquip->fetchAll(PDO::FETCH_ASSOC);

    $stmtDoc = $ligacao->prepare("
        SELECT df.*, tdf.designacao AS tipo_documento
        FROM documentacao_fornecedores df
        LEFT JOIN tipos_documento_fornecedor tdf ON df.tipo_documento_id = tdf.id
        WHERE df.fornecedor_id = :id
        LIMIT 1
    ");
    $stmtDoc->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmtDoc->execute();
    $documentacao = $stmtDoc->fetch(PDO::FETCH_ASSOC);
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

        <!-- Card dos detalhes do fornecedor -->
        <section class="detalhes-equipamento-privada">

            <!-- Título da ficha -->
            <div class="titulo-detalhes-equipamento">
    <i class="fa-solid fa-truck-medical"></i>
    <h1>
        Detalhes do Fornecedor
        <?php if ($fornecedor['ativo'] == 1): ?>
            <span class="badge bg-success" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Ativo</span>
        <?php else: ?>
            <span class="badge bg-secondary" style="font-size: 0.9rem; vertical-align: middle; padding: 5px 10px;">Inativo</span>
        <?php endif; ?>
    </h1>
</div>

            <hr>

            <!-- Dados Gerais -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-building"></i>
                Dados Gerais
            </h5>

            <div class="grelha-detalhes-equipamento">

                <div class="campo-detalhes">
                    <h3>Código do fornecedor</h3>
                    <p id="detalhe-codigo-fornecedor"><?= htmlspecialchars($fornecedor['codigo']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Nome da empresa</h3>
                    <p id="detalhe-nome-empresa"><?= htmlspecialchars($fornecedor['nome_empresa']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>NIF</h3>
                    <p id="detalhe-nif"><?= htmlspecialchars($fornecedor['nif']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Tipo de fornecedor</h3>
                    <p id="detalhe-tipo-fornecedor"><?= htmlspecialchars($fornecedor['tipo_fornecedor']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Website geral</h3>
                    <p id="detalhe-website"><?= htmlspecialchars($fornecedor['website']) ?></p>
                </div>

            </div>

            <!-- Contactos -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-phone"></i>
                Contactos
            </h5>

            <div class="grelha-detalhes-equipamento">

                <div class="campo-detalhes">
                    <h3>Contacto telefónico geral</h3>
                    <p id="detalhe-telefone"><?= htmlspecialchars($fornecedor['telefone']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Email geral</h3>
                    <p id="detalhe-email"><?= htmlspecialchars($fornecedor['email']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Pessoa de contacto</h3>
                    <p id="detalhe-pessoa-contacto"><?= htmlspecialchars($fornecedor['pessoa_contacto']) ?></p>
                </div>

                <div class="campo-detalhes">
                    <h3>Telefone da pessoa de contacto</h3>
                    <p id="detalhe-telefone-pessoa-contacto"><?= htmlspecialchars($fornecedor['telefone_pessoa_contacto']) ?></p>
                </div>

            </div>

            <!-- Localização -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-location-dot"></i>
                Localização
            </h5>

            <div class="grelha-detalhes-equipamento">

                <div class="campo-detalhes">
                    <h3>Morada</h3>
                    <p id="detalhe-morada"><?= htmlspecialchars($fornecedor['morada']) ?></p>
                </div>

            </div>

            <!-- Equipamentos associados a este fornecedor -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-stethoscope"></i>
                Equipamentos Associados
            </h5>

            <div id="equipamentos-do-fornecedor">
    <?php if (empty($equipamentosAssociados)) : ?>
        <p class="text-muted">Não existem equipamentos associados a este fornecedor.</p>
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
                    // Mapas de classes CSS para colorir os badges de criticidade e estado
                    $classesCriticidadeFornecedor = [
                        'Suporte de vida' => 'badge-criticidade-suporte',
                        'Alta' => 'badge-criticidade-alta',
                        'Média' => 'badge-criticidade-media',
                        'Baixa' => 'badge-criticidade-baixa'
                    ];
                    $classesEstadoFornecedor = [
                        'Ativo' => 'estado-ativo',
                        'Em manutenção' => 'estado-manutencao',
                        'Em calibração' => 'estado-calibracao',
                        'Inativo' => 'estado-inativo',
                        'Em quarentena' => 'estado-quarentena',
                        'Abatido' => 'estado-abatido'
                    ];
                    ?>
                    <?php foreach ($equipamentosAssociados as $equip) : ?>
                        <?php
                        $classeCriticidadeF = $classesCriticidadeFornecedor[$equip['criticidade']] ?? '';
                        $classeEstadoF = $classesEstadoFornecedor[$equip['estado']] ?? '';
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($equip['codigo']) ?></td>
                            <td><?= htmlspecialchars($equip['designacao']) ?></td>
                            <td><span class="<?= $classeEstadoF ?>"><?= htmlspecialchars($equip['estado']) ?></span></td>
                            <td>
                                <span class="badge-detalhe <?= $classeCriticidadeF ?>"><?= htmlspecialchars($equip['criticidade']) ?></span>
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

            <!-- Documentação do Fornecedor -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-file-medical"></i>
                Documentação do Fornecedor
            </h5>

            <div class="accordion-documentacao">

                <div class="accordion-item-doc">
                    <button class="accordion-btn-doc" onclick="toggleAccordionDoc(this)">
                        <span>
                            <i class="fa-solid fa-file-medical"></i>
                            Documentação associada ao fornecedor
                        </span>
                        <div class="accordion-btn-doc-direita">
                            <span id="badge-accordion-doc-fornecedor-detalhe" class="badge-detalhe <?= $documentacao ? 'badge-sim' : 'badge-nao' ?>"><?= $documentacao ? 'Sim' : 'Não' ?></span>
                            <i class="fa-solid fa-chevron-down icone-accordion-doc"></i>
                        </div>
                    </button>
                    <div class="accordion-body-doc" style="display:none;">
                        <?php if (!$documentacao) : ?>
                            <p class="text-muted" style="padding: 1.2rem 0 0.5rem;">Não existe documentação associada a este fornecedor.</p>
                        <?php else : ?>
                            <div class="grelha-detalhes-equipamento" style="padding: 1.2rem 0 0.5rem;">
                                <div class="campo-detalhes">
                                    <h3>Tipo de documento</h3>
                                    <p id="detalhe-tipo-doc-fornecedor"><?= htmlspecialchars($documentacao['tipo_documento']) ?></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Nome do documento</h3>
                                    <p id="detalhe-nome-doc-fornecedor"><?= htmlspecialchars($documentacao['nome_documento']) ?></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Data do documento</h3>
                                    <p id="detalhe-data-doc-fornecedor"><?= date('d/m/Y', strtotime($documentacao['data_documento'])) ?></p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Validade</h3>
                                    <p id="detalhe-validade-doc-fornecedor">
                                        <?= $documentacao['validade_documento'] ? date('d/m/Y', strtotime($documentacao['validade_documento'])) : 'Sem validade definida' ?>
                                    </p>
                                </div>
                                <div class="campo-detalhes">
                                    <h3>Ficheiro PDF</h3>
                                    <p id="detalhe-ficheiro-doc-fornecedor">
                                        <?php if (!empty($documentacao['ficheiro_documento'])) : ?>
                                            <a href="<?= BASE_URL ?>/uploads/documentacao_fornecedores/<?= htmlspecialchars($documentacao['ficheiro_documento']) ?>" target="_blank" style="color: #005fae; font-weight: 600;">
                                                <i class="fa-solid fa-file-pdf me-1"></i>
                                                <?= htmlspecialchars($documentacao['nome_original_ficheiro'] ?? 'Ver ficheiro') ?>
                                            </a>
                                        <?php else : ?>
                                            Sem ficheiro associado
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Observações -->
            <h5 class="subtitulo-separador titulo-azul-separador">
                <i class="fa-solid fa-comment-medical"></i>
                Observações
            </h5>

            <div class="grelha-detalhes-equipamento">

                <div class="campo-detalhes campo-detalhes-largo">
                    <h3>Observações</h3>
                    <p id="detalhe-observacoes-fornecedor"><?= htmlspecialchars($fornecedor['observacoes']) ?></p>
                </div>

            </div>

            <!-- Botões -->
            <div class="botoes-detalhes-equipamento">
                <a href="fornecedores.php" class="botao-voltar-detalhes">
                    <i class="fa-solid fa-arrow-left"></i>
                    Voltar
                </a>
            </div>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>