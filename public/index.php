<?php
// ============================================================
// INDEX.PHP
// Página pública (institucional) da MediVault. Apresenta as
// secções Home, Sobre, Funcionalidades e Contactos, com
// conteúdos editáveis através da área de Gestão de Conteúdos
// (tabela conteudos_publicos). Processa também a submissão do
// formulário de contacto, guardando a mensagem na base de dados.
// ============================================================

require_once __DIR__ . '/../private/includes/funcoes.php';

$erroContacto = '';
$sucessoContacto = false;

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO DE CONTACTO (submissão POST)
// --------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
    $nomeContacto = trim($_POST['nome'] ?? '');
    $emailContacto = trim($_POST['email'] ?? '');
    $mensagemContacto = trim($_POST['mensagem'] ?? '');

    if ($nomeContacto === '' || strlen($nomeContacto) < 2) {
        $erroContacto = 'O nome deve ter no mínimo 2 caracteres.';
    } elseif (!filter_var($emailContacto, FILTER_VALIDATE_EMAIL)) {
        $erroContacto = 'Indique um email válido.';
    } elseif ($mensagemContacto === '' || strlen($mensagemContacto) < 5) {
        $erroContacto = 'A mensagem deve ter no mínimo 5 caracteres.';
    } else {
        try {
            $ligacaoContacto = conectar_bd();
            $stmtContacto = $ligacaoContacto->prepare("INSERT INTO mensagens_contacto (nome, email, mensagem, data_envio) VALUES (:nome, :email, :mensagem, :data_envio)");
            $stmtContacto->execute([
                ':nome' => $nomeContacto,
                ':email' => $emailContacto,
                ':mensagem' => $mensagemContacto,
                ':data_envio' => date('Y-m-d H:i:s')
            ]);

            $sucessoContacto = true;
            $nomeContacto = $emailContacto = $mensagemContacto = '';
        } catch (PDOException $e) {
            registar_erro_log($e->getMessage());
            $erroContacto = 'Erro ao enviar a mensagem. Tente novamente mais tarde.';
        }

        $ligacaoContacto = null;
    }
}

// --------------------------------------------------------------------
// CARREGAMENTO DOS CONTEÚDOS PÚBLICOS EDITÁVEIS
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();
    $conteudos = $ligacao->query("SELECT nome_campo, conteudo_campo FROM conteudos_publicos")->fetchAll(PDO::FETCH_KEY_PAIR);
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    $conteudos = [];
}

$ligacao = null;

// Função auxiliar: devolve o conteúdo de um campo (ou um valor por defeito), já escapado para HTML
function cp($conteudos, $campo, $defeito)
{
    return htmlspecialchars($conteudos[$campo] ?? $defeito);
}
?>

<!DOCTYPE html> <!-- informa que este é um documento HTML5  -->
<html lang="pt"> <!-- define o início do documento HTLM, indicando que o idioma principal da página é portugês -->

<head> <!-- informações sobre a página (título, metadados, links) -->
    <meta charset="UTF-8"> <!-- define a codificação de caracteres para UTF-8 (acentos e caracteres especiais) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- torna a página responsiva (ajuste a diferentes tamanhos de ecrã) -->
    <title><?php echo APP_NAME; ?></title>

    <!--favicon-->
    <link rel="shortcut icon" href="../assets/imagens/LOGO.png" type="image/png">
    <!-- icon oficial do site, imagem pequena antes de MediVault -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <!--estilos da página-->
    <link rel="stylesheet" href="../assets/css/1241466.css">

</head>

<body>

    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top border-bottom">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center gap-1" href="index.php">
            <img src="../assets/imagens/LOGO.png" alt="Logo da MediVault" class="logo-navbar">
            <span class="nome-navbar"><?php echo APP_NAME; ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPublico" aria-controls="menuPublico" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPublico">
            <!-- Links -->
            <div class="d-flex flex-column flex-lg-row align-items-lg-center ms-auto w-100">
                <ul class="navbar-nav ms-lg-auto me-lg-5 mb-3 mb-lg-0 gap-lg-4 align-items-lg-baseline">
                    <li class="nav-item">
                        <a class="nav-link link-navbar" href="#home" id="nav-home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link link-navbar" href="#sobre" id="nav-sobre">Sobre</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link link-navbar" href="#funcionalidades"
                            id="nav-funcionalidades">Funcionalidades</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link link-navbar" href="#contactos" id="nav-contactos">Contactos</a>
                    </li>
                </ul>

                </ul>
<a href="<?= BASE_URL ?>/private/iniciar_sessao.php" class="btn botao-login ms-lg-3">Iniciar Sessão</a>            </div>
        </div>

    </nav>

    <!-- Secção inicial -->
    <section class="container-texto-generico" id="home">
        <div class="container text-center">

            <h1 id="home-titulo" class="titulo-home"><?= cp($conteudos, 'home_titulo', 'Sistema de Inventário de Equipamentos Hospitalares') ?></h1>

            <p id="home-texto" class="lead texto-home">
                <?= cp($conteudos, 'home_texto', 'Plataforma web para gestão e monitorização do inventário de equipamentos médicos em ambiente hospitalar.') ?>
            </p>

            <img src="../assets/imagens/CAPA.png" class="img-fluid rounded imagem-home"
                alt="Sistema de inventário de equipamentos hospitalares">

            <div class="mt-4">
                <a id="home-botao" href="#contactos" class="btn botao-principal"><?= cp($conteudos, 'home_botao', 'Entre em contacto connosco') ?></a>
            </div>

        </div>
    </section>

    <!-- Secção "Sobre" -->
    <section class="container-texto-generico" id="sobre">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6 text-start">
                    <h1 id="sobre-titulo" class="titulo-secao"><?= cp($conteudos, 'sobre_titulo', 'Sobre a MediVault') ?></h1>
                    <div class="linha-titulo"></div>

                    <p id="sobre-texto-1">
                        <?= cp($conteudos, 'sobre_texto_1', 'A MediVault é uma plataforma web desenvolvida para apoiar instituições de saúde na gestão organizada e centralizada do inventário hospitalar de equipamentos médicos.') ?>
                    </p>

                    <p id="sobre-texto-2">
                        <?= cp($conteudos, 'sobre_texto_2', 'O sistema permite reunir, num único local, informação essencial sobre os equipamentos, incluindo categoria, localização, estado atual, fornecedor, documentação técnica, garantias e contratos associados.') ?>
                    </p>

                    <p id="sobre-texto-3">
                        <?= cp($conteudos, 'sobre_texto_3', 'O objetivo da plataforma é substituir métodos dispersos, como folhas de cálculo, documentos isolados e registos manuais, por uma solução digital mais segura, acessível e eficiente para os utilizadores autorizados.') ?>
                    </p>
                </div>

                <div class="col-lg-6">
                    <div class="sobre-card">
                        <div class="d-flex align-items-center gap-3 mb-5">
                            <i class="fa-solid fa-clipboard-list icone-principal"></i>
                            <div>
                                <h2 id="sobre-card-titulo" class="titulo-card mb-0"><?= cp($conteudos, 'sobre_card_titulo', 'O que a MediVault permite?') ?></h2>
                                <div class="linha-card"></div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <i class="fa-solid fa-boxes-stacked icone-funcao"></i>
                            <p id="sobre-card-texto-1" class="mb-0"><?= cp($conteudos, 'sobre_card_texto_1', 'Gerir equipamentos médicos e respetiva informação técnica;') ?></p>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <i class="fa-solid fa-location-dot icone-funcao"></i>
                            <p id="sobre-card-texto-2" class="mb-0"><?= cp($conteudos, 'sobre_card_texto_2', 'Associar equipamentos a localizações hospitalares específicas;') ?></p>
                        </div>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <i class="fa-solid fa-truck-medical icone-funcao"></i>
                            <p id="sobre-card-texto-3" class="mb-0"><?= cp($conteudos, 'sobre_card_texto_3', 'Registar fornecedores, garantias e contratos associados;') ?></p>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <i class="fa-solid fa-chart-line icone-funcao"></i>
                            <p id="sobre-card-texto-4" class="mb-0"><?= cp($conteudos, 'sobre_card_texto_4', 'Consultar indicadores básicos através de um dashboard.') ?></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Secção Funcionalidades -->
    <section class="container-texto-generico" id="funcionalidades">
        <div class="container">

            <h1 id="funcionalidades-titulo" class="titulo-secao text-start"><?= cp($conteudos, 'funcionalidades_titulo', 'Funcionalidades') ?></h1>
            <div class="linha-titulo"></div>

            <p id="funcionalidades-texto" class="texto-funcionalidades text-start">
                <?= cp($conteudos, 'funcionalidades_texto', 'A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.') ?>
            </p>

            <div class="row g-4 mt-3">

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-desktop icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-1"><?= cp($conteudos, 'funcionalidade_titulo_1', 'Gestão de Equipamentos') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-1">
                            <?= cp($conteudos, 'funcionalidade_texto_1', 'Registo, consulta, edição e remoção de equipamentos médicos existentes no inventário hospitalar, com total segurança e controlo.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-location-dot icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-2"><?= cp($conteudos, 'funcionalidade_titulo_2', 'Localizações') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-2">
                            <?= cp($conteudos, 'funcionalidade_texto_2', 'Organização da localização física dos equipamentos por edifício, piso, serviço e sala.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-handshake icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-3"><?= cp($conteudos, 'funcionalidade_titulo_3', 'Fornecedores') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-3">
                            <?= cp($conteudos, 'funcionalidade_texto_3', 'Gestão de fornecedores associados aos equipamentos médicos e respetivos contactos.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-file-lines icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-4"><?= cp($conteudos, 'funcionalidade_titulo_4', 'Documentação') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-4">
                            <?= cp($conteudos, 'funcionalidade_texto_4', 'Registo e controlo de documentação técnica, manuais, certificados e relatórios.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-shield-halved icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-5"><?= cp($conteudos, 'funcionalidade_titulo_5', 'Garantias e Contratos') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-5">
                            <?= cp($conteudos, 'funcionalidade_texto_5', 'Acompanhamento de garantias, contratos de manutenção e datas relevantes.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-magnifying-glass icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-6"><?= cp($conteudos, 'funcionalidade_titulo_6', 'Pesquisa e Filtragem') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-6">
                            <?= cp($conteudos, 'funcionalidade_texto_6', 'Encontre rapidamente os equipamentos, fornecedores e localizações pretendidos através de pesquisa e filtros avançados.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-chart-simple icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-7"><?= cp($conteudos, 'funcionalidade_titulo_7', 'Dashboard') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-7">
                            <?= cp($conteudos, 'funcionalidade_texto_7', 'Visualização resumida de indicadores relevantes para apoio à gestão.') ?>
                        </p>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-4 d-flex">
                    <div class="card-funcionalidade">
                        <i class="fa-solid fa-bell icone-funcionalidade"></i>
                        <h3 id="funcionalidade-titulo-8"><?= cp($conteudos, 'funcionalidade_titulo_8', 'Alertas') ?></h3>
                        <div class="linha-card-funcionalidade"></div>
                        <p id="funcionalidade-texto-8">
                            <?= cp($conteudos, 'funcionalidade_texto_8', 'Receba alertas sobre garantias a expirar e outras situações relevantes.') ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Secção Contactos -->
    <section class="container-texto-generico" id="contactos">
        <div class="container">

            <h1 id="contactos-titulo" class="titulo-secao text-start"><?= cp($conteudos, 'contactos_titulo', 'Contactos') ?></h1>
            <div class="linha-titulo"></div>

            <p id="contactos-texto" class="texto-contactos text-start">
                <?= cp($conteudos, 'contactos_texto', 'Entre em contacto connosco para esclarecer dúvidas sobre a MediVault ou obter mais informações sobre a gestão do inventário hospitalar.') ?>
            </p>

            <?php if ($sucessoContacto) : ?>
                <div class="alert alert-success text-center">
                    <i class="fa-solid fa-circle-check"></i> Mensagem enviada com sucesso. Entraremos em contacto brevemente.
                </div>
            <?php endif; ?>

            <form class="form-contactos" method="post" action="index.php#contactos">

                <div class="mb-4">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control campo-contacto" id="nome" name="nome"
                        placeholder="Insira o seu nome" value="<?= htmlspecialchars($nomeContacto ?? '') ?>">
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="text" class="form-control campo-contacto" id="email" name="email"
                        placeholder="exemplo@gmail.com" value="<?= htmlspecialchars($emailContacto ?? '') ?>">
                </div>

                <div class="mb-4">
                    <label for="mensagem" class="form-label">Mensagem:</label>
                    <textarea class="form-control campo-contacto" id="mensagem" name="mensagem" rows="5"
                        placeholder="Escreva aqui a sua mensagem"><?= htmlspecialchars($mensagemContacto ?? '') ?></textarea>
                </div>

                <?php if (!empty($erroContacto)) : ?>
                    <div class="erros-separador alert alert-danger" style="display:block;">
                        <ul style="margin-bottom:0;">
                            <li><?= htmlspecialchars($erroContacto) ?></li>
                        </ul>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn botao-principal botao-contactos">
                    Enviar Mensagem
                </button>

                <p class="nota-contactos">
                    Responderemos ao seu contacto com a maior brevidade possível.
                </p>

            </form>

        </div>
    </section>

    <!-- Rodapé -->
    <footer class="footer-container py-4">
        <div class="container">
            <div class="row text-center gx-5 flex-nowrap">

                <div class="col-4">
                    <strong>LOCALIZAÇÃO</strong>
                    <p id="rodape-localizacao" class="mb-0">
                        <?= nl2br(cp($conteudos, 'localizacao', "Travessa Encosta do Pilar\n9000-777, Funchal\nMadeira")) ?>
                    </p>
                </div>

                <div class="col-4">
                    <strong>HORÁRIO</strong>
                    <p id="rodape-horario" class="mb-1">
                        <?= nl2br(cp($conteudos, 'horario', "2.ª a 6.ª Feira: 09h00 - 19h00\nSábado: 09h00 - 14h00\nDomingo e Feriados: Encerrado")) ?>
                    </p>
                </div>

                <div class="col-4">
                    <strong>CONTACTOS</strong>
                    <p class="mb-1">
                        Email: <span id="rodape-email"><?= cp($conteudos, 'email', 'suporte@medivault.pt') ?></span>
                    </p>

                    <p class="mb-0">
                        Telefone: <span id="rodape-telefone"><?= cp($conteudos, 'telefone', '+351 930 466 310') ?></span>
                    </p>
                </div>

            </div>
        </div>
    </footer>

    <!-- JavaScript do Bootstrap -->
    <script src="../assets/bootstrap/bootstrap.bundle.min.js"></script>

    <!-- JavaScript próprio -->
    <script src="../assets/js/1241466.js">
    </script>

</body>

</html>