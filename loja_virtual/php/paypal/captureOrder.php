<?php
require 'PayPalClient.php';
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

$client = PayPalClient::client();
$orderId = $_GET['token'];
$request = new OrdersCaptureRequest($orderId);
$request->prefer('return=representation');

try {
    $response = $client->execute($request);
    echo "Pagamento capturado com sucesso. ID da transação: " . $response->result->id;
    echo "<pre>";
    print_r($response->result);
    echo "</pre>";
} catch (HttpException $ex) {
    echo $ex->statusCode;
    print_r($ex->getMessage());
}
?>











//paypal-webhook.php, preciso de SSL


<?php
/*
require 'vendor/autoload.php'; // Carrega o SDK do PayPal

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Webhooks\VerifyWebhookSignatureRequest;

// Configuração
$clientId = 'x';
$clientSecret = 'x';
$webhookId = 'SEU_WEBHOOK_ID'; // pegue o ID do webhook no painel do PayPal!

// Ambiente (use SandboxEnvironment para testes, ProductionEnvironment para produção)
$environment = new SandboxEnvironment($clientId, $clientSecret);
//$environment = new ProductionEnvironment($clientId, $clientSecret);
$client = new PayPalHttpClient($environment);

// Lê o corpo da requisição recebida
$bodyReceived = file_get_contents('php://input');
$headers = getallheaders();

// Monta a requisição de verificação
$request = new VerifyWebhookSignatureRequest();
$request->headers = [
    'transmission_id'    => $headers['Paypal-Transmission-Id'],
    'transmission_time'  => $headers['Paypal-Transmission-Time'],
    'cert_url'           => $headers['Paypal-Cert-Url'],
    'auth_algo'          => $headers['Paypal-Auth-Algo'],
    'transmission_sig'   => $headers['Paypal-Transmission-Sig'],
    'webhook_id'         => $webhookId
];
$request->body = $bodyReceived;

try {
    $response = $client->execute($request);

    if ($response->result->verification_status == 'SUCCESS') {
        // Verificação OK. Agora podemos processar o evento
        $event = json_decode($bodyReceived, true);

        // Verifica o tipo de evento
        switch ($event['event_type']) {
            case 'PAYMENT.CAPTURE.COMPLETED':
                // Pagamento realizado
                file_put_contents('log.txt', "Pagamento concluído: " . json_encode($event) . "\n", FILE_APPEND);
                break;

            case 'PAYMENT.CAPTURE.DENIED':
                // Pagamento negado
                file_put_contents('log.txt', "Pagamento negado: " . json_encode($event) . "\n", FILE_APPEND);
                break;

            default:
                // Outros eventos
                file_put_contents('log.txt', "Outro evento: " . json_encode($event) . "\n", FILE_APPEND);
                break;
        }

        // Resposta para o PayPal dizendo que recebemos
        http_response_code(200);
    } else {
        // Falhou a verificação de assinatura!
        http_response_code(400);
        file_put_contents('log.txt', "Falha na verificação da assinatura!\n", FILE_APPEND);
    }
} catch (Exception $e) {
    http_response_code(500);
    file_put_contents('log.txt', "Erro: " . $e->getMessage() . "\n", FILE_APPEND);
}
*/
?>
