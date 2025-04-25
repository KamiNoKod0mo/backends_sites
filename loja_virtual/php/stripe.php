<?php
require_once('vendor/autoload.php');
/*
$stripe = new \Stripe\StripeClient("sk_test_51RHNiIQdkHsg89WlMNLf0ZqjDpQ0iDN4e5h7hh79IeBLaKPOXXUkoRnEIbJ0JEtia6Tf6bCQ8nxh0Xzyb4Oobvky00oD4xq4ew");

$product = $stripe->products->create([
  'name' => 'Starter Subscription',
  'description' => '$12/Month subscription',
]);
echo "Success! Here is your starter subscription product id: " . $product->id . "\n";

$price = $stripe->prices->create([
  'unit_amount' => 1200,
  'currency' => 'usd',
  'recurring' => ['interval' => 'month'],
  'product' => $product['id'],
]);
echo "Success! Here is your starter subscription price id: " . $price->id . "\n";
*/

?>

<script async
  src="https://js.stripe.com/v3/buy-button.js">
</script>

<stripe-buy-button
  buy-button-id="buy_btn_1RHO9RQdkHsg89WlhM8X4Vnp"
  publishable-key="pk_test_51RHNiIQdkHsg89WlHdqYgEkwmcUVKd0FyEzIV4Q9zNpRxkSy3CNIzODU5wPlljriUPXBlUpdZuia7TlFqMGegDTf00GTlb4BHl"
>
</stripe-buy-button>


<meta name="viewport" content="width=device-width, initial-scale=1" />
<a href="https://buy.stripe.com/test_aEU5lT65PaJngjC8wx">COmpre</a>


