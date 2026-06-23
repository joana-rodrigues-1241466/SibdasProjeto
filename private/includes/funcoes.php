<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set('Europe/Lisbon');

require_once __DIR__ . '/../../config/config.php';

// ============================================================
// Ligação à base de dados
// ============================================================
function conectar_bd() {
    $ligacao = new PDO(
        'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8',
        DB_USER,
        DB_PASS
    );
    $ligacao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $offsetSegundos = (new DateTime('now', new DateTimeZone('Europe/Lisbon')))->getOffset();
    $horas = intdiv(abs($offsetSegundos), 3600);
    $minutos = (abs($offsetSegundos) % 3600) / 60;
    $sinal = $offsetSegundos >= 0 ? '+' : '-';
    $offset = sprintf('%s%02d:%02d', $sinal, $horas, $minutos);
    $ligacao->exec("SET time_zone = '$offset'");

    return $ligacao;
}

function start_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function check_session()
{
    return isset($_SESSION['utilizador']);
}

function redirect_if_not_logged($redirect_to = '/private/iniciar_sessao.php')
{
    start_session();
    if (!check_session()) {
        header("Location: " . BASE_URL . $redirect_to);
        exit;
    }
}

// ============================================================
// Restringe o acesso a páginas de criação/edição/eliminação
// para o perfil "Profissional de Saúde", que só pode consultar.
// ============================================================
function bloquear_profissional_saude($redirect_to = '/private/home.php')
{
    if (isset($_SESSION['profile']) && $_SESSION['profile'] === 'Profissional de Saúde') {
        $_SESSION['mensagem_erro'] = 'Não tem permissões para aceder a esta página.';
        header("Location: " . BASE_URL . $redirect_to);
        exit;
    }
}

function logout_and_redirect($redirect_to = '/private/iniciar_sessao.php')
{
    start_session();
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . $redirect_to);
    exit;
}

// ============================================================
// Regista erros relevantes do sistema num ficheiro de log,
// para permitir auditoria e diagnóstico sem expor detalhes
// técnicos ao utilizador final.
// ============================================================
function registar_erro_log($mensagem)
{
    $pastaLogs = __DIR__ . '/../logs';

    if (!is_dir($pastaLogs)) {
        mkdir($pastaLogs, 0755, true);
    }

    $ficheiroLog = $pastaLogs . '/erros.log';
    $dataHora = date('Y-m-d H:i:s');
    $utilizador = $_SESSION['utilizador'] ?? 'Visitante (sem sessão)';
    $pagina = $_SERVER['REQUEST_URI'] ?? 'Desconhecida';

    $linha = "[$dataHora] Utilizador: $utilizador | Página: $pagina | Erro: $mensagem" . PHP_EOL;

    file_put_contents($ficheiroLog, $linha, FILE_APPEND | LOCK_EX);
}

// ============================================================
// Regista tentativas de autenticação (com sucesso ou falha),
// permitindo auditar acessos e detetar tentativas suspeitas.
// ============================================================
function registar_log_autenticacao($email, $sucesso, $motivo = '')
{
    $pastaLogs = __DIR__ . '/../logs';

    if (!is_dir($pastaLogs)) {
        mkdir($pastaLogs, 0755, true);
    }

    $ficheiroLog = $pastaLogs . '/autenticacao.log';
    $dataHora = date('Y-m-d H:i:s');
    $resultado = $sucesso ? 'SUCESSO' : 'FALHA';
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP desconhecido';

    $linha = "[$dataHora] $resultado | Email: $email | IP: $ip";
    if ($motivo !== '') {
        $linha .= " | Motivo: $motivo";
    }
    $linha .= PHP_EOL;

    file_put_contents($ficheiroLog, $linha, FILE_APPEND | LOCK_EX);
}

// ============================================================
// Encriptação e desencriptação de valores com OpenSSL
// ============================================================
function aes_encrypt($value) {
    return bin2hex(openssl_encrypt(
        $value,
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    ));
}

function aes_decrypt($value) {
    if (!is_string($value) || strlen($value) % 2 !== 0) return false; // proteção básica
    return openssl_decrypt(
        hex2bin($value),
        OPENSSL_METHOD,
        OPENSSL_KEY,
        OPENSSL_RAW_DATA,
        OPENSSL_IV
    );
}

function guardarDocumentoEquipamento(PDO $ligacao, int $idEquipamento, string $codigoEquipamento, int $tipoDocumentoId, string $campoTem, string $campoNome, string $campoData, string $campoValidade, string $campoFicheiro): void
{
    $temDoc = $_POST[$campoTem] ?? 'nao';

    $stmt = $ligacao->prepare("SELECT id, ficheiro_documento FROM documentacao_equipamentos WHERE equipamento_id = :id AND tipo_documento_id = :tipo");
    $stmt->bindParam(':id', $idEquipamento, PDO::PARAM_INT);
    $stmt->bindParam(':tipo', $tipoDocumentoId, PDO::PARAM_INT);
    $stmt->execute();
    $registo = $stmt->fetch(PDO::FETCH_OBJ);

    if ($temDoc !== 'sim') {
        if ($registo) {
            $stmt = $ligacao->prepare("DELETE FROM documentacao_equipamentos WHERE id = :id");
            $stmt->bindParam(':id', $registo->id, PDO::PARAM_INT);
            $stmt->execute();
        }
        return;
    }

    $nome = trim($_POST[$campoNome] ?? '');
    $data = $_POST[$campoData] ?? null;
    $validade = !empty($_POST[$campoValidade]) ? $_POST[$campoValidade] : null;

    $ficheiroDocumento = $registo->ficheiro_documento ?? null;
    $nomeOriginalFicheiro = null;

    if (!empty($_FILES[$campoFicheiro]['name']) && $_FILES[$campoFicheiro]['error'] === UPLOAD_ERR_OK) {
        $nomeOriginalFicheiro = $_FILES[$campoFicheiro]['name'];
        $extensao = pathinfo($nomeOriginalFicheiro, PATHINFO_EXTENSION);
        $semExtensao = pathinfo($nomeOriginalFicheiro, PATHINFO_FILENAME);
$ficheiroDocumento = (str_contains($semExtensao, $codigoEquipamento))
    ? $nomeOriginalFicheiro
    : $semExtensao . '_' . $codigoEquipamento . '.' . $extensao;

        move_uploaded_file($_FILES[$campoFicheiro]['tmp_name'], UPLOAD_DIR_EQUIPAMENTOS . '/' . $ficheiroDocumento);
    }

    if ($registo) {
        $sql = "UPDATE documentacao_equipamentos
                SET nome_documento = :nome, data_documento = :data, validade_documento = :validade"
             . ($nomeOriginalFicheiro ? ", nome_original_ficheiro = :nome_original, ficheiro_documento = :ficheiro" : "")
             . " WHERE id = :id";

        $stmt = $ligacao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':validade', $validade);
        if ($nomeOriginalFicheiro) {
            $stmt->bindParam(':nome_original', $nomeOriginalFicheiro);
            $stmt->bindParam(':ficheiro', $ficheiroDocumento);
        }
        $stmt->bindParam(':id', $registo->id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $stmt = $ligacao->prepare("
            INSERT INTO documentacao_equipamentos (equipamento_id, tipo_documento_id, nome_documento, data_documento, validade_documento, nome_original_ficheiro, ficheiro_documento)
            VALUES (:equipamento_id, :tipo, :nome, :data, :validade, :nome_original, :ficheiro)
        ");
        $stmt->bindParam(':equipamento_id', $idEquipamento, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $tipoDocumentoId, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':validade', $validade);
        $stmt->bindParam(':nome_original', $nomeOriginalFicheiro);
        $stmt->bindParam(':ficheiro', $ficheiroDocumento);
        $stmt->execute();
    }
}

function registar_historico($ligacao, $equipamento_id, $tipo_alteracao_designacao, $descricao, $dados_anteriores = null, $dados_novos = null)
{
    $stmtTipo = $ligacao->prepare("SELECT id FROM tipos_alteracao WHERE designacao = :designacao");
    $stmtTipo->execute([':designacao' => $tipo_alteracao_designacao]);
    $tipo_alteracao_id = $stmtTipo->fetchColumn();

    $stmt = $ligacao->prepare("
        INSERT INTO historico_equipamentos (equipamento_id, utilizador_id, tipo_alteracao_id, descricao, dados_anteriores, dados_novos, data_alteracao)
        VALUES (:equipamento_id, :utilizador_id, :tipo_alteracao_id, :descricao, :dados_anteriores, :dados_novos, :data_alteracao)
    ");

    $stmt->execute([
        ':equipamento_id' => $equipamento_id,
        ':utilizador_id' => $_SESSION['utilizador_id'] ?? null,
        ':tipo_alteracao_id' => $tipo_alteracao_id,
        ':descricao' => $descricao,
        ':dados_anteriores' => $dados_anteriores !== null ? json_encode($dados_anteriores, JSON_UNESCAPED_UNICODE) : null,
        ':dados_novos' => $dados_novos !== null ? json_encode($dados_novos, JSON_UNESCAPED_UNICODE) : null,
        ':data_alteracao' => date('Y-m-d H:i:s'),
    ]);
}

function calcular_diferencas_historico($dadosAnterioresJson, $dadosNovosJson, $rotulosCampos)
{
    if ($dadosAnterioresJson === null || $dadosNovosJson === null) {
        return [];
    }

    $antes = json_decode($dadosAnterioresJson, true) ?? [];
    $depois = json_decode($dadosNovosJson, true) ?? [];
    $diferencas = [];

    foreach ($rotulosCampos as $campo => $rotulo) {
        $valorAntes = $antes[$campo] ?? '';
        $valorDepois = $depois[$campo] ?? '';

        if ((string) $valorAntes !== (string) $valorDepois) {
            $diferencas[] = [
                'rotulo' => $rotulo,
                'antes' => $valorAntes !== '' ? $valorAntes : '—',
                'depois' => $valorDepois !== '' ? $valorDepois : '—',
            ];
        }
    }

    return $diferencas;
}

function renderizar_entrada_historico($mov, $classesTipoAlteracao, $rotulosCamposHistorico)
{
    $estiloTipo = $classesTipoAlteracao[$mov['tipo_alteracao']] ?? '';
    $linkEquipamento = BASE_URL . '/private/views/equipamentos/consultar_equipamento.php?id_equipamento=' . aes_encrypt($mov['equipamento_id']);

    $html = '<div style="border-bottom: 1px solid #e5e7eb; padding: 0.8rem 0;">';
    $html .= '<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 0.3rem;">';
    $html .= '<span style="' . $estiloTipo . ' padding: 2px 10px; border-radius: 999px; font-size: 0.75rem; font-weight: 600;">' . htmlspecialchars($mov['tipo_alteracao']) . '</span>';
    $html .= '<span style="font-size: 0.75rem; color: #6b7280;">' . date('d/m/Y H:i', strtotime($mov['data_alteracao'])) . '</span>';
    $html .= '</div>';
    $html .= '<p style="margin: 0; font-size: 0.9rem;"><a href="' . $linkEquipamento . '" style="color:#0b2f4f; text-decoration:none;"><strong>' . htmlspecialchars($mov['equipamento_codigo']) . '</strong> — ' . htmlspecialchars($mov['equipamento_designacao']) . '</a></p>';
    $html .= '<p style="margin: 0.2rem 0 0; font-size: 0.85rem; color: #374151;">' . htmlspecialchars($mov['descricao']) . '</p>';

    if ($mov['tipo_alteracao'] === 'Edição') {
        $diferencas = calcular_diferencas_historico($mov['dados_anteriores'], $mov['dados_novos'], $rotulosCamposHistorico);
        if (!empty($diferencas)) {
            $html .= '<ul style="margin: 0.4rem 0 0; padding-left: 1.1rem; font-size: 0.82rem; color: #4b5563;">';
            foreach ($diferencas as $dif) {
                $html .= '<li><strong>' . htmlspecialchars($dif['rotulo']) . ':</strong> ' . htmlspecialchars($dif['antes']) . ' → ' . htmlspecialchars($dif['depois']) . '</li>';
            }
            $html .= '</ul>';
        }
    }

    $html .= '<p style="margin: 0.2rem 0 0; font-size: 0.78rem; color: #9ca3af;">por ' . htmlspecialchars($mov['utilizador_nome'] ?? 'Utilizador removido') . '</p>';
    $html .= '</div>';

    return $html;
}