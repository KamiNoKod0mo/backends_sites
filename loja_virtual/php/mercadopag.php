<?php
require __DIR__ . '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('SEU_ACCESS_TOKEN'); // Pegue no painel de credenciais

// Criar uma preferência de pagamento
$preference = new MercadoPago\Preference();

$item = new MercadoPago\Item();
$item->title = 'Produto Teste';
$item->quantity = 1;
$item->unit_price = 100.00;

$preference->items = [$item];

// Você pode configurar URLs de retorno (opcional)
$preference->back_urls = array(
    "success" => "https://seusite.com/sucesso",
    "failure" => "https://seusite.com/falha",
    "pending" => "https://seusite.com/pendente"
);
$preference->auto_return = "approved";

$preference->save();
?>

<!-- Link para o botão de pagamento -->
<a href="<?= $preference->init_point ?>" target="_blank">Pagar com Mercado Pago</a>
