<?php
require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recolher dados
    // 1. Recolher dados
    $codigo = $_POST["codigo"] ?? "";
    $servico = $_POST["servico"] ?? "";
    $edificio = $_POST["edificio"] ?? "";
    $piso = $_POST["piso"] ?? "";
    $sala = $_POST["sala"] ?? "";
    $observacoes = $_POST["observacoes"] ?? "";

    // 2. Imprimir os dados recebidos (para teste)
    /*echo "<p><strong>Dados recebidos:</strong> Código: $codigo | Serviço: $servico
        | Edifício: $edificio | Piso: $piso | Sala: $sala | Observações: $observacoes</p>"; */

    // 3. Validar os dados
    $erros = [];

    $codigo = trim($codigo);
    $servico = trim($servico);
    $edificio = trim($edificio);
    $piso = trim($piso);
    $sala = trim($sala);
    $observacoes = trim($observacoes);

    // Validação do Código
    if (empty($codigo)) {
        $erros[] = "O campo Código é obrigatório.";
    } elseif (!preg_match('/^LOC\d+$/', $codigo)) {
        $erros[] = "O código deve começar com \"LOC\" seguido apenas de números (ex: LOC001).";
    } elseif (strlen($codigo) < 6) {
        $erros[] = "O código deve ter no mínimo 6 caracteres.";
    }

    // Validação do Edifício
    if (empty($edificio)) {
        $erros[] = "O campo Edifício é obrigatório.";
    } elseif (strlen($edificio) < 2) {
        $erros[] = "O campo Edifício deve ter no mínimo 2 caracteres.";
    }

    // Validação do Piso
    if (empty($piso)) {
        $erros[] = "O campo Piso é obrigatório.";
    } elseif (strlen($piso) < 2) {
        $erros[] = "O campo Piso deve ter no mínimo 2 caracteres.";
    } elseif (!preg_match('/^[A-Za-zÀ-ÿ0-9 ]+$/', $piso)) {
        $erros[] = "O campo Piso só pode conter letras, números e espaços.";
    }

    // Validação do Serviço/Departamento
    if (empty($servico)) {
        $erros[] = "O campo Serviço/Departamento é obrigatório.";
    } elseif (strlen($servico) < 2) {
        $erros[] = "O campo Serviço/Departamento deve ter no mínimo 2 caracteres.";
    }

    // Validação da Sala/Gabinete
    if (empty($sala)) {
        $erros[] = "O campo Sala/Gabinete é obrigatório.";
    } elseif (strlen($sala) < 2) {
        $erros[] = "O campo Sala/Gabinete deve ter no mínimo 2 caracteres.";
    }

    // Validação das Observações (campo opcional)
    if (!empty($observacoes) && strlen($observacoes) < 2) {
        $erros[] = "O campo Observações, se preenchido, deve ter no mínimo 2 caracteres.";
    }

    /*
    // 4. Depuração: mostrar os erros recolhidos
    echo "<pre>";
    print_r($erros);
    echo "</pre>";
    */

    // 5. Se não houver erros, guardar na base de dados
    $erro_sistema = "";

    if (empty($erros)) {
        try {
            $ligacao = new PDO(
                "mysql:host=" . MYSQL_HOST . ";port=" . MYSQL_PORT . ";dbname=" . MYSQL_DATABASE . ";charset=utf8",
                MYSQL_USERNAME,
                MYSQL_PASSWORD
            );
            $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO localizacoes (
                codigo, edificio, piso, servico, sala, observacoes
            ) VALUES (
                :codigo, :edificio, :piso, :servico, :sala, :observacoes
            )";

            $stmt = $ligacao->prepare($sql);
            $stmt->execute([
                ':codigo' => $codigo,
                ':edificio' => $edificio,
                ':piso' => $piso,
                ':servico' => $servico,
                ':sala' => $sala,
                ':observacoes' => $observacoes
            ]);

            header("Location: localizacoes.php");
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

    <!-- Conteúdo principal -->
    <main class="conteudo-privado">

        <section class="formulario-privado">

            <div class="cabecalho-formulario-privado">
                <h1>
                    <i class="fa-solid fa-plus"></i>
                    Inserir nova localização
                </h1>
            </div>

            <hr>

            <form id="form-nova-localizacao" class="form-equipamento-privado" action="#" method="post" novalidate>

                <!-- DADOS GERAIS -->
                <h5 class="subtitulo-separador titulo-azul-separador mt-0">
                    <i class="fa-solid fa-location-dot"></i>
                    Dados Gerais
                </h5>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="codigo" class="form-label">Código da localização</label>
                        <input type="text" class="form-control campo-formulario-privado" id="codigo" name="codigo"
    value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>">
                    </div>
                    <div class="col-md-8">
                        <label for="servico" class="form-label">Serviço / Departamento</label>
                        <input type="text" class="form-control campo-formulario-privado" id="servico"
                            name="servico" value="<?= htmlspecialchars($_POST['servico'] ?? '') ?>">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="edificio" class="form-label">Edifício</label>
                        <input type="text" class="form-control campo-formulario-privado" id="edificio"
                            name="edificio" value="<?= htmlspecialchars($_POST['edificio'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="piso" class="form-label">Piso</label>
                        <input type="text" class="form-control campo-formulario-privado" id="piso" name="piso"
                            value="<?= htmlspecialchars($_POST['piso'] ?? '') ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="sala" class="form-label">Sala / Gabinete</label>
                        <input type="text" class="form-control campo-formulario-privado" id="sala" name="sala"
                            value="<?= htmlspecialchars($_POST['sala'] ?? '') ?>">
                    </div>
                </div>

                <hr>

                <!-- OBSERVAÇÕES -->
                <h5 class="subtitulo-separador titulo-azul-separador">
                    <i class="fa-solid fa-comment-medical"></i>
                    Observações
                </h5>

                <div class="mb-3">
                    <textarea class="form-control campo-formulario-privado" id="observacoes" name="observacoes"
                        rows="4"><?= htmlspecialchars($_POST['observacoes'] ?? '') ?></textarea>
                </div>

                <?php if (!empty($erros)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Foram encontrados os seguintes erros:</strong>
                        <ul class="mb-0">
                            <?php foreach ($erros as $erro) : ?>
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
                    <a href="localizacoes.php" class="botao-cancelar-privado">
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