
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



$username=$_SESSION["username"];
$datainizio = date('Y-m-d');
$numeroreg=$_POST["numeroreg"];


//ho inserito gli spazi perchè il campo tipo nel database è 12 quindi quello che "avanza" sarà blank
if(strcmp($_SESSION["tipo"],"studente    ")==0){
  //$datariconsegna=date( "Y-m-d", strtotime( "now +2 month" ) );
  $maxprestiti=5;
}

if(strcmp($_SESSION["tipo"],"docente     ")==0){
  //$datariconsegna=date( "Y-m-d", strtotime( "now +3 month" ) );
  $maxprestiti=10;
}

if(strcmp($_SESSION["tipo"],"altro       ")==0){
  //$datariconsegna=date( "Y-m-d", strtotime( "now +2 week" ) );
  $maxprestiti=3;
}

include 'ConnessioneServer.php';

$queryverificaPresenza="
    SELECT CASE WHEN EXISTS (
        SELECT *
        FROM prestito
        WHERE numeroreg='$numeroreg' AND datariconsegna IS NULL
    )
    THEN TRUE
    ELSE FALSE END
";

$resultverificaPresenza=pg_query($db, $queryverificaPresenza);
if(!$resultverificaPresenza){
  echo pg_last_error($db);
  exit;
}else
  //Prende la cella 0,0 del risultato
  $presenza=pg_fetch_result($resultverificaPresenza, 0, 0);

//------------------------------------------------------------------------------

if($presenza==f){
      $querycontaprestiti="
        SELECT COUNT(*)
        FROM prestito
        WHERE username='$username' AND datariconsegna IS NULL
      ";

      $resultcontaprestiti=pg_query($db, $querycontaprestiti);
      if(!$resultcontaprestiti){
        echo pg_last_error($db);
        exit;
      }else
        //Prende la cella 0,0 del risultato
        $qntprestiti=pg_fetch_result($resultcontaprestiti, 0, 0);

      if($qntprestiti<$maxprestiti){
            $query ="
              INSERT INTO prestito(datainizio,numeroreg,username)
              VALUES ('$datainizio','$numeroreg','$username')
            ";

            // eseguo la query
            $result=pg_query($db, $query);

            if(!$result) {
              echo pg_last_error($db);
              exit;
            }else{
              echo "Richiesta di prestito inviata con successo";
            }
      }else {
        echo "Hai raggiunto il numero massimo di prestiti,
        riconsegna qualche libro per poter prendere in prestito nuovi libri";
      }
}else {
  echo "Il libro selezionato non è disponibile, un altro utente ha preso in prestito lo stesso libro.";
}

pg_close($db);
 ?>
