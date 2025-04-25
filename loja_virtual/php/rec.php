<?php
@include('../config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Certifique-se de ter o Composer instalado

$mail = new PHPMailer(true);
$token = uniqid();
if (isset($_GET['email'])) {
    $sql = Mysql::connect()->prepare('SELECT * FROM usuarios WHERE email = ?');
    $sql->execute(array($_GET['email']));

    if ($sql->rowCount() == 1) {
        $info = $sql->fetch();

        $sqlI = Mysql::connect()->prepare('INSERT INTO tokens_recuperacao VALUES(null,?,?,DATE_ADD(NOW(), INTERVAL 1 DAY),?)');
        $sqlI->execute(array($info['id'],$token,0));

    }
}


try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP (ex: Gmail, Outlook)
    $mail->SMTPAuth   = true;
    $mail->Username   = 'carlos.farias1267@gmail.com'; // Seu e-mail SMTP
    $mail->Password   = 'usjd yroz povu dszr'; // Senha ou App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS ou SSL
    $mail->Port       = 587; // Porta (Gmail usa 587 para TLS, 465 para SSL)

    // Remetente e destinatário
    $mail->setFrom('carlos.farias1267@gmail.com', 'Seu Nome');
    $mail->addAddress($_GET['email'], 'teste1');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Assunto do E-mail';
    $mail->Body    = 'Link para a troca de senha: http://localhost/Projeto_etapa3/loja_virtual/change.php?token='.$token;
    $mail->AltBody = 'Este é um e-mail de teste enviado via PHPMailer!';

    $mail->send();
    header('Location: login.php');
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}



?>