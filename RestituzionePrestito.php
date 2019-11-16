<html>
<head>

<link href="css/style.css" rel="stylesheet">

</head>
<body>

<div>
<ul>

  <li><h1>Biblioteca</h1></li>

  <li style="float:right"><a class="active" href="disconnetti.php">Disconnetti</a>   </li>
  <li style="float:right"> <a href="LibreriaDipendente.php">Libreria</a></li>
  <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
  <li style="float:right"> <a href="ProfiloDipendente.php">Profilo</a></li>

</ul>
</div>

<?php
session_start();



$username=$_POST["usernameRES"];
$now = date('Y-m-d');
$numeroreg=$_POST["numeroregRES"];
$titolo=$_POST["titoloRES"];

include 'ConnessioneServer.php';

  $queryrestituzione ="
          UPDATE prestito
          SET datariconsegna='$now'
          WHERE username='$username' AND numeroreg='$numeroreg' AND accettato=TRUE
    ";

  $resultrestituzione=pg_query($db, $queryrestituzione);
  if(!$resultrestituzione) {
    echo pg_last_error($db);
    exit;
  }else{
    echo "Prestito concluso, libro restituito";
  }

pg_close($db);
 ?>
