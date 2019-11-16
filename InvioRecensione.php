<html>
<head>

<link href="css/style.css" rel="stylesheet">

</head>
<body>

<div>
<ul>

  <li><h1>Biblioteca</h1></li>

  <li style="float:right"><a class="active" href="disconnetti.php">Disconnetti</a>   </li>

  <li style="float:right"> <a href="LibreriaUtente.php">Libreria</a></li>
  <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
  <li style="float:right"> <a href="ProfiloUtente.php">Profilo</a></li>

</ul>
</div>

<?php
session_start();



$username=$_POST["username"];
$numeroreg=intval($_POST["numeroreg"]);
$titolo=$_POST["titolo"];
$datainizio=$_POST["datainizio"];
$datariconsegna=$_POST["datariconsegna"];

$giudizio=$_POST["giudizio"];
$commento=$_POST["commento"];

include 'ConnessioneServer.php';

$queryverificarecensione="
    SELECT CASE WHEN EXISTS (
        SELECT *
        FROM recensione
        WHERE numeroreg='$numeroreg' AND username='$username'
    )
    THEN TRUE
    ELSE FALSE END
";

$resultverificarecensione=pg_query($db, $queryverificarecensione);
if(!$resultverificarecensione){
  echo pg_last_error($db);
  exit;
}else
  $recensione=pg_fetch_result($resultverificarecensione, 0, 0);

if($recensione==f){
    $queryaggiungirecensione="
      INSERT INTO recensione(commento, voto, numeroreg, username)
      VALUES('$commento','$giudizio','$numeroreg','$username')
    ";

    $resultaggiungirecensione=pg_query($db, $queryaggiungirecensione);
    if(!$resultaggiungirecensione){
      echo pg_last_error($db);
      exit;
    }else
      echo "Recensione inserita";
}else {
  echo "Hai già inserito una recensione per questo libro.";
}

?>
</body>
</html>
