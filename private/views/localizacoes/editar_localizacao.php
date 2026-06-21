<?php
// ============================================================
// EDITAR_LOCALIZACAO.PHP
// Permite editar os dados de uma localização existente,
// identificada por ID encriptado. Apresenta o formulário
// pré-preenchido com os dados atuais e, ao submeter, valida e
// atualiza o registo na base de dados.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();
bloquear_profissional_saude();
require_once __DIR__ . '/../../includes/validacoes.php';

// Permitir apenas pedidos GET (clicar em "Editar") ou POST (submeter o formulário)
if (!in_array($_SERVER['REQUEST_METHOD'], ['GET', 'POST'])) {
    header('Location: ' . BASE_URL . '/private/iniciar_sessao.php');
    exit;
}

// Recolhe e desencripta o ID da localização recebido na URL
$idLocalizacaoEncriptado = $_GET['id_localizacao'] ?? null;
$idLocalizacao = aes_decrypt($idLocalizacaoEncriptado);

if (!$idLocalizacao || !is_numeric($idLocalizacao)) {
    header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
    exit;
}

$erros = [];

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO (submissão POST)
// --------------------------------------------------------------------
// Deteta a submissão do formulário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Recolher dados
    $codigo = $_POST['codigo'] ?? '';
    $servico = $_POST['servico'] ?? '';
    $edificio = $_POST['edificio'] ?? '';
    $piso = $_POST['piso'] ?? '';
    $sala = $_POST['sala'] ?? '';
    $observacoes = $_POST['observacoes'] ?? '';

    // 2. Limpar espaços
    $codigo = trim($codigo);
    $servico = trim($servico);
    $edificio = trim($edificio);
    $piso = trim($piso);
    $sala = trim($sala);
    $observacoes = trim($observacoes);

    // 3. Validar os dados (funções reutilizáveis em validacoes.php)
    $erros = array_merge(
        $erros,
        validar_codigo($codigo),
        validar_edificio($edificio),
        validar_piso($piso),
        validar_servico($servico),
        validar_sala($sala),
        validar_observacoes($observacoes)
    );

    // 4. Se não houver erros, atualizar a base de dados
    if (empty($erros)) {
        try {
            $ligacao = conectar_bd();

            $stmt = $ligacao->prepare("
                UPDATE localizacoes
                SET edificio = :edificio,
                    piso = :piso,
                    servico = :servico,
                    sala = :sala,
                    observacoes = :observacoes
                WHERE id = :id
            ");
            $stmt->execute([
                ':edificio' => $edificio,
                ':piso' => $piso,
                ':servico' => $servico,
                ':sala' => $sala,
                ':observacoes' => $observacoes,
                ':id' => $idLocalizacao
            ]);

            $ligacao = null;

            $_SESSION['mensagem_sucesso'] = 'Localização atualizada com sucesso.';
            header('Location: localizacoes.php');
            exit;
        } catch (PDOException $err) {
            registar_erro_log($err->getMessage());
            $erros[] = "Erro ao atualizar a localização: " . $err->getMessage();
        }
    }
}

// --------------------------------------------------------------------
// CARREGAMENTO DOS DADOS ATUAIS (para pré-preencher o formulário)
// --------------------------------------------------------------------
// Ligação à base de dados e obtenção dos dados atuais da localização
try {
    $ligacao = conectar_bd();

    $stmt = $ligacao->prepare("SELECT * FROM localizacoes WHERE id = :id");
    $stmt->bindParam(':id', $idLocalizacao, PDO::PARAM_INT);
    $stmt->execute();
    $localizacao = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$localizacao) {
        header('Location: ' . BASE_URL . '/private/views/localizacoes/localizacoes.php');
        exit;
    }
} catch (PDOException $err) {
    registar_erro_log($err->getMessage());
    $erros[] = "Erro na ligação à base de dados.";
    $localizacao = null;
}

$ligacao = null;

// Salvaguarda: se não foi possível obter a localização, usar valores vazios
if (!$localizacao) {
    $localizacao = (object) [
        'codigo' => '',
        'edificio' => '',
        'piso' => '',
        'servico' => '',
        'sala' => '',
        'observacoes' => ''
    ];
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de edição da localização -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-pen-to-square"></i>
                    Editar localização
                </h1>
            </div>

            <hr>

            <form id="form-editar-localizacao" class="form-editar-equipamento-privado" action="editar_localizacao.php?id_localizacao=<?= htmlspecialchars($idLocalizacaoEncriptado) ?>" method="post" novalidate>
                <!-- DADOS GERAIS -->
                <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                    <i class="fa-solid fa-location-dot"></i>
                    Dados Gerais
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código da localização</label>
                        <input type="text" class="form-control campo-formulario-privado" id="codigo" name="codigo" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $codigo : $localizacao->codigo) ?>" readonly>
                    </div>
                    <div class="col-md-8">
                        <label for="servico" class="form-label">Serviço / Departamento</label>
                        <input type="text" class="form-control campo-formulario-privado" id="servico" name="servico" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $servico : $localizacao->servico) ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="edificio" class="form-label">Edifício</label>
                        <input type="text" class="form-control campo-formulario-privado" id="edificio" name="edificio" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $edificio : $localizacao->edificio) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="piso" class="form-label">Piso</label>
                        <input type="text" class="form-control campo-formulario-privado" id="piso" name="piso" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $piso : $localizacao->piso) ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="sala" class="form-label">Sala / Gabinete</label>
                        <input type="text" class="form-control campo-formulario-privado" id="sala" name="sala" value="<?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $sala : $localizacao->sala) ?>">
                    </div>
                </div>

                <hr>

                <!-- OBSERVAÇÕES -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h5>

                <div class="mb-3">
                    <textarea class="form-control campo-formulario-privado" id="observacoes" name="observacoes" rows="4"><?= htmlspecialchars($_SERVER['REQUEST_METHOD'] === 'POST' ? $observacoes : $localizacao->observacoes) ?></textarea>
                </div>

                <?php if (!empty($erros)) : ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <?php foreach ($erros as $erro) : ?>
                            <div><?= htmlspecialchars($erro) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="botoes-formulario-privado">
                    <a href="localizacoes.php" id="botao-cancelar-edicao-localizacao" class="botao-cancelar-privado">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="botao-guardar-privado">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Guardar alterações
                    </button>
                </div>

            </form>

        </section>

    </main>

</div>

<?php include '../../includes/footer.php'; ?>