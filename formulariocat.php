<?php
	require_once("db.php");
	require_once("validarpanel.php");

	$id = isset($_GET["id"]) ? $_GET["id"] : 0;

	$idFormulario = isset($_POST["id"]) ? $_POST["id"] : 0;
	$nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
	$envio_formulario = isset($_POST["envio_formulario"]) ? $_POST["envio_formulario"] : 0;

	if ($envio_formulario == "1") {		

		$error = 0;
		$mensaje = "";

		if (empty($nombre)) {
			$error = 1;
			$mensaje = "Por favor ingrese el nombre de la categoria";
		}

		if ($error == 0) { 			
			if ($idFormulario == 0) {				
				$sql = "INSERT INTO categorias (nombre) ";
				$sql.= "VALUES (?) ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("s", $nombre);
				$stmt->execute();
				$stmt->close();
			} else {
				$sql = "UPDATE categorias SET nombre = ? ";
				$sql.= "WHERE id = ? ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("si", $nombre, $idFormulario);
				$stmt->execute();
				$stmt->close();
			}
			header("Location: categorias.php");
			exit();
		} else {
			echo $mensaje;
		}

	}

	$sql = "SELECT * FROM categorias WHERE id = ? ";

	$stmt = $conx->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$resultado = $stmt->get_result();

	$usuario = $resultado->fetch_object();

	$stmt->close();

	if ($usuario === null) {
		$id = 0;
		$nombre = "";
		
	} else {
		$id = $usuario->ID;
		$nombre = $usuario->nombre;
		
	}
?>

<form method="POST">
	<input type="hidden" value="1" name="envio_formulario">

	<input type="hidden" name="id" value="<?php echo $id ?>">

	<label>Ingrese el nombre de la categoria</label><br>
	<input type="text" value="<?php echo $nombre ?>" name="nombre"/>

	<input type="submit">
</form>