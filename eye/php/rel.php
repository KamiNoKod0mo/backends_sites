<?php
date_default_timezone_set('America/Sao_Paulo');

include('Mysql.php');
//Conectar com banco de dados!
define('HOST','localhost');
define('USER','carlos');
define('PASSWORD','1234');
define('DATABASE','GODeyeDB');

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Html;

use PhpOffice\PhpSpreadsheet\Spreadsheet; 
use PhpOffice\PhpSpreadsheet\Writer\Xlsx; 


$tipoRel = $_POST['tipo_relatorio'];
$data_ini = $_POST['date_ini'];
$data_fin = $_POST['date_fin'];

$format_file = $_POST['tipo_arquivo'];
$passAdmin = $_POST['pass_admin'];

$check = $_POST['check'] ?? '';
$email = $_POST['email'] ?? '';


//print_r($_POST);

if ($passAdmin == '12345' and $data_ini !='' and $data_fin !='' and $format_file !='' ) {
	if ($tipoRel == 'tudo') {
		
		$sql = Mysql::connect()->prepare('SELECT * FROM user_logs 
                         WHERE last_online BETWEEN :data_inicial AND :data_final
                         ORDER BY last_online DESC');
    
	    // Faz o bind dos parâmetros
	    $sql->bindValue(':data_inicial', $data_ini);
	    $sql->bindValue(':data_final', $data_fin);
	    
	    // Executa a consulta
	    $sql->execute();

	    $logs = $sql->fetchAll(PDO::FETCH_ASSOC);

	    
		$tabelaHTML = '
			<style>
			    table {
			        border-collapse: separate;
			        border-spacing: 15px;
			        width: 100%;
			    }
			    td, th {
			        padding: 8px;
			        border: 1px solid #ddd;
			    }
			</style>
			<table class="tabela-logs">
			    <thead>
			        <tr>
			            <th>Nome do usuário</th>
			            <th>Endereço IP</th>
			            <th>Latitude</th>
			            <th>Longitude</th>
			            <th>Status</th>
			        </tr>
			    </thead>
			    <tbody>';

			foreach ($logs as $row) {
			    $tempoOffline = time() - strtotime($row['last_online']);
			    $status = ($tempoOffline < 300) ? "On" : htmlspecialchars($row['last_online']);
			    
			    $tabelaHTML .= '
			        <tr>
			            <td>' . htmlspecialchars($row['username']) . '</td>
			            <td>' . htmlspecialchars($row['ip_address']) . '</td>
			            <td>' . htmlspecialchars($row['latitude']) . '</td>
			            <td>' . htmlspecialchars($row['longitude']) . '</td>
			            <td>' . $status . '</td>
			        </tr>';
			}

			$tabelaHTML .= '
			    </tbody>
			</table>';

		// Agora você pode usar $tabelaHTML onde precisar
		//echo $tabelaHTML;

		if ($format_file == 'PDF') {
			try {
		        // Configuração
					$options = new Options();
					$options->set('isRemoteEnabled', true);
					$options->set('isHtml5ParserEnabled', true);

					$dompdf = new Dompdf($options);

					$dompdf->loadHtml($tabelaHTML);
					$dompdf->setPaper('A4', 'portrait');
					$dompdf->render();

					// Saída
					if ($check !='' and $email != '' ) {
						$tempDir = "tmp_down";
						// Gerar um nome de arquivo único
						$filename = 'documento_' . uniqid() . '.pdf';
						$filepath = $tempDir . DIRECTORY_SEPARATOR . $filename;

						// Salvar o PDF no arquivo
						file_put_contents($filepath, $dompdf->output());
						$tipo = ".pdf";
					}else{
						$dompdf->stream("relatorio.pdf", [
					    	"Attachment" => false // true para download automático
						]);
					}
		        
		    } catch (\Exception $e) {
		        die("Erro ao gerar PDF: " . $e->getMessage());
		    }
		}else if($format_file == 'Word'){
			

		}else if($format_file == 'Excel'){
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			// 2. Adicionar cabeçalhos
			$sheet->setCellValue('A1', 'Nome do usuário');
			$sheet->setCellValue('B1', 'Endereço IP');
			$sheet->setCellValue('C1', 'Latitude');
			$sheet->setCellValue('D1', 'Longitude');
			$sheet->setCellValue('E1', 'Status');

			$headerStyle = [
			    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
			    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']]
			];
			$sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

			$rowNumber = 2; // Começa na linha 2 (abaixo do cabeçalho)

			foreach ($logs as $row) {
			    $tempoOffline = time() - strtotime($row['last_online']);
			    $status = ($tempoOffline < 300) ? "Online" : "Offline desde " . $row['last_online'];
			    
			    $sheet->setCellValue('A'.$rowNumber, $row['username']);
			    $sheet->setCellValue('B'.$rowNumber, $row['ip_address']);
			    $sheet->setCellValue('C'.$rowNumber, $row['latitude']);
			    $sheet->setCellValue('D'.$rowNumber, $row['longitude']);
			    $sheet->setCellValue('E'.$rowNumber, $status);
			    
			    $rowNumber++;
			}

			// 4. Ajustar largura das colunas automaticamente
			foreach (range('A', 'E') as $column) {
			    $sheet->getColumnDimension($column)->setAutoSize(true);
			}

			$filepath = 'logs_usuarios_' . date('Y-m-d') . '.xlsx';

			if ($check != '' and $email !='') {
				$writer = new Xlsx($spreadsheet);
				$writer->save('tmp_down/'.$filepath);
				$filepath = 'tmp_down/'.$filepath;
				$tipo = '.xlsx';
				
			}else{
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="' . $filepath . '"');
				header('Cache-Control: max-age=0');

				$writer = new Xlsx($spreadsheet);
				$writer->save('php://output');
				
			}
		}

		if ($check !='' and $email != '' ) {
			send_email($filepath,$email,$tipo);
		}
			
	}else{
		echo "outra opção futura";
	}
}else{
	echo "Senha errada";
}

function send_email($arquivo,$destino,$tipo){
	$mail = new PHPMailer(true);

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
	    $mail->addAddress($destino, 'teste1');

	    // Conteúdo do e-mail
	     $mail->addAttachment($arquivo, 'Relatorio'.$tipo);

	    $mail->isHTML(true);
	    $mail->Subject = 'Assunto do E-mail';
	    $mail->Body    = 'Segue o anexo';
	    $mail->AltBody = 'Segue o anexo solicitado';

	    $mail->send();
	    echo 'E-mail enviado com sucesso!';
	} catch (Exception $e) {
	    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
	}

}

?>


<!-- Exemplo html
<table>
	<thead>
		<tr>
			<th>Nome do usuario</th>
			<th>Endereço IP</th>
			<th>Latítude</th>
			<th>Longitude</th>
			<th>Status</th>
		</tr>
	</thead>
	<?php foreach ($logs as $key => $row){ ?>
		<tr>
		    <td><?= htmlspecialchars($row['username']) ?></td>
		    <td><?= htmlspecialchars($row['ip_address']) ?></td>
		    <td><?= htmlspecialchars($row['latitude']) ?></td>
		    <td><?= htmlspecialchars($row['longitude']) ?></td>
		    <td>
		        <?php
					$tempoOffline = time() - strtotime($row['last_online']);

					if ($tempoOffline < 300) {
						echo "On";
					} else {
						echo $row['last_online'];
					}
				?>

		    </td>
		</tr>
	<?php }?>
</table>
-->