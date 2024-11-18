<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php'; // Certifique-se de que o PHPMailer está instalado
require '../../config/conexao.php'; // Conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recupera os dados do formulário
        $produtoId = $_POST['produto_id'];
        $motivo = trim($_POST['motivo']);

        if (empty($produtoId) || empty($motivo)) {
            throw new Exception('Produto ID ou motivo não fornecido.');
        }

        // Atualiza o status do produto para "Reprovado" (status = 4)
        $sql = "UPDATE Produtos SET status = 4, motivo_recusa = :motivo WHERE produto_id = :produto_id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $stmt->bindParam(':motivo', $motivo, PDO::PARAM_STR);
        $stmt->execute();

        // Busca os dados do prestador para enviar o e-mail
        $prestadorSql = "SELECT pr.email, pr.nome_resp_legal, p.nome_produto 
                         FROM Produtos p 
                         JOIN Prestadores pr ON p.prestador = pr.prestador_id 
                         WHERE p.produto_id = :produto_id";
        $prestadorStmt = $conexao->prepare($prestadorSql);
        $prestadorStmt->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
        $prestadorStmt->execute();
        $prestador = $prestadorStmt->fetch(PDO::FETCH_ASSOC);

        if (!$prestador) {
            throw new Exception('Prestador não encontrado.');
        }

        $emailPrestador = $prestador['email'];
        $nomePrestador = $prestador['nome_resp_legal'];
        $nomeProduto = $prestador['nome_produto'];

        // Envia o e-mail de reprovação utilizando PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'axeysenai@gmail.com'; // Substitua pelo seu e-mail
            $mail->Password   = 'xwsg zjwx mmzy gqvi'; // Substitua pela sua senha ou app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Configuração do remetente e destinatário
            $mail->setFrom('axeysenai@gmail.com', 'Equipe Axey');
            $mail->addAddress($emailPrestador, $nomePrestador);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = "Anúncio Reprovado: $nomeProduto";
            $mail->Body = "
                <div style='font-family: Arial, color: #333;'>
                    <h2 style='color: #ff4d4d;'>Anúncio Reprovado</h2>
                    <p>Olá <strong>$nomePrestador</strong>,</p>
                    <p>Seu anúncio '<strong>$nomeProduto</strong>' foi reprovado.</p>
                    <p><strong>Motivo da Recusa:</strong> $motivo</p>
                    <p>Por favor, revise o conteúdo do seu anúncio e faça as alterações necessárias para enviá-lo novamente.</p>
                    <br>
                    <p>Atenciosamente,<br>Equipe Axey</p>
                </div>
            ";
            $mail->AltBody = "Olá $nomePrestador, Seu anúncio '$nomeProduto' foi reprovado. Motivo: $motivo.";

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Erro ao enviar e-mail: {$mail->ErrorInfo}");
        }

        // Redireciona com mensagem de sucesso
        header("Location: ../../frontend/adm/controleServicos.php?success=Produto reprovado e e-mail enviado com sucesso!");
        exit;

    } catch (Exception $e) {
        // Redireciona com mensagem de erro
        header("Location: ../../frontend/adm/controleServicos.php?error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    // Redireciona se o acesso não for via POST
    header("Location: ../../frontend/adm/controleServicos.php?error=Acesso inválido.");
    exit;
}
