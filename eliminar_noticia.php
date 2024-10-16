<?php

require_once("db.php");
require_once("validarpanel.php");

$id = isset($_POST["id"]) ? $_POST["id"] : 0;

$stmt = $conx->prepare("DELETE FROM noticias WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: noticias.php");
die();


