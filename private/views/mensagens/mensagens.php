<?php
// ============================================================
// MENSAGENS.PHP
// Área de administração das mensagens de contacto recebidas
// através do formulário público. Apenas acessível a
// Administradores. Permite consultar, marcar como lida e
// responder (via mailto) a cada mensagem.
// ============================================================

require_once __DIR__ . '/../../includes/funcoes.php';
redirect_if_not_logged();

// Restringir o acesso apenas a Administradores
if ($_SESSION['profile'] !== 'Administrador') {
    header('Location: ' . BASE_URL . '/private/home.php');
    exit;
}

// Obter a listagem de mensagens (não lidas primeiro) e o total de não lidas
try {
    $ligacao = conectar_bd();

    $resultados = $ligacao->query("
        SELECT m.id, m.nome, m.email, m.mensagem, m.data_envio, m.lido, m.lido_em, u.nome AS lido_por_nome
        FROM mensagens_contacto m
        LEFT JOIN utilizadores u ON u.id = m.lido_por
        ORDER BY m.lido ASC, m.data_envio DESC
    ")->fetchAll(PDO::FETCH_ASSOC);

    $totalNaoLidas = $ligacao->query("SELECT COUNT(*) FROM mensagens_contacto WHERE lido = 0")->fetchColumn();

    $erro = '';
} catch (PDOException $e) {
    $erro = "Erro ao ligar à base de dados: " . $e->getMessage();
    $resultados = [];
    $totalNaoLidas = 0;
}

$ligacao = null;
?>

<?php include '../../includes/header.php'; ?>
<?php include '../../includes/navbar.php'; ?>

<div class="layout-privado">

    <?php include '../../includes/menu.php'; ?>

    <!-- ============================================================ -->
    <!-- Listagem de mensagens de contacto -->
    <!-- ============================================================ -->
    <main class="conteudo-privado">

        <?php if (!empty($_SESSION['mensagem_sucesso'])) : ?>
        <div id="alerta-sucesso" class="alert alert-success text-center" role="alert">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars($_SESSION['mensagem_sucesso']) ?>
        </div>
        <script>
            setTimeout(function () {
                const alerta = document.getElementById('alerta-sucesso');
                if (alerta) {
                    alerta.style.transition = 'opacity 0.5s ease';
                    alerta.style.opacity = '0';
                    setTimeout(function () { alerta.remove(); }, 500);
                }
            }, 3000);
        </script>
        <?php unset($_SESSION['mensagem_sucesso']); ?>
        <?php endif; ?>

        <div class="titulo-pagina-equipamentos">
            <div class="bloco-titulo-equipamentos">
                <h1>Mensagens de Contacto</h1>
                <span class="linha-titulo-equipamentos"></span>
            </div>
        </div>

        <p class="mensagem-listagem">
            Consulte as mensagens enviadas através do formulário de contacto da área pública.
            <?php if ($totalNaoLidas > 0) : ?>
                <strong style="color:#dc3545;"><?= $totalNaoLidas ?> não lida<?= $totalNaoLidas != 1 ? 's' : '' ?>.</strong>
            <?php endif; ?>
        </p>

        <?php if (!empty($erro)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <div class="tabela-privada">
            <table id="tabela-mensagens">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Mensagem</th>
                        <th>Data de Envio</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($resultados)) : ?>
                        <tr>
                            <td colspan="6" class="text-muted">Não existem mensagens de contacto registadas.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($resultados as $msg) : ?>
                            <tr>
                                <td><?= htmlspecialchars($msg['nome']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= htmlspecialchars(mb_strimwidth($msg['mensagem'], 0, 60, '...')) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($msg['data_envio'])) ?></td>
                                <td>
                                    <?php if ($msg['lido']) : ?>
                                        <span class="badge-detalhe badge-sim">Lida</span>
                                    <?php else : ?>
                                        <span class="badge-detalhe badge-nao">Não lida</span>
                                    <?php endif; ?>
                                </td>
                                <td class="acoes-tabela-privada">
                                    <button type="button" class="acao-tabela-privada" style="color: #005fae; background:none; border:none;" title="Ver mensagem completa"
                                        onclick='abrirModalMensagem(<?= json_encode($msg, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>)'>
                                        <i class="fa-regular fa-eye"></i>
                                    </button>
                                    <?php if (!$msg['lido']) : ?>
                                        <a href="marcar_lida.php?id_mensagem=<?= aes_encrypt($msg['id']) ?>" class="acao-tabela-privada" title="Marcar como lida" style="color: #16a34a;">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                    <?php else : ?>
                                        <button type="button" class="acao-tabela-privada" style="color: #0086a8; background:none; border:none;" title="Responder"
                                            onclick='abrirModalResponder(<?= json_encode($msg, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP) ?>)'>
                                            <i class="fa-solid fa-reply"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </main>

</div>

<!-- Modal ver mensagem -->
<div class="modal fade" id="modalVerMensagem" tabindex="-1" aria-labelledby="tituloModalVerMensagem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalVerMensagem">
                    <i class="fa-regular fa-envelope-open"></i>
                    Mensagem de Contacto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="corpoModalVerMensagem"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Fechar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal responder mensagem -->
<div class="modal fade" id="modalResponderMensagem" tabindex="-1" aria-labelledby="tituloModalResponderMensagem" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tituloModalResponderMensagem">
                    <i class="fa-solid fa-reply"></i>
                    Responder a <span id="responder-destinatario-nome"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Para</label>
                    <input type="text" class="form-control" id="responder-email" readonly>
                </div>
                <div class="mb-3">
                    <label for="responder-assunto" class="form-label">Assunto</label>
                    <input type="text" class="form-control" id="responder-assunto">
                </div>
                <div class="mb-3">
                    <label for="responder-mensagem" class="form-label">Mensagem</label>
                    <textarea class="form-control" id="responder-mensagem" rows="6" placeholder="Escreva aqui a sua resposta..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <button type="button" class="btn botao-principal" onclick="enviarResposta()">
                    <i class="fa-solid fa-paper-plane"></i>
                    Abrir no Email do Cliente
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- Script JavaScript da página -->
<!-- ============================================================ -->
<script>
    // Inicialização da tabela de mensagens com DataTables (paginação, pesquisa, etc.)
    $(document).ready(function() {
        $('#tabela-mensagens').DataTable({
            pageLength: 10,
            pagingType: "full_numbers",
            dom: 'rtip',
            scrollX: true,
            language: {
                emptyTable: "Sem mensagens disponíveis.",
                info: "Mostrando _START_ até _END_ de _TOTAL_ registos",
                infoEmpty: "Mostrando 0 até 0 de 0 registos",
                lengthMenu: "Mostrando _MENU_ registos por página.",
                search: "Filtrar:",
                zeroRecords: "Nenhum registo encontrado.",
                paginate: {
                    first: "Primeira",
                    last: "Última",
                    next: "Seguinte",
                    previous: "Anterior"
                }
            }
        });
    });

    // Abre o modal de resposta, pré-preenchendo o destinatário e assunto
    function abrirModalResponder(msg) {
        document.getElementById("responder-destinatario-nome").textContent = msg.nome;
        document.getElementById("responder-email").value = msg.email;
        document.getElementById("responder-assunto").value = "Resposta à sua mensagem - MediVault";
        document.getElementById("responder-mensagem").value = "";

        const modal = new bootstrap.Modal(document.getElementById("modalResponderMensagem"));
        modal.show();
    }

    // Abre o cliente de email do utilizador (mailto) com os dados da resposta
    function enviarResposta() {
        const email = document.getElementById("responder-email").value;
        const assunto = document.getElementById("responder-assunto").value;
        const mensagem = document.getElementById("responder-mensagem").value;

        const link = "mailto:" + encodeURIComponent(email) +
            "?subject=" + encodeURIComponent(assunto) +
            "&body=" + encodeURIComponent(mensagem);

        window.location.href = link;
    }

    // Abre o modal com o conteúdo completo de uma mensagem
    function abrirModalMensagem(msg) {
        const corpo = document.getElementById("corpoModalVerMensagem");

        corpo.innerHTML = `
            <div class="grelha-detalhes-equipamento" style="grid-template-columns: 1fr;">
                <div class="campo-detalhes">
                    <h3>Nome</h3>
                    <p>${msg.nome}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Email</h3>
                    <p>${msg.email}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Data de envio</h3>
                    <p>${new Date(msg.data_envio).toLocaleString('pt-PT')}</p>
                </div>
                <div class="campo-detalhes">
                    <h3>Mensagem</h3>
                    <p style="white-space: pre-wrap;">${msg.mensagem}</p>
                </div>
            </div>
        `;

        const modal = new bootstrap.Modal(document.getElementById("modalVerMensagem"));
        modal.show();
    }
</script>

<?php include '../../includes/footer.php'; ?>