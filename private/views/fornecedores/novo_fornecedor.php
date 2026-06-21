<?php
// ============================================================
// NOVO_FORNECEDOR.PHP
// Formulário de criação de um novo fornecedor. Recolhe os dados
// submetidos, valida-os (incluindo unicidade de código, NIF,
// telefone e email) e, se válidos, insere o fornecedor e a
// respetiva documentação (se enviada) na base de dados.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
require_once __DIR__ . '/../../includes/validacoes.php';

$erros = [];

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO (submissão POST)
// --------------------------------------------------------------------
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    // 1. Recolher dados
    $codigo = trim($_POST["codigo"] ?? "");
    $nome_empresa = trim($_POST["nome_empresa"] ?? "");
    $nif = trim($_POST["nif"] ?? "");
    $tipo_fornecedor = trim($_POST["tipo_fornecedor"] ?? "");
    $website = trim($_POST["website"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $pessoa_contacto = trim($_POST["pessoa_contacto"] ?? "");
    $telefone_pessoa_contacto = trim($_POST["telefone_pessoa_contacto"] ?? "");
    $morada = trim($_POST["morada"] ?? "");
    $observacoes = trim($_POST["observacoes"] ?? "");
    $tem_doc_fornecedor = $_POST["tem_doc_fornecedor"] ?? "";
    $tipoDocFornecedor = trim($_POST["tipoDocFornecedor"] ?? "");
    $nomeDocFornecedor = trim($_POST["nomeDocFornecedor"] ?? "");
    $dataDocFornecedor = $_POST["dataDocFornecedor"] ?? "";
    $validadeDocFornecedor = $_POST["validadeDocFornecedor"] ?? "";
 
    // 2. Imprimir os dados recebidos (para teste)
    /*
    echo "<p><strong>Dados recebidos:</strong> Código: $codigo | Nome empresa: $nome_empresa
        | NIF: $nif | Tipo: $tipo_fornecedor | Website: $website | Telefone: $telefone
        | Email: $email | Pessoa contacto: $pessoa_contacto | Telefone pessoa: $telefone_pessoa_contacto
        | Morada: $morada | Observações: $observacoes | Tem doc: $tem_doc_fornecedor
        | Tipo doc: $tipoDocFornecedor | Nome doc: $nomeDocFornecedor | Data doc: $dataDocFornecedor
        | Validade doc: $validadeDocFornecedor</p>";
    */
 
    // 3. Validar os dados
 
    // --- Validações dos campos gerais (reutilizáveis em validacoes.php) ---
    $erros = array_merge(
        $erros,
        validar_codigo_fornecedor($codigo),
        validar_nome_empresa($nome_empresa),
        validar_nif($nif),
        validar_tipo_fornecedor($tipo_fornecedor),
        validar_website($website),
        validar_telefone($telefone),
        validar_email_fornecedor($email),
        validar_pessoa_contacto($pessoa_contacto),
        validar_telefone_pessoa_contacto($telefone_pessoa_contacto),
        validar_morada($morada),
        validar_observacoes_fornecedor($observacoes)
    );
 
    // --- Documentação do fornecedor (reutilizável em validacoes.php) ---
    $erros = array_merge(
        $erros,
        validar_documentacao_fornecedor($tem_doc_fornecedor, $tipoDocFornecedor, $nomeDocFornecedor, $dataDocFornecedor, $validadeDocFornecedor)
    );

    // --- Validações de unicidade (codigo, NIF, telefone, email) ---
    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            // Código único
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE codigo = :codigo");
            $stmt->execute([':codigo' => $codigo]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o código \"$codigo\".";
            }

            // NIF único
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE nif = :nif");
            $stmt->execute([':nif' => $nif]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o NIF \"$nif\".";
            }

            // Telefone geral único
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE telefone = :telefone");
            $stmt->execute([':telefone' => $telefone]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o telefone \"$telefone\".";
            }

            // Email geral único
            $stmt = $ligacao->prepare("SELECT COUNT(*) FROM fornecedores WHERE email = :email");
            $stmt->execute([':email' => $email]);
            if ($stmt->fetchColumn() > 0) {
                $erros[] = "Já existe um fornecedor registado com o email \"$email\".";
            }

            $ligacao = null;

        } catch (PDOException $err) {
            $erros[] = "Erro ao verificar duplicados: " . $err->getMessage();
        }
    }
 
    // 4. Se não houver erros, guardar na base de dados
    $erro_sistema = "";

    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            // Resolver tipo_id a partir do nome do tipo de fornecedor
            $stmt = $ligacao->prepare("SELECT id FROM tipos_fornecedor WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $tipo_fornecedor]);
            $tipo_id = $stmt->fetchColumn();

            // Resolver morada_id a partir do texto da morada
            $stmt = $ligacao->prepare("SELECT id FROM moradas WHERE designacao = :designacao");
            $stmt->execute([':designacao' => $morada]);
            $morada_id = $stmt->fetchColumn();

            // Insert do fornecedor
            $sql = "INSERT INTO fornecedores (
                codigo, nome_empresa, nif, telefone, email, morada_id, website,
                pessoa_contacto, telefone_pessoa_contacto, tipo_id, observacoes
            ) VALUES (
                :codigo, :nome_empresa, :nif, :telefone, :email, :morada_id, :website,
                :pessoa_contacto, :telefone_pessoa_contacto, :tipo_id, :observacoes
            )";

            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':nome_empresa' => $nome_empresa,
                ':nif' => $nif,
                ':telefone' => $telefone,
                ':email' => $email,
                ':morada_id' => $morada_id,
                ':website' => $website,
                ':pessoa_contacto' => $pessoa_contacto,
                ':telefone_pessoa_contacto' => $telefone_pessoa_contacto,
                ':tipo_id' => $tipo_id,
                ':observacoes' => $observacoes
            ]);

            $fornecedor_id = $ligacao->lastInsertId();

            // Documentação do fornecedor (se aplicável)
            if ($tem_doc_fornecedor === "sim") {

                // Resolver tipo_documento_id
                $stmt = $ligacao->prepare("SELECT id FROM tipos_documento_fornecedor WHERE designacao = :designacao");
                $stmt->execute([':designacao' => $tipoDocFornecedor]);
                $tipo_documento_id = $stmt->fetchColumn();

                // Processar upload do ficheiro (se enviado)
                $nomeFicheiroGuardado = "";
                $nomeOriginalFicheiro = "";

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

                $sqlDoc = "INSERT INTO documentacao_fornecedores (
                    fornecedor_id, tipo_documento_id, nome_documento, data_documento,
                    validade_documento, ficheiro_documento, nome_original_ficheiro
                ) VALUES (
                    :fornecedor_id, :tipo_documento_id, :nome_documento, :data_documento,
                    :validade_documento, :ficheiro_documento, :nome_original_ficheiro
                )";

                $stmtDoc = $ligacao->prepare($sqlDoc);
                $stmtDoc->execute([
                    ':fornecedor_id' => $fornecedor_id,
                    ':tipo_documento_id' => $tipo_documento_id,
                    ':nome_documento' => $nomeDocFornecedor,
                    ':data_documento' => $dataDocFornecedor,
                    ':validade_documento' => $validadeDocFornecedor !== "" ? $validadeDocFornecedor : null,
                    ':ficheiro_documento' => $nomeFicheiroGuardado,
                    ':nome_original_ficheiro' => $nomeOriginalFicheiro
                ]);
            }

            $_SESSION['mensagem_sucesso'] = 'Fornecedor criado com sucesso.';
            header("Location: fornecedores.php");
            exit;

        } catch (PDOException $err) {
            $erro_sistema = "Erro ao gravar os dados: " . $err->getMessage();
        }

        $ligacao = null;
    }
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de criação de novo fornecedor -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-plus"></i>
                    Inserir novo fornecedor
                </h1>
            </div>

            <hr>

            <form id="form-novo-fornecedor" class="form-equipamento-privado" action="#" method="post" enctype="multipart/form-data" novalidate>

                <!-- DADOS GERAIS -->
                <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                    <i class="fa-solid fa-building"></i>
                    Dados Gerais
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código do fornecedor</label>
                        <input type="text" class="form-control campo-formulario-privado" id="codigo" name="codigo"
                            placeholder="Ex.: FOR001" value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="nome_empresa" class="form-label">Nome da empresa</label>
                        <input type="text" class="form-control campo-formulario-privado" id="nome_empresa"
                            name="nome_empresa" value="<?= htmlspecialchars($_POST['nome_empresa'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="nif" class="form-label">NIF</label>
                        <input type="text" class="form-control campo-formulario-privado" id="nif" name="nif"
                            value="<?= htmlspecialchars($_POST['nif'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_fornecedor" class="form-label">Tipo de fornecedor</label>
                        <?php $tipoFornecedorSelecionado = $_POST['tipo_fornecedor'] ?? ''; ?>
                        <select class="form-select campo-formulario-privado" id="tipo_fornecedor"
                            name="tipo_fornecedor">
                            <option value="" disabled <?= $tipoFornecedorSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                            <option <?= $tipoFornecedorSelecionado === 'Fabricante' ? 'selected' : '' ?>>Fabricante</option>
                            <option <?= $tipoFornecedorSelecionado === 'Distribuidor ou Fornecedor comercial' ? 'selected' : '' ?>>Distribuidor ou Fornecedor comercial</option>
                            <option <?= $tipoFornecedorSelecionado === 'Empresa de assistência técnica' ? 'selected' : '' ?>>Empresa de assistência técnica</option>
                            <option <?= $tipoFornecedorSelecionado === 'Fornecedor de consumíveis ou acessórios' ? 'selected' : '' ?>>Fornecedor de consumíveis ou acessórios</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="website" class="form-label">Website geral</label>
                        <input type="text" class="form-control campo-formulario-privado" id="website" name="website"
                            placeholder="Ex.: www.empresa.pt" value="<?= htmlspecialchars($_POST['website'] ?? '') ?>">
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
                        <input type="text" class="form-control campo-formulario-privado" id="telefone"
                            name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email geral</label>
                        <input type="text" class="form-control campo-formulario-privado" id="email" name="email"
                            placeholder="Ex.: contacto@empresa.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pessoa_contacto" class="form-label">Pessoa de contacto</label>
                        <input type="text" class="form-control campo-formulario-privado" id="pessoa_contacto"
                            name="pessoa_contacto" value="<?= htmlspecialchars($_POST['pessoa_contacto'] ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="telefone_pessoa_contacto" class="form-label">Telefone da pessoa de
                            contacto</label>
                        <input type="text" class="form-control campo-formulario-privado"
                            id="telefone_pessoa_contacto" name="telefone_pessoa_contacto"
                            value="<?= htmlspecialchars($_POST['telefone_pessoa_contacto'] ?? '') ?>">
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
$moradaSelecionada = $_POST['morada'] ?? '';
$listaMoradas = [
    'Aveiro, Portugal', 'Beja, Portugal', 'Braga, Portugal', 'Bragança, Portugal',
    'Castelo Branco, Portugal', 'Coimbra, Portugal', 'Évora, Portugal', 'Faro, Portugal',
    'Guarda, Portugal', 'Leiria, Portugal', 'Lisboa, Portugal', 'Portalegre, Portugal',
    'Porto, Portugal', 'Santarém, Portugal', 'Setúbal, Portugal',
    'Viana do Castelo, Portugal', 'Vila Real, Portugal', 'Viseu, Portugal',
    'Região Autónoma dos Açores, Portugal', 'Região Autónoma da Madeira, Portugal'
];
?>
                        <select class="form-select campo-formulario-privado" id="morada" name="morada">
                            <option value="" disabled <?= $moradaSelecionada === '' ? 'selected' : '' ?>>Escolha uma morada</option>
                            <?php foreach ($listaMoradas as $m): ?>
                                <option value="<?= htmlspecialchars($m) ?>" <?= $moradaSelecionada === $m ? 'selected' : '' ?>><?= htmlspecialchars($m) ?></option>
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
                    <?php $temDocSelecionado = $_POST['tem_doc_fornecedor'] ?? ''; ?>
                    <select id="tem_doc_fornecedor" name="tem_doc_fornecedor" class="campo-formulario-privado">
                        <option value="" <?= $temDocSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                        <option value="sim" <?= $temDocSelecionado === 'sim' ? 'selected' : '' ?>>Sim</option>
                        <option value="nao" <?= $temDocSelecionado === 'nao' ? 'selected' : '' ?>>Não</option>
                    </select>
                </div>

                <?php $estiloBlocoDoc = ($_POST['tem_doc_fornecedor'] ?? '') === 'sim' ? '' : 'style="display:none"'; ?>
                <div id="bloco-doc-fornecedor" <?= $estiloBlocoDoc ?>>
                    <div class="card-documentacao">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipo de documento</label>
                                <?php $tipoDocSelecionado = $_POST['tipoDocFornecedor'] ?? ''; ?>
                                <select class="form-select campo-formulario-privado" id="tipoDocFornecedor"
                                    name="tipoDocFornecedor">
                                    <option value="" disabled <?= $tipoDocSelecionado === '' ? 'selected' : '' ?>>Escolha uma opção</option>
                                    <option <?= $tipoDocSelecionado === 'Certificado ISO' ? 'selected' : '' ?>>Certificado ISO</option>
                                    <option <?= $tipoDocSelecionado === 'Licença de distribuição' ? 'selected' : '' ?>>Licença de distribuição</option>
                                    <option <?= $tipoDocSelecionado === 'Certificado de acreditação técnica' ? 'selected' : '' ?>>Certificado de acreditação técnica</option>
                                    <option <?= $tipoDocSelecionado === 'Contrato geral de prestação de serviços' ? 'selected' : '' ?>>Contrato geral de prestação de serviços</option>
                                    <option <?= $tipoDocSelecionado === 'Alvará ou licença de atividade' ? 'selected' : '' ?>>Alvará ou licença de atividade</option>
                                    <option <?= $tipoDocSelecionado === 'Declaração de autorização de representação' ? 'selected' : '' ?>>Declaração de autorização de representação</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nome do documento</label>
                                <input type="text" class="form-control campo-formulario-privado"
                                    id="nomeDocFornecedor" name="nomeDocFornecedor"
                                    value="<?= htmlspecialchars($_POST['nomeDocFornecedor'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Data do documento</label>
                                <input type="date" class="form-control campo-formulario-privado"
                                    id="dataDocFornecedor" name="dataDocFornecedor"
                                    value="<?= htmlspecialchars($_POST['dataDocFornecedor'] ?? '') ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Validade <span
                                        style="color:#6b7280; font-size:0.85rem;">(se aplicável)</span></label>
                                <input type="date" class="form-control campo-formulario-privado"
                                    id="validadeDocFornecedor" name="validadeDocFornecedor"
                                    value="<?= htmlspecialchars($_POST['validadeDocFornecedor'] ?? '') ?>">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Ficheiro PDF</label>
                                <input type="file" class="form-control campo-formulario-privado"
                                    id="ficheiroDocFornecedor" name="ficheiroDocFornecedor" accept=".pdf">
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
                    <textarea class="form-control campo-formulario-privado" id="observacoes" name="observacoes"
                        rows="4"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
                </div>

                <?php if (!empty($erros)): ?>
                <div id="erros-formulario" class="erros-separador alert alert-danger">
                    <ul id="lista-erros-formulario">
                        <?php foreach ($erros as $erro): ?>
                            <li><?= htmlspecialchars($erro) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if (!empty($erro_sistema)) : ?>
                    <div class="alert alert-danger">
                        <strong>Erro:</strong>
                        <p><?= htmlspecialchars($erro_sistema) ?></p>
                    </div>
                <?php endif; ?>

                <div class="botoes-formulario-privado">
                    <a href="fornecedores.php" class="botao-cancelar-privado">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="botao-guardar-privado">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar
                    </button>
                </div>

            </form>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>