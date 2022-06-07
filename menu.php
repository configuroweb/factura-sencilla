<ul class="nav navbar-nav">
	<li class="dropdown">
		<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Factura
			<span class="caret"></span></button>
		<ul class="dropdown-menu">
			<li><a href="invoice_list.php">Listar Facturas</a></li>
			<li><a href="create_invoice.php">Crear Factura</a></li>
		</ul>
	</li>
	<?php
	if ($_SESSION['userid']) { ?>
		<li class="dropdown">
			<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Hola de nuevo <?php echo $_SESSION['user']; ?>
				<span class="caret"></span></button>
			<ul class="dropdown-menu">
				<li><a href="action.php?action=logout">Cerrar Sesión</a></li>
			</ul>
		</li>
	<?php } ?>
</ul>
<br /><br /><br /><br />