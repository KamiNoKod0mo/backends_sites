<?php
	// Configurações básicas
	$pagseguroConfig = [
	    'email' => '',
	    'token' => '', // Token disponível no painel do PagSeguro
	    'sandbox' => true, // true para ambiente de testes
	    'sandbox_email' => '',
	    'sandbox_token' => '',
	    'charset' => 'UTF-8', // Codificação
	    'log' => true,
	    'log_location' => 'pagseguro.log'
	];

	function createPagSeguroSession($config) {
	    $url = $config['sandbox'] 
	        ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions' 
	        : 'https://ws.pagseguro.uol.com.br/v2/sessions';
	    
	    $data = http_build_query([
	        'email' => $config['sandbox'] ? $config['sandbox_email'] : $config['email'],
	        'token' => $config['sandbox'] ? $config['sandbox_token'] : $config['token']
	    ]);
	    
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8']);
	    
	    $response = curl_exec($curl);
	    curl_close($curl);
	    
	    $xml = simplexml_load_string($response);

	    return $xml ? (string)$xml->id : false;
	}

	function createPaymentRequest($paymentData, $config) {
	    $url = $config['sandbox']
	        ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'
	        : 'https://ws.pagseguro.uol.com.br/v2/transactions';
	    
	    $data = [
	        'email' => $config['sandbox'] ? $config['sandbox_email'] : $config['email'],
	        'token' => $config['sandbox'] ? $config['sandbox_token'] : $config['token'],
	        'paymentMode' => 'default',
	        'paymentMethod' => $paymentData['method'], // boleto, creditCard etc
	        'currency' => 'BRL',
	        'itemId1' => '0001',
	        'itemDescription1' => $paymentData['product'],
	        'itemAmount1' => number_format($paymentData['amount'], 2, '.', ''),
	        'itemQuantity1' => 1,
	        'reference' => $paymentData['reference'],
	        'senderName' => $paymentData['customer']['name'],
	        'senderEmail' => $paymentData['customer']['email'],
	        'senderCPF' => $paymentData['customer']['cpf'],
	        'senderAreaCode' => substr($paymentData['customer']['phone'], 0, 2),
	        'senderPhone' => substr($paymentData['customer']['phone'], 2),
	        'shippingAddressStreet' => $paymentData['address']['street'],
	        'shippingAddressNumber' => $paymentData['address']['number'],
	        'shippingAddressComplement' => $paymentData['address']['complement'],
	        'shippingAddressDistrict' => $paymentData['address']['district'],
	        'shippingAddressPostalCode' => $paymentData['address']['postalCode'],
	        'shippingAddressCity' => $paymentData['address']['city'],
	        'shippingAddressState' => $paymentData['address']['state'],
	        'shippingAddressCountry' => 'BRA',
	        'shippingType' => 1,
	        'shippingCost' => number_format($paymentData['shipping'], 2, '.', '')
	    ];
	    
	    // Se for cartão de crédito
	    if ($paymentData['method'] === 'creditCard') {
	        $data['creditCardToken'] = $paymentData['creditCardToken'];
	        $data['installmentQuantity'] = '1'; // Problema nessas duas linhas
	        $data['installmentValue'] = '140.00'; // Problema
	        $data['creditCardHolderName'] = $paymentData['card']['name'];
	        $data['creditCardHolderCPF'] = $paymentData['card']['cpf'];
	        $data['creditCardHolderBirthDate'] = $paymentData['card']['birthDate'];
	        $data['creditCardHolderAreaCode'] = substr($paymentData['card']['phone'], 0, 2);
	        $data['creditCardHolderPhone'] = substr($paymentData['card']['phone'], 2);

	        $data['billingAddressStreet'] = $paymentData['billingAddress']['street'];
	        $data['billingAddressNumber'] = $paymentData['billingAddress']['number'];
	        $data['billingAddressDistrict'] = $paymentData['billingAddress']['district'];
	        $data['billingAddressPostalCode'] = $paymentData['billingAddress']['postalCode'];
	        $data['billingAddressCity'] = $paymentData['billingAddress']['city'];
	        $data['billingAddressState'] = $paymentData['billingAddress']['state'];
	        $data['billingAddressCountry'] = $paymentData['billingAddress']['country'];
	        
	        if (!empty($paymentData['billingAddress']['complement'])) {
	            $data['billingAddressComplement'] = $paymentData['billingAddress']['complement'];
	        }
	    }
	    
	    $data = http_build_query($data);
	    
	    $curl = curl_init($url);
	    curl_setopt($curl, CURLOPT_POST, true);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
	    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded; charset=UTF-8']);
	    
	    $response = curl_exec($curl);
	    curl_close($curl);
	    
	    return simplexml_load_string($response);
	}


?>








<script>
    // Inicializar a sessão primeiro com o ID de sessão que você gera no backend
    PagSeguroDirectPayment.setSessionId('<?= createPagSeguroSession($pagseguroConfig) ?>');

    const cardData = {
        number: '4111111111111111', // Sem espaços
        brand: '', // Vamos descobrir
        cvv: '123',
        expirationMonth: '12',
        expirationYear: '2030',
        holderName: 'FULANO DA SILVA'
    };

    // Primeiro, descobre a bandeira do cartão (Visa, Mastercard, etc.)
    PagSeguroDirectPayment.getBrand({
        cardBin: cardData.number.substring(0,6),
        success: function(response) {
            console.log('Bandeira detectada:', response.brand.name);
            cardData.brand = response.brand.name;

            // Depois de descobrir a bandeira, gera o token do cartão
            PagSeguroDirectPayment.createCardToken({
                cardNumber: cardData.number,
                brand: cardData.brand,
                cvv: cardData.cvv,
                expirationMonth: cardData.expirationMonth,
                expirationYear: cardData.expirationYear,
                success: function(response) {
                    console.log('Token do cartão gerado:', response.card.token);
                    // Agora envia para PHP usando AJAX
				    fetch('salvar_token.php', {
				      method: 'POST',
				      headers: { 'Content-Type': 'application/json' },
				      body: JSON.stringify({ token: cardToken })
				    })
				    .then(res => res.json())
				    .then(data => {
				      console.log('Token salvo:', data);
				    })
				    .catch(err => {
				      console.error('Erro ao salvar token:', err);
				    });

                },
                error: function(response) {
                    console.error('Erro ao gerar token:', response);
                }
            });
        },
        error: function(response) {
            console.error('Erro ao descobrir bandeira:', response);
        }
    });
</script>



<?php
	$paymentData = [
	    'method' => 'creditCard', // ou 'boleto', 'eft'
	    'product' => 'Nome do Produto',
	    'amount' => 140.00, // Valor total
	    'reference' => 'REF12345', // Seu ID de referência
	    'customer' => [
	        'name' => 'Fulano de Tal',
	        'email' => 'c68734942164979411988@sandbox.pagseguro.com.br',
	        'cpf' => '12345678909',
	        'phone' => '11987654321'
	    ],
	    'address' => [
	        'street' => 'Rua Exemplo',
	        'number' => '123',
	        'complement' => 'Apto 101',
	        'district' => 'Centro',
	        'postalCode' => '01001000',
	        'city' => 'São Paulo',
	        'state' => 'SP'
	    ],
	    'billingAddress' => [
	        'street' => 'Rua Exemplo',       // Obrigatório
	        'number' => '123',               // Obrigatório
	        'district' => 'Centro',          // Obrigatório
	        'postalCode' => '01001000',      // Obrigatório
	        'city' => 'São Paulo',           // Obrigatório
	        'state' => 'SP',                 // Obrigatório
	        'country' => 'BRA',              // Obrigatório
	        'complement' => 'Apto 101'       // Opcional
	    ],
	    'shipping' => 00.00 // Valor do frete
	];

	$paymentData['creditCardToken'] = 'c842738d4d504a5cba4927b2b1adc8cd'; // Obtido via JavaScript
	$paymentData['installments'] = 2; // Número de parcelas
	$paymentData['card'] = [
	    'name' => 'FULANO DE TAL', // Nome no cartão
	    'cpf' => '12345678909',
	    'birthDate' => '10/10/1990', // Formato dd/mm/YYYY
	    'phone' => '11987654321'
	];

	$response = createPaymentRequest($paymentData, $pagseguroConfig);

	if ($response === false) {
	    die("Erro ao processar pagamento");
	}

	// Tratamento da resposta
	if ($response->error) {
	    // Tratar erro
	    echo "Erro completo: <pre>";
    print_r($response->error);
    echo "</pre>";
	} else {
	    // Sucesso - redirecionar ou mostrar comprovante
	    if ($paymentData['method'] === 'boleto') {
	        header("Location: " . $response->paymentLink);
	    } else {
	        echo "Pagamento processado! Código: ";
	        echo "Erro completo: <pre>";
	        print_r($response);
	        echo "</pre>";
	    }
	}

?>