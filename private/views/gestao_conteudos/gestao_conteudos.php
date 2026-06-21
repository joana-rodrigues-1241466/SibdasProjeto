<?php
// ============================================================
// GESTAO_CONTEUDOS.PHP
// Área de administração (apenas Administrador) que permite
// editar os textos apresentados na área pública do site
// (página inicial, sobre, funcionalidades, contactos e rodapé)
// sem necessidade de alterar o HTML diretamente. Inclui também
// a opção de repor todos os conteúdos para os valores originais.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Restringir o acesso apenas a Administradores
if ($_SESSION['profile'] !== 'Administrador') {
    header('Location: ' . BASE_URL . '/private/home.php');
    exit;
}

// Valores de referência (originais) de cada campo de conteúdo, usados na função "Repor"
$valoresOriginais = [
    'home_titulo' => 'Sistema de Inventário de Equipamentos Hospitalares',
    'home_texto' => 'Plataforma web para gestão e monitorização do inventário de equipamentos médicos em ambiente hospitalar.',
    'home_botao' => 'Entre em contacto connosco',
    'sobre_titulo' => 'Sobre a MediVault',
    'sobre_texto_1' => 'A MediVault é uma plataforma web desenvolvida para apoiar instituições de saúde na gestão organizada e centralizada do inventário hospitalar de equipamentos médicos.',
    'sobre_texto_2' => 'O sistema permite reunir, num único local, informação essencial sobre os equipamentos, incluindo categoria, localização, estado atual, fornecedor, documentação técnica, garantias e contactos associados.',
    'sobre_texto_3' => 'O objetivo da plataforma é substituir métodos dispersos, como folhas de cálculo, documentos isolados e registos manuais, por uma solução digital mais segura, acessível e eficiente para os utilizadores autorizados.',
    'sobre_card_titulo' => 'O que a MediVault permite?',
    'sobre_card_texto_1' => 'Gerir equipamentos médicos e respetiva informação técnica;',
    'sobre_card_texto_2' => 'Associar equipamentos a localizações hospitalares específicas;',
    'sobre_card_texto_3' => 'Registar fornecedores, garantias e contratos associados;',
    'sobre_card_texto_4' => 'Consultar indicadores básicos através de um dashboard.',
    'funcionalidades_titulo' => 'Funcionalidades',
    'funcionalidades_texto' => 'A MediVault disponibiliza um conjunto de serviços e funcionalidades para gerir o inventário hospitalar com eficiência, segurança e total rastreabilidade.',
    'funcionalidade_titulo_1' => 'Gestão de Equipamentos',
    'funcionalidade_texto_1' => 'Registo, consulta, edição e remoção de equipamentos médicos existentes no inventário hospitalar, com total segurança e controlo.',
    'funcionalidade_titulo_2' => 'Localizações',
    'funcionalidade_texto_2' => 'Organização da localização física dos equipamentos por edifício, piso, serviço e sala.',
    'funcionalidade_titulo_3' => 'Fornecedores',
    'funcionalidade_texto_3' => 'Gestão de fornecedores associados aos equipamentos médicos e respetivos contactos.',
    'funcionalidade_titulo_4' => 'Documentação',
    'funcionalidade_texto_4' => 'Registo e controlo de documentação técnica, manuais, certificados e relatórios.',
    'funcionalidade_titulo_5' => 'Garantias e Contratos',
    'funcionalidade_texto_5' => 'Acompanhamento de garantias, contratos de manutenção e datas relevantes.',
    'funcionalidade_titulo_6' => 'Pesquisa e Filtragem',
    'funcionalidade_texto_6' => 'Encontre rapidamente os equipamentos, fornecedores e localizações pretendidos através de pesquisa e filtros avançados.',
    'funcionalidade_titulo_7' => 'Dashboard',
    'funcionalidade_texto_7' => 'Visualização resumida de indicadores relevantes para apoio à gestão.',
    'funcionalidade_titulo_8' => 'Alertas',
    'funcionalidade_texto_8' => 'Receba alertas sobre garantias a expirar e outras situações relevantes.',
    'contactos_titulo' => 'Contactos',
    'contactos_texto' => 'Entre em contacto connosco para esclarecer dúvidas sobre a MediVault ou obter mais informações sobre a gestão do inventário hospitalar.',
    'localizacao' => "Travessa Encosta do Pilar\n9000-777, Funchal\nMadeira",
    'horario' => "2.ª a 6.ª Feira: 09h00 - 19h00\nSábado: 09h00 - 14h00\nDomingo e Feriados: Encerrado",
    'email' => 'suporte@medivault.pt',
    'telefone' => '+351 291 466 310',
];

$mensagemSucesso = '';
$erroGestao = '';

// --------------------------------------------------------------------
// PROCESSAMENTO DO FORMULÁRIO E AÇÕES (guardar / repor conteúdos)
// --------------------------------------------------------------------
try {
    $ligacao = conectar_bd();

    // Submissão do formulário de edição dos conteúdos
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['campo'])) {
        $limitesTitulo = ['home_titulo', 'sobre_titulo', 'sobre_card_titulo', 'funcionalidades_titulo', 'contactos_titulo', 'home_botao',
            'funcionalidade_titulo_1', 'funcionalidade_titulo_2', 'funcionalidade_titulo_3', 'funcionalidade_titulo_4',
            'funcionalidade_titulo_5', 'funcionalidade_titulo_6', 'funcionalidade_titulo_7', 'funcionalidade_titulo_8'];

        $erros = [];

        // Validar cada campo submetido (limite de caracteres, formato de email e telefone)
        foreach ($_POST['campo'] as $nomeCampo => $valor) {
            if (!array_key_exists($nomeCampo, $valoresOriginais)) {
                continue;
            }

            $valor = trim($valor);
            $limite = in_array($nomeCampo, $limitesTitulo) ? 120 : 600;

            if (mb_strlen($valor) > $limite) {
                $erros[] = "O campo \"" . $nomeCampo . "\" excede o limite de " . $limite . " caracteres.";
            }

            if ($nomeCampo === 'email' && $valor !== '') {
                if (preg_match('/\s/', $valor)) {
                    $erros[] = "O email não pode conter espaços em branco.";
                } elseif (!filter_var($valor, FILTER_VALIDATE_EMAIL)) {
                    $erros[] = "O email deve ter um formato válido (ex.: contacto@medivault.pt).";
                }
            }

            if ($nomeCampo === 'telefone' && $valor !== '') {
                $telefoneSemEspacos = preg_replace('/\s+/', '', $valor);
                if (!preg_match('/^\+351[2-9]\d{8}$/', $telefoneSemEspacos)) {
                    $erros[] = "O telefone deve começar com \"+351\" seguido de 9 dígitos (linha fixa ou telemóvel).";
                }
            }
        }

        // Se não houver erros, atualizar todos os campos na base de dados
        if (empty($erros)) {
            $stmtUpdate = $ligacao->prepare("UPDATE conteudos_publicos SET conteudo_campo = :valor WHERE nome_campo = :campo");
            foreach ($_POST['campo'] as $nomeCampo => $valor) {
                if (array_key_exists($nomeCampo, $valoresOriginais)) {
                    $stmtUpdate->execute([':valor' => trim($valor), ':campo' => $nomeCampo]);
                }
            }
            header('Location: gestao_conteudos.php?sucesso=guardado');
            exit;
        } else {
            $erroGestao = implode(' ', $erros);
            $resultados = $_POST['campo'];
        }
    }

    // Ação "Repor Conteúdos Originais"
    if (isset($_GET['repor']) && $_GET['repor'] === '1') {
        $stmtReset = $ligacao->prepare("UPDATE conteudos_publicos SET conteudo_campo = :valor WHERE nome_campo = :campo");
        foreach ($valoresOriginais as $nomeCampo => $valor) {
            $stmtReset->execute([':valor' => $valor, ':campo' => $nomeCampo]);
        }
        header('Location: gestao_conteudos.php?sucesso=reposto');
        exit;
    }

    // Carregar os valores atuais (se não vieram já de uma submissão com erros)
    if (!isset($resultados)) {
        $resultados = $ligacao->query("SELECT nome_campo, conteudo_campo FROM conteudos_publicos")->fetchAll(PDO::FETCH_KEY_PAIR);
    }
} catch (PDOException $e) {
    registar_erro_log($e->getMessage());
    $erroGestao = "Erro ao ligar à base de dados: " . $e->getMessage();
    $resultados = [];
}

$ligacao = null;

// Função auxiliar: devolve o valor atual de um campo, já escapado para HTML
function valor_campo($resultados, $campo)
{
    return htmlspecialchars($resultados[$campo] ?? '');
}
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Formulário de gestão de conteúdos públicos -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <section class="gestao-conteudos">

            <h1 class="titulo-secao text-start">Gestão de Conteúdos</h1>
            <div class="linha-titulo"></div>

            <p class="texto-gestao">
                Nesta área reservada é possível atualizar conteúdos apresentados na área pública da MediVault,
                sem necessidade de editar diretamente o HTML.
            </p>

            <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] === 'guardado') : ?>
                <div class="alert alert-success text-center">
                    <i class="fa-solid fa-circle-check"></i> Conteúdos atualizados com sucesso.
                </div>
            <?php elseif (isset($_GET['sucesso']) && $_GET['sucesso'] === 'reposto') : ?>
                <div class="alert alert-success text-center">
                    <i class="fa-solid fa-circle-check"></i> Conteúdos repostos para os valores originais.
                </div>
            <?php endif; ?>

            <form class="form-gestao-conteudos" method="post" action="gestao_conteudos.php">

                <div class="accordion accordion-gestao" id="accordionGestao">

                    <!-- HOME -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingHome">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseHome" aria-expanded="true" aria-controls="collapseHome">
                                Secção Home
                            </button>
                        </h2>

                        <div id="collapseHome" class="accordion-collapse collapse show"
                            aria-labelledby="headingHome" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-home-titulo" class="form-label">Título principal</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-home-titulo" name="campo[home_titulo]" value="<?= valor_campo($resultados, 'home_titulo') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-home-texto" class="form-label">Texto introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-home-texto" name="campo[home_texto]" rows="3"><?= valor_campo($resultados, 'home_texto') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-home-botao" class="form-label">Texto do botão</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-home-botao" name="campo[home_botao]" value="<?= valor_campo($resultados, 'home_botao') ?>">
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- SOBRE -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSobre">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSobre" aria-expanded="false" aria-controls="collapseSobre">
                                Secção Sobre
                            </button>
                        </h2>

                        <div id="collapseSobre" class="accordion-collapse collapse" aria-labelledby="headingSobre"
                            data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-sobre-titulo" class="form-label">Título da secção</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-sobre-titulo" name="campo[sobre_titulo]" value="<?= valor_campo($resultados, 'sobre_titulo') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-1" class="form-label">Texto 1</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-1" name="campo[sobre_texto_1]" rows="3"><?= valor_campo($resultados, 'sobre_texto_1') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-2" class="form-label">Texto 2</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-2" name="campo[sobre_texto_2]" rows="3"><?= valor_campo($resultados, 'sobre_texto_2') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-sobre-texto-3" class="form-label">Texto 3</label>
                                    <textarea class="form-control campo-contacto" id="editar-sobre-texto-3" name="campo[sobre_texto_3]" rows="3"><?= valor_campo($resultados, 'sobre_texto_3') ?></textarea>
                                </div>

                                <hr>

                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Card informativo da secção Sobre</h6>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-titulo" class="form-label">Título do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-titulo" name="campo[sobre_card_titulo]" value="<?= valor_campo($resultados, 'sobre_card_titulo') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-1" class="form-label">Frase 1 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-1" name="campo[sobre_card_texto_1]" value="<?= valor_campo($resultados, 'sobre_card_texto_1') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-2" class="form-label">Frase 2 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-2" name="campo[sobre_card_texto_2]" value="<?= valor_campo($resultados, 'sobre_card_texto_2') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-3" class="form-label">Frase 3 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-3" name="campo[sobre_card_texto_3]" value="<?= valor_campo($resultados, 'sobre_card_texto_3') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-sobre-card-texto-4" class="form-label">Frase 4 do
                                            card</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-sobre-card-texto-4" name="campo[sobre_card_texto_4]" value="<?= valor_campo($resultados, 'sobre_card_texto_4') ?>">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- FUNCIONALIDADES -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFuncionalidades">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFuncionalidades" aria-expanded="false"
                                aria-controls="collapseFuncionalidades">
                                Secção Funcionalidades
                            </button>
                        </h2>

                        <div id="collapseFuncionalidades" class="accordion-collapse collapse"
                            aria-labelledby="headingFuncionalidades" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-funcionalidades-titulo" class="form-label">Título da
                                        secção</label>
                                    <input type="text" class="form-control campo-contacto"
                                        id="editar-funcionalidades-titulo" name="campo[funcionalidades_titulo]" value="<?= valor_campo($resultados, 'funcionalidades_titulo') ?>">
                                </div>

                                <div class="mb-4">
                                    <label for="editar-funcionalidades-texto" class="form-label">Texto
                                        introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-funcionalidades-texto" name="campo[funcionalidades_texto]"
                                        rows="3"><?= valor_campo($resultados, 'funcionalidades_texto') ?></textarea>
                                </div>

                                <hr>

                                <h5 class="subtitulo-gestao">Cards de funcionalidades</h5>

                                <!-- FUNCIONALIDADE 1 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 1</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-1"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-1" name="campo[funcionalidade_titulo_1]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_1') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-1" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-1" name="campo[funcionalidade_texto_1]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_1') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 2 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 2</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-2"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-2" name="campo[funcionalidade_titulo_2]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_2') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-2" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-2" name="campo[funcionalidade_texto_2]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_2') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 3 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 3</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-3"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-3" name="campo[funcionalidade_titulo_3]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_3') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-3" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-3" name="campo[funcionalidade_texto_3]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_3') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 4 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 4</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-4"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-4" name="campo[funcionalidade_titulo_4]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_4') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-4" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-4" name="campo[funcionalidade_texto_4]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_4') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 5 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 5</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-5"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-5" name="campo[funcionalidade_titulo_5]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_5') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-5" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-5" name="campo[funcionalidade_texto_5]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_5') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 6 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 6</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-6"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-6" name="campo[funcionalidade_titulo_6]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_6') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-6" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-6" name="campo[funcionalidade_texto_6]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_6') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 7 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 7</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-7"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-7" name="campo[funcionalidade_titulo_7]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_7') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-7" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-7" name="campo[funcionalidade_texto_7]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_7') ?></textarea>
                                    </div>
                                </div>

                                <!-- FUNCIONALIDADE 8 -->
                                <div class="bloco-funcionalidade-gestao">
                                    <h6>Funcionalidade 8</h6>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-titulo-8"
                                            class="form-label">Título</label>
                                        <input type="text" class="form-control campo-contacto"
                                            id="editar-funcionalidade-titulo-8" name="campo[funcionalidade_titulo_8]" value="<?= valor_campo($resultados, 'funcionalidade_titulo_8') ?>">
                                    </div>

                                    <div class="mb-3">
                                        <label for="editar-funcionalidade-texto-8" class="form-label">Texto</label>
                                        <textarea class="form-control campo-contacto"
                                            id="editar-funcionalidade-texto-8" name="campo[funcionalidade_texto_8]" rows="3"><?= valor_campo($resultados, 'funcionalidade_texto_8') ?></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- CONTACTOS -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingContactos">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseContactos" aria-expanded="false"
                                aria-controls="collapseContactos">
                                Secção Contactos
                            </button>
                        </h2>

                        <div id="collapseContactos" class="accordion-collapse collapse"
                            aria-labelledby="headingContactos" data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-contactos-titulo" class="form-label">Título da
                                        secção</label>
                                    <input type="text" class="form-control campo-contacto"
                                        id="editar-contactos-titulo" name="campo[contactos_titulo]" value="<?= valor_campo($resultados, 'contactos_titulo') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-contactos-texto" class="form-label">Texto
                                        introdutório</label>
                                    <textarea class="form-control campo-contacto" id="editar-contactos-texto" name="campo[contactos_texto]"
                                        rows="3"><?= valor_campo($resultados, 'contactos_texto') ?></textarea>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RODAPÉ -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingRodape">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseRodape" aria-expanded="false"
                                aria-controls="collapseRodape">
                                Rodapé
                            </button>
                        </h2>

                        <div id="collapseRodape" class="accordion-collapse collapse" aria-labelledby="headingRodape"
                            data-bs-parent="#accordionGestao">

                            <div class="accordion-body">

                                <div class="mb-3">
                                    <label for="editar-localizacao" class="form-label">Localização</label>
                                    <textarea class="form-control campo-contacto" id="editar-localizacao" name="campo[localizacao]" rows="3"><?= valor_campo($resultados, 'localizacao') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-horario" class="form-label">Horário</label>
                                    <textarea class="form-control campo-contacto" id="editar-horario" name="campo[horario]" rows="3"><?= valor_campo($resultados, 'horario') ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="editar-email" class="form-label">Email</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-email" name="campo[email]" value="<?= valor_campo($resultados, 'email') ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="editar-telefone" class="form-label">Telefone</label>
                                    <input type="text" class="form-control campo-contacto" id="editar-telefone" name="campo[telefone]" value="<?= valor_campo($resultados, 'telefone') ?>">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <?php if (!empty($erroGestao)) : ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erroGestao) ?></div>
                <?php endif; ?>

                <div class="botoes-gestao">
                    <button type="submit" class="btn botao-principal">
                        Guardar Alterações
                    </button>

                    <button type="button" class="btn botao-secundario-gestao" data-bs-toggle="modal" data-bs-target="#modalReporConteudos">
                        Repor Conteúdos Originais
                    </button>
                </div>

            </form>

            <a href="/medivault/public/index.php" class="voltar-inicio">
                <i class="fa-solid fa-arrow-left"></i>
                Voltar à página pública
            </a>

        </section>

    </main>

</div>

<!-- Modal repor conteúdos -->
<div class="modal fade" id="modalReporConteudos" tabindex="-1" aria-labelledby="tituloModalReporConteudos" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalReporConteudos">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Confirmar reposição
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem a certeza que pretende repor todos os conteúdos para os valores originais? Esta ação não pode ser desfeita.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn btn-danger" onclick="window.location.href='gestao_conteudos.php?repor=1'">
                    Repor
                </button>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>