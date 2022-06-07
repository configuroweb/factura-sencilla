<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if (!empty($_GET['invoice_id']) && $_GET['invoice_id']) {
	echo $_GET['invoice_id'];
	$invoiceValues = $invoice->getInvoice($_GET['invoice_id']);
	$invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);
}
$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['order_date']));
$output = '';
$output .= '<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<td colspan="2" align="center" style="font-size:18px"><b>Factura ConfiguroWeb</b></td>
	</tr>
	<tr>
	<td colspan="2">
	<table width="100%" cellpadding="5">
	<tr>
	<td width="65%">
	Para,<br />
	<b>RECEPTOR (FACTURACIÓN A)</b><br />
	Name : ' . $invoiceValues['order_receiver_name'] . '<br /> 
	Dirección de Envio : ' . $invoiceValues['order_receiver_address'] . '<br />
	</td>
	<td width="35%">         
	Factura no. : ' . $invoiceValues['order_id'] . '<br />
	Fecha de la factura : ' . $invoiceDate . '<br />
	</td>
	</tr>
	</table>
	<br />
	<table width="100%" border="1" cellpadding="5" cellspacing="0">
	<tr>
	<th align="left">Sr No.</th>
	<th align="left">Código Factura</th>
	<th align="left">Nombre Item</th>
	<th align="left">Cantidad</th>
	<th align="left">Precio</th>
	<th align="left">Cantidad real</th> 
	</tr>';
$count = 0;
foreach ($invoiceItems as $invoiceItem) {
	$count++;
	$output .= '
	<tr>
	<td align="left">' . $count . '</td>
	<td align="left">' . $invoiceItem["item_code"] . '</td>
	<td align="left">' . $invoiceItem["item_name"] . '</td>
	<td align="left">' . $invoiceItem["order_item_quantity"] . '</td>
	<td align="left">' . $invoiceItem["order_item_price"] . '</td>
	<td align="left">' . $invoiceItem["order_item_final_amount"] . '</td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>' . $invoiceValues['order_total_before_tax'] . '</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Porcentaje Impuestos :</b></td>
	<td align="left">' . $invoiceValues['order_tax_per'] . ' %</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Monto Impuestos: </td>
	<td align="left">' . $invoiceValues['order_total_tax'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Total: </td>
	<td align="left">' . $invoiceValues['order_total_after_tax'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Monto Pagado:</td>
	<td align="left">' . $invoiceValues['order_amount_paid'] . '</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Cambio:</b></td>
	<td align="left">' . $invoiceValues['order_total_amount_due'] . '</td>
	</tr>';
$output .= '
	</table>
	</td>
	</tr>
	</table>';
// create pdf of invoice	
$invoiceFileName = 'Factura ConfiguroWeb-' . $invoiceValues['order_id'] . '.pdf';
require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();

use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
