<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
require_once __DIR__ . '/../../includes/validacoes.php';

// Permitir apenas pedidos GET (clicar em "Editar") ou POST (submeter o formulário)
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/private/iniciar_sessao.php');
    exit;
}

// Recolhe e desencripta o ID do fornecedor recebido na URL
$idFornecedorEncriptado = $_GET['id_fornecedor'] ?? null;
$idFornecedor = aes_decrypt($idFornecedorEncriptado);

if (!$idFornecedor || !is_numeric($idFornecedor)) {
    header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
    exit;
}

$erros = [];

// Deteta a submissão do formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recolher dados (campos gerais)
    $codigo = trim($_POST['codigo'] ?? '');
    $nome_empresa = trim($_POST['nome_empresa'] ?? '');
    $nif = trim($_POST['nif'] ?? '');
    $tipo_fornecedor = trim($_POST['tipo_fornecedor'] ?? '');
    $website = trim($_POST['website'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pessoa_contacto = trim($_POST['pessoa_contacto'] ?? '');
    $telefone_pessoa_contacto = trim($_POST['telefone_pessoa_contacto'] ?? '');
    $morada = trim($_POST['morada'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    // Campos da documentação
    $tem_doc_fornecedor = $_POST['tem_doc_fornecedor'] ?? '';
    $tipoDocFornecedor = trim($_POST['tipoDocFornecedor'] ?? '');
    $nomeDocFornecedor = trim($_POST['nomeDocFornecedor'] ?? '');
    $dataDocFornecedor = $_POST['dataDocFornecedor'] ?? '';
    $validadeDocFornecedor = $_POST['validadeDocFornecedor'] ?? '';

    // 2. Validar os campos gerais e a documentação (funções reutilizáveis em validacoes.php)
    $erros = array_merge(
        $erros,
        validar_nome_empresa($nome_empresa),
        validar_nif($nif),
        validar_tipo_fornecedor($tipo_fornecedor),
        validar_website($website),
        validar_telefone($telefone),
        validar_email_fornecedor($email),
        validar_pessoa_contacto($pessoa_contacto),
        validar_telefone_pessoa_contacto($telefone_pessoa_contacto),
        validar_morada($morada),
        validar_observacoes_fornecedor($observacoes),
        validar_documentacao_fornecedor($tem_doc_fornecedor, $tipoDocFornecedor, $nomeDocFornecedor, $dataDocFornecedor, $validadeDocFornecedor)
    );

    // 3. Validações de unicidade (NIF, telefone, email) — excluindo o próprio fornecedor
    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE nif = :nif AND id != :id");
            $stmt->execute([':nif' => $nif, ':id' => $idFornecedor]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o NIF \"$nif\".";
            }

            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE telefone = :telefone AND id != :id");
            $stmt->execute([':telefone' => $telefone, ':id' => $idFornecedor]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o telefone \"$telefone\".";
            }

            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE email = :email AND id != :id");
            $stmt->execute([':email' => $email, ':id' => $idFornecedor]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o email \"$email\".";
            }

            $ligacao = null;
        } catch (PDOException $err) {
            $erros[] = "Erro ao verificar duplicados: " . $err->getMessage();
        }
    }

    // 4. Se não houver erros, atualizar os dados gerais do fornecedor
    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Resolver tipo_id e morada_id
            $stmt = $ligacao->prepare("SELECT id FROM tipos_fornecedor WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $tipo_fornecedor]);
            $tipo_id = $stmt->fetchColumn();

            $stmt = $ligacao->prepare("SELECT id FROM moradas WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $morada]);
            $morada_id = $stmt->fetchColumn();

            $stmt = $ligacao->prepare("
                UPDATE fornecedores
                SET nome_empresa = :nome_empresa,
                    nif = :nif,
                    telefone = :telefone,
                    email = :email,
                    morada_id = :morada_id,
                    website = :website,
                    pessoa_contacto = :pessoa_contacto,
                    telefone_pessoa_contacto = :telefone_pessoa_contacto,
                    tipo_id = :tipo_id,
                    observacoes = :observacoes
                WHERE id = :id
            ");
            $stmt->execute([
                ':nome_empresa' => $nome_empresa,
                ':nif' => $nif,
                ':telefone' => $telefone,
                ':email' => $email,
                ':morada_id' => $morada_id,
                ':website' => $website,
                ':pessoa_contacto' => $pessoa_contacto,
                ':telefone_pessoa_contacto' => $telefone_pessoa_contacto,
                ':tipo_id' => $tipo_id,
                ':observacoes' => $observacoes,
                ':id' => $idFornecedor
            ]);

            // Verificar se já existe documentação associada a este fornecedor
            $stmt = $ligacao->prepare("SELECT id, ficheiro_documento, nome_original_ficheiro FROM documentacao_fornecedores WHERE fornecedor_id = :id LIMIT 1");
            $stmt->execute([':id' => $idFornecedor]);
            $docExistente = $stmt->fetch(PDO::FETCH_OBJ);

            if ($tem_doc_fornecedor === "sim") {

                // Resolver tipo_documento_id
                $stmt = $ligacao->prepare("SELECT id FROM tipos_documento_fornecedor WHERE designacao = :designacao");
                $stmt->execute([':designacao' => $tipoDocFornecedor]);
                $tipo_documento_id = $stmt->fetchColumn();

                // Manter ficheiro atual por defeito; só substitui se for enviado um novo
                $nomeFicheiroGuardado = $docExistente->ficheiro_documento ?? '';
                $nomeOriginalFicheiro = $docExistente->nome_original_ficheiro ?? '';

                if (isset($_FILES['ficheiroDocFornecedor']) && $_FILES['ficheiroDocFornecedor']['error'] === UPLOAD_ERR_OK) {
                    $nomeOriginalFicheiro = $_FILES['ficheiroDocFornecedor']['name'];
                    $extensao = strtolower(pathinfo($nomeOriginalFicheiro, PATHINFO_EXTENSION));
                    $nomeFicheiroGuardado = "doc_fornecedor_" . $codigo . "_" . time() . "." . $extensao;

                    $pastaDestino = __DIR__ . "/../../../uploads/documentacao_fornecedores/";

                    if (!is_dir($pastaDestino)) {
                        mkdir($pastaDestino, 0755, true);
                    }

                    move_uploaded_file(
                        $_FILES['ficheiroDocFornecedor']['tmp_name'],
                        $pastaDestino . $nomeFicheiroGuardado
                    );
                }

                if ($docExistente) {
                    $stmtDoc = $ligacao->prepare("
                        UPDATE documentacao_fornecedores
                        SET tipo_documento_id = :tipo_documento_id,
                            nome_documento = :nome_documento,
                            data_documento = :data_documento,
                            validade_documento = :validade_documento,
                            ficheiro_documento = :ficheiro_documento,
                            nome_original_ficheiro = :nome_original_ficheiro
                        WHERE id = :id_doc
                    ");
                    $stmtDoc->execute([
                        ':tipo_documento_id' => $tipo_documento_id,
                        ':nome_documento' => $nomeDocFornecedor,
                        ':data_documento' => $dataDocFornecedor,
                        ':validade_documento' => $validadeDocFornecedor !== "" ? $validadeDocFornecedor : null,
                        ':ficheiro_documento' => $nomeFicheiroGuardado,
                        ':nome_original_ficheiro' => $nomeOriginalFicheiro,
                        ':id_doc' => $docExistente->id
                    ]);
                } else {
                    $stmtDoc = $ligacao->prepare("
                        INSERT INTO documentacao_fornecedores (
                            fornecedor_id, tipo_documento_id, nome_documento, data_documento,
                            validade_documento, ficheiro_documento, nome_original_ficheiro
                        ) VALUES (
                            :fornecedor_id, :tipo_documento_id, :nome_documento, :data_documento,
                            :validade_documento, :ficheiro_documento, :nome_original_ficheiro
                        )
                    ");
                    $stmtDoc->execute([
                        ':fornecedor_id' => $idFornecedor,
                        ':tipo_documento_id' => $tipo_documento_id,
                        ':nome_documento' => $nomeDocFornecedor,
                        ':data_documento' => $dataDocFornecedor,
                        ':validade_documento' => $validadeDocFornecedor !== "" ? $validadeDocFornecedor : null,
                        ':ficheiro_documento' => $nomeFicheiroGuardado,
                        ':nome_original_ficheiro' => $nomeOriginalFicheiro
                    ]);
                }
            } else {
                if ($docExistente) {
                    $stmtDoc = $ligacao->prepare("DELETE FROM documentacao_fornecedores WHERE id = :id_doc");
                    $stmtDoc->execute([':id_doc' => $docExistente->id]);

                    if (!empty($docExistente->ficheiro_documento)) {
                        $caminhoFicheiro = __DIR__ . "/../../../uploads/documentacao_fornecedores/" . $docExistente->ficheiro_documento;
                        if (file_exists($caminhoFicheiro)) {
                            unlink($caminhoFicheiro);
                        }
                    }
                }
            }

            $ligacao = null;

            header('Location: fornecedores.php');
            exit;
        } catch (PDOException $err) {
            $erros[] = "Erro ao atualizar o fornecedor: " . $err->getMessage();
        }
    }
}

// Ligação à base de dados e obtenção dos dados atuais do fornecedor
try {
    $ligacao = new PDO(
        "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
        MYSQL_USERNAME,
        MYSQL_PASSWORD
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $ligacao->prepare("
        SELECT f.*, tf.designacao AS tipo_fornecedor, m.designacao AS morada
        FROM fornecedores f
        LEFT JOIN tipos_fornecedor tf ON f.tipo_id = tf.id
        LEFT JOIN moradas m ON f.morada_id = m.id
        WHERE f.id = :id
    ");
    $stmt->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmt->execute();
    $fornecedor = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$fornecedor) {
        header('Location: ' . BASE_URL . '/private/views/fornecedores/fornecedores.php');
        exit;
    }

    $stmt = $ligacao->prepare("
        SELECT df.*, tdf.designacao AS tipo_documento
        FROM documentacao_fornecedores df
        LEFT JOIN tipos_documento_fornecedor tdf ON df.tipo_documento_id = tdf.id
        WHERE df.fornecedor_id = :id
        LIMIT 1
    ");
    $stmt->bindParam(':id', $idFornecedor, PDO::PARAM_INT);
    $stmt->execute();
    $documentacao = $stmt->fetch(PDO::FETCH_OBJ);
} catch (PDOException $err) {
    $erros[] = "Erro na ligação à base de dados.";
    $fornecedor = null;
    $documentacao = null;
}

$ligacao = null;

if (!$fornecedor) {
    $fornecedor = (object) [
        'codigo' => '',
        'nome_empresa' => '',
        'nif' => '',
        'tipo_fornecedor' => '',
        'website' => '',
        'telefone' => '',
        'email' => '',
        'pessoa_contacto' => '',
        'telefone_pessoa_contacto' => '',
        'morada' => '',
        'observacoes' => ''
    ];
}

// Valores a apresentar nos <select>: se for um POST (mesmo com erros), mostra o que foi submetido;
// caso contrário (GET), mostra os valores atuais da base de dados
$tipoFornecedorAtual = $_SERVER['REQUEST_METHOD'] === 'POST' ? $tipo_fornecedor : $fornecedor->tipo_fornecedor;
$moradaAtual = $_SERVER['REQUEST_METHOD'] === 'POST' ? $morada : $fornecedor->morada;
$temDocAtual = $_SERVER['REQUEST_METHOD'] === 'POST' ? $tem_doc_fornecedor : ($documentacao ? 'sim' : 'nao');
$tipoDocAtual = $_SERVER['REQUEST_METHOD'] === 'POST' ? $tipoDocFornecedor : ($documentacao->tipo_documento ?? '');
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-pen-to-square"></i>
                    Editar fornecedor
                </h1>
            </div>

            <hr>

            <form id="form-editar-fornecedor" class="form-editar-equipamento-privado" action="editar_fornecedor.php?id_fornecedor=<?= htmlspecialchars($idFornecedorEncriptado) ?>" method="post" enctype="multipart/form-data" novalidate>

                <!-- DADOS GERAIS -->
                <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                    <i class="fa-solid fa-building"></i>
                    Dados Gerais
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código do fornecedor</label>
                        <input type="text" class="form-control campo-formulario-privado" id="codigo" name="codigo" value="<?= htmlspecialchars($fornecedor->codigo) ?>" readonly>
                    </div>
                    <div class="col-md-8">
                        <label for="nome_empresa" class="form-label">Nome da empresa</label>
                        <input type="text" class="form-control campo-formulario-privado" id="nome_empresa" name="nome_empresa" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $nome_empresa : $fornecedor->nome_empresa) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nif" class="form-label">NIF</label>
                        <input type="text" class="form-control campo-formulario-privado" id="nif" name="nif" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $nif : $fornecedor->nif) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_fornecedor" class="form-label">Tipo de fornecedor</label>
                        <select class="form-select campo-formulario-privado" id="tipo_fornecedor" name="tipo_fornecedor">
                            <option value="" disabled <?= empty($tipoFornecedorAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                            <option <?= $tipoFornecedorAtual === 'Fabricante' ? 'selected' : '' ?>>Fabricante</option>
                            <option <?= $tipoFornecedorAtual === 'Distribuidor ou Fornecedor comercial' ? 'selected' : '' ?>>Distribuidor ou Fornecedor comercial</option>
                            <option <?= $tipoFornecedorAtual === 'Empresa de assistência técnica' ? 'selected' : '' ?>>Empresa de assistência técnica</option>
                            <option <?= $tipoFornecedorAtual === 'Fornecedor de consumíveis ou acessórios' ? 'selected' : '' ?>>Fornecedor de consumíveis ou acessórios</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="website" class="form-label">Website geral</label>
                        <input type="text" class="form-control campo-formulario-privado" id="website" name="website" placeholder="Ex.: www.empresa.pt" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $website : $fornecedor->website) ?>">
                    </div>
                </div>

                <hr>

                <!-- CONTACTOS -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-phone"></i>
                    Contactos
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="telefone" class="form-label">Contacto telefónico geral</label>
                        <input type="text" class="form-control campo-formulario-privado" id="telefone" name="telefone" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $telefone : $fornecedor->telefone) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email geral</label>
                        <input type="text" class="form-control campo-formulario-privado" id="email" name="email" placeholder="Ex.: contacto@empresa.com" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $email : $fornecedor->email) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pessoa_contacto" class="form-label">Pessoa de contacto</label>
                        <input type="text" class="form-control campo-formulario-privado" id="pessoa_contacto" name="pessoa_contacto" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $pessoa_contacto : $fornecedor->pessoa_contacto) ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone_pessoa_contacto" class="form-label">Telefone da pessoa de
                            contacto</label>
                        <input type="text" class="form-control campo-formulario-privado" id="telefone_pessoa_contacto" name="telefone_pessoa_contacto" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $telefone_pessoa_contacto : $fornecedor->telefone_pessoa_contacto) ?>">
                    </div>
                </div>

                <hr>

                <!-- LOCALIZAÇÃO -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-location-dot"></i>
                    Localização
                </h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="morada" class="form-label">Morada</label>
                        <?php
                        $listaMoradas = [
                            'Aveiro, Portugal',
                            'Beja, Portugal',
                            'Braga, Portugal',
                            'Bragança, Portugal',
                            'Castelo Branco, Portugal',
                            'Coimbra, Portugal',
                            'Évora, Portugal',
                            'Faro, Portugal',
                            'Guarda, Portugal',
                            'Leiria, Portugal',
                            'Lisboa, Portugal',
                            'Portalegre, Portugal',
                            'Porto, Portugal',
                            'Santarém, Portugal',
                            'Setúbal, Portugal',
                            'Viana do Castelo, Portugal',
                            'Vila Real, Portugal',
                            'Viseu, Portugal',
                            'Região Autónoma dos Açores, Portugal',
                            'Região Autónoma da Madeira, Portugal'
                        ];
                        ?>
                        <select class="form-select campo-formulario-privado" id="morada" name="morada">
                            <option value="" disabled <?= empty($moradaAtual) ? 'selected' : '' ?>>Escolha uma morada</option>
                            <?php foreach ($listaMoradas as $m) : ?>
                                <option value="<?= htmlspecialchars($m) ?>" <?= $moradaAtual === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- DOCUMENTAÇÃO -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-file-medical"></i>
                    Documentação do Fornecedor
                </h5>

                <div class="grupo-campo-privado grupo-campo-total">
                    <label for="tem_doc_fornecedor">
                        Existe documentação associada ao fornecedor?
                    </label>
                    <select id="tem_doc_fornecedor" name="tem_doc_fornecedor" class="campo-formulario-privado">
                        <option value="" disabled <?= empty($temDocAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                        <option value="sim" <?= $temDocAtual === 'sim' ? 'selected' : '' ?>>Sim</option>
                        <option value="nao" <?= $temDocAtual === 'nao' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>

                <div id="bloco-doc-fornecedor" style="<?= $temDocAtual === 'sim' ? '' : 'display:none' ?>">
                    <div class="card-documentacao">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipo de documento</label>
                                <select class="form-select campo-formulario-privado" id="tipoDocFornecedor" name="tipoDocFornecedor">
                                    <option value="" disabled <?= empty($tipoDocAtual) ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $tipoDocAtual === 'Certificado ISO' ? 'selected' : '' ?>>Certificado ISO</option>
                                    <option <?= $tipoDocAtual === 'Licença de distribuição' ? 'selected' : '' ?>>Licença de distribuição</option>
                                    <option <?= $tipoDocAtual === 'Certificado de acreditação técnica' ? 'selected' : '' ?>>Certificado de acreditação técnica</option>
                                    <option <?= $tipoDocAtual === 'Contrato geral de prestação de serviços' ? 'selected' : '' ?>>Contrato geral de prestação de serviços</option>
                                    <option <?= $tipoDocAtual === 'Alvará ou licença de atividade' ? 'selected' : '' ?>>Alvará ou licença de atividade</option>
                                    <option <?= $tipoDocAtual === 'Declaração de autorização de representação' ? 'selected' : '' ?>>Declaração de autorização de representação</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nome do documento</label>
                                <input type="text" class="form-control campo-formulario-privado" id="nomeDocFornecedor" name="nomeDocFornecedor" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $nomeDocFornecedor : ($documentacao->nome_documento ?? '')) ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Data do documento</label>
                                <input type="date" class="form-control campo-formulario-privado" id="dataDocFornecedor" name="dataDocFornecedor" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $dataDocFornecedor : ($documentacao->data_documento ?? '')) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Validade <span
                                        style="color:#6b7280; font-size:0.85rem;">(se aplicável)</span></label>
                                <input type="date" class="form-control campo-formulario-privado" id="validadeDocFornecedor" name="validadeDocFornecedor" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $validadeDocFornecedor : ($documentacao->validade_documento ?? '')) ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ficheiro PDF</label>
                                <input type="file" class="form-control campo-formulario-privado"
                                    id="ficheiroDocFornecedor" name="ficheiroDocFornecedor" accept=".pdf">
                                <?php if (!empty($documentacao->nome_original_ficheiro)) : ?>
                                    <small class="form-text text-muted">Ficheiro atual: <?= htmlspecialchars($documentacao->nome_original_ficheiro) ?> (só é substituído se escolheres um novo)</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OBSERVAÇÕES -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h5>

                <div class="mb-3">
                    <textarea class="form-control campo-formulario-privado" id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $observacoes : $fornecedor->observacoes) ?></textarea>
                </div>

                <?php if (!empty($erros)) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php foreach ($erros as $erro) : ?>
                            <div><?= htmlspecialchars($erro) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="botoes-formulario-privado">
                    <a href="fornecedores.php" id="botao-cancelar-edicao-fornecedor"
                        class="botao-cancelar-privado">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="botao-guardar-privado">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar alterações
                    </button>
                </div>

            </form>

            <?php if ($temDocAtual === 'sim') : ?>
                <script>
                    window.addEventListener('load', function() {
                        const bloco = document.getElementById('bloco-doc-fornecedor');
                        if (bloco) {
                            bloco.style.display = 'block';
                        }
                    });
                </script>
            <?php endif; ?>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>