<?php 

include_once("conn.php");


$html = '<table border=1';	
	$html .= '<thead>';
	$html .= '<tr>';
	$html .= '<th>ID</th>';
	$html .= '<th>Nome</th>';
	$html .= '<th>E-mail</th>';
	$html .= '<th>Telefone</th>';
	$html .= '<th>Data</th>';
	$html .= '</tr>';
	$html .= '</thead>';
	$html .= '<tbody>';
	
	$result_usuarios = "SELECT * FROM contatos";
	$resultado_usuarios = mysqli_query($conn, $result_usuarios);
	while($row_usuarios = mysqli_fetch_assoc($resultado_usuarios)){
		$html .= '<tr><td>'.$row_usuarios['id'] . "</td>";
		$html .= '<td>'.$row_usuarios['name'] . "</td>";
		$html .= '<td>'.$row_usuarios['email'] . "</td>";
		$html .= '<td>'.$row_usuarios['tel'] . "</td>";
		$html .= '<td>'.$row_usuarios['date'] . "</td></tr>";		
	}
	
	$html .= '</tbody>';
	$html .= '</table';

//referenciar o DOMPDF com namespace
use Dompdf\Dompdf;

//include autoloader
require_once 'dompdf/autoload.inc.php';

//criando instância
$dompdf = new DOMPDF();

// função para imprimir o arquivo em PDF
$dompdf->load_html('
    <h2 align="center">Relatorio em PDF</h2>
    '. $html .'
');

//Renderizar o html
$dompdf->render();

//Exibir a pagina
$dompdf->stream(
    "relatorio.pdf",
    array(
        "Attachment" => false  //Para realizar o download somente alterar para "TRUE"
    )
    );

?>