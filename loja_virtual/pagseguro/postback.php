<?php
// notification.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Pega o código da notificação
$notificationCode = $_POST['notificationCode'] ?? null;
$notificationType = $_POST['notificationType'] ?? null;

if ($notificationCode && $notificationType === 'transaction') {
    // Consultar a notificação na API do PagSeguro
    $url = "https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$notificationCode}?email=carlos.farias1267@gmail.com&token=x";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        // A resposta vem em XML
        $transaction = simplexml_load_string($response);

        // Agora você pode pegar dados da transação
        $status = (int)$transaction->status; // status do pagamento
        $reference = (string)$transaction->reference; // seu código de pedido
        
        // Salve no banco de dados, atualize pedido, envie e-mail, etc.
        file_put_contents('notificacao.log', print_r($transaction, true)); // Só para teste

        http_response_code(200); // Responder OK ao PagSeguro
        exit('Notificação processada');
    }
}

http_response_code(400); // Responder erro
exit('Dados inválidos');
?>
