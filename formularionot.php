<?php
	require_once("db.php");
	require_once("validarpanel.php");

	$id = isset($_GET["id"]) ? $_GET["id"] : 0;

	$idFormulario = isset($_POST["id"]) ? $_POST["id"] : 0;
	$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
	$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
	$fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d H:i:s");
	$envio_formulario = isset($_POST["envio_formulario"]) ? $_POST["envio_formulario"] : 0;

	if ($envio_formulario == "1") {		

		$error = 0;
		$mensaje = "";

		if (empty($titulo)) {
			$error = 1;
			$mensaje = "Por favor ingrese el titulo";
		}

		if (empty($descripcion)) {
			$error = 1;
			$mensaje = "Por favor ingrese la descripcion";
		}
		if (empty($fecha)) {
			$error = 1;
			$mensaje = "Por favor ingrese la fecha";
		}


		if ($error == 0) { 			
			if ($idFormulario == 0) {				
				$sql = "INSERT INTO noticias (titulo, descripcion, fecha) ";
				$sql.= "VALUES (?, ?, ?) ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("sss", $titulo, $descripcion, $fecha);
				$stmt->execute();
				$stmt->close();
			} else {
				$sql = "UPDATE noticias SET titulo = ?, descripcion = ?, fecha = ? ";
				$sql.= "WHERE id = ? ";

				$stmt = $conx->prepare($sql);
				$stmt->bind_param("sssi", $titulo, $descripcion, $fecha, $idFormulario);
				$stmt->execute();
				$stmt->close();
			}
			header("Location: noticias.php");
			exit();
		} else {
			echo $mensaje;
		}

	}

	$sql = "SELECT * FROM noticias WHERE id = ? ";

	$stmt = $conx->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$resultado = $stmt->get_result();

	$usuario = $resultado->fetch_object();

	$stmt->close();

	if ($usuario === null) {
		$id = 0;
		$titulo = "";
		$descripcion = "";
		$fecha = date("Y-m-d H:i:s");
	} else {
		$id = $usuario->ID;
		$titulo = $usuario->titulo;
		$descripcion = $usuario->descripcion;
		$fecha = $usuario->fecha;
	}
?>

<form method="POST">
	<input type="hidden" value="1" name="envio_formulario">

	<input type="hidden" name="id" value="<?php echo $id ?>">

	<label>Ingrese el titulo</label><br>
	<input type="text" value="<?php echo $titulo ?>" name="titulo"/>
	
	<br><label>Descripcion</label><br>
	<textarea name="descripcion" rows="5"><?php echo $descripcion ?></textarea>

	<?php if ($id == 0) { ?>
		<br><label>Fecha de la noticia</label><br>
		<input type="datetime-local" value="<?php echo $fecha ?>" name="fecha_noticia">
	<?php } else { ?>
		<input type="hidden" value="<?php echo $fecha ?>" name="fecha_noticia">
	<?php } ?>


	<input type="submit">
</form>