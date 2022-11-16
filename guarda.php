<?php

session_start();

$conn = new mysqli("node139606-quiniela.hidora.com", "root", "p1skT1CFNB", "worldcup_db");
 
$sql_insert="insert into pronosticos (id_juego,id_usuario,goles_a,goles_b,id_torneo) values ('".$_GET['id_juego']."','".$_SESSION['usuario']."','".$_GET['goles_a']."','".$_GET['goles_b']."','".$_GET['torneo_id']."')";

//echo $sql_insert;
mysqli_query($conn , $sql_insert);

$url="quiniela.php?mensaje=guardado&torneo_id=".$_GET['torneo_id'];
header("Location: ".$url);

?>