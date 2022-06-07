<?php
session_start();
include('inc/header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<title>Sistema Básico de Facturación en PHP y MySQL</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('inc/container.php'); ?>
<div class="container">
  <h2 class="title">Sistema Básico de Facturación</h2>
  <?php include('menu.php'); ?>
  <table id="data-table" class="table table-condensed table-striped">
    <thead>
      <tr>
        <th># Factura</th>
        <th>Fecha Creación</th>
        <th>Nombre del Cliente</th>
        <th>Total Facturado</th>
        <th>Imprimir</th>
        <th>Editar</th>
        <th>Eliminar</th>
      </tr>
    </thead>
    <?php
    $invoiceList = $invoice->getInvoiceList();
    foreach ($invoiceList as $invoiceDetails) {
      $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
      echo '
              <tr>
                <td>' . $invoiceDetails["order_id"] . '</td>
                <td>' . $invoiceDate . '</td>
                <td>' . $invoiceDetails["order_receiver_name"] . '</td>
                <td>' . $invoiceDetails["order_total_after_tax"] . '</td>
                <td><a href="print_invoice.php?invoice_id=' . $invoiceDetails["order_id"] . '" title="Imprimir Factura"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id=' . $invoiceDetails["order_id"] . '"  title="Editar Factura"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="' . $invoiceDetails["order_id"] . '" class="deleteInvoice"  title="Eliminar Factura"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
    }
    ?>
  </table>
</div>
<?php include('inc/footer.php'); ?>