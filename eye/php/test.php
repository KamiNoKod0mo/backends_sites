<?php

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuração
$options = new Options();
$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);

$dompdf = new Dompdf($options);

// HTML
$html = '<h1>Relatório Moderno</h1><p>Gerado em: '.date('d/m/Y').'</p>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Saída
$dompdf->stream("relatorio.pdf", [
    "Attachment" => false // true para download automático
]);
