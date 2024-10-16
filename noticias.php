<?php

require_once("db.php");
require_once("validarpanel.php");


$stmt = $conx->prepare("SELECT * FROM noticias");
$stmt->execute();

$resultadoSTMT = $stmt->get_result();

$nuestroResultado = [];

while ($fila = $resultadoSTMT->fetch_object()) {
	$nuestroResultado[] = $fila;
}

$stmt->close();

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<a href="formularionot.php">NUEVA NOTICIA</a>
	<a href="listadopanel.php">USUARIOS</a>
	<a href="categorias.php">CATEGORIAS</a>
	<?php echo "Bienvenido" ?>

	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Titulo</th>
				<th>Descripcion</th>
				<th>Fecha</th>
				<th>Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($nuestroResultado as $fila) { ?>
				<tr>
					<td><?php echo $fila->ID ?></td>
					<td><?php echo $fila->titulo ?></td>
					<td><?php echo $fila->descripcion ?></td>
					<td><?php echo $fila->fecha ?></td>
					<td>
						<a href="formularionot.php?id=<?php echo $fila->ID ?>">Editar</a>
						<form action="eliminar_noticia.php" method="POST">
							<input type="hidden" value="<?php echo $fila->ID ?>" name="id">
							<input type="submit" value="Eliminar">
						</form>
					</td>


				</tr>
			<?php } ?>
		</tbody>
	</table>

</body>
</html>