<?php
require_once __DIR__ . '/../../config/config.php';

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

function logout_and_redirect($redirect_to = '/private/iniciar_sessao.php')
{
    start_session();
    session_unset();
    session_destroy();
    header("Location: " . BASE_URL . $redirect_to);
    exit;
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
        $ficheiroDocumento = 'doc_equipamento_' . $codigoEquipamento . '_' . $tipoDocumentoId . '_' . time() . '.' . $extensao;

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