<?php
  $conn = new mysqli("node139606-quiniela.hidora.com", "root", "p1skT1CFNB", "worldcup_db");
  
  if ($conn->connect_error) {
    die("ERROR: Unable to connect: " . $conn->connect_error);
  } 

 

//$result = $conn->query("SELECT * FROM equipo");

 // echo "Number of rows: $result->num_rows";

  //$result->close();

  //$conn->close();

   

?>