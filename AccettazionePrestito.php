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



$username=$_POST["usernameACC"];
$datainizio = date('Y-m-d');
$numeroreg=$_POST["numeroregACC"];
$titolo=$_POST["titoloACC"];


include 'ConnessioneServer.php';

$azione=$_POST["azione"];
if($azione=="Accetta"){

  $queryaccetta ="
          UPDATE prestito
          SET datainizio='$datainizio', accettato=TRUE
          WHERE username='$username' AND numeroreg='$numeroreg'
    ";

  $resultaccetta=pg_query($db, $queryaccetta);
  if(!$resultaccetta) {
    echo pg_last_error($db);
    exit;
  }else{
    echo "Prestito Accettato";
  }
}else{

  $queryrifiuta ="
          DELETE FROM prestito
          WHERE username='$username' AND numeroreg='$numeroreg' AND accettato=FALSE
    ";

    $resultrifiuta=pg_query($db, $queryrifiuta);
    if(!$resultrifiuta) {
      echo pg_last_error($db);
      exit;
    }else{
      echo "Prestito Rifiutato";
    }
}
pg_close($db);
 ?>
