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
// Lettura da variabili globali dei valori passati in post

    $titolo = $_POST["titolo"];
    $codisbn = $_POST["codisbn"];
    $nomea = $_POST["nomea"];
    $cognomea = $_POST["cognomea"];
    $nomece = $_POST["nomece"];
    $linguaorig  = $_POST["linguaorig"];
    $linguacopia  = $_POST["linguacopia"];
    $annopub  = $_POST["annopub"];
    $annostampa  = $_POST["annostampa"];
    $nedizione  = $_POST["nedizione"];
    $sezione  = $_POST["sezione"];
    $scaffale  = $_POST["scaffale"];

   include 'ConnessioneServer.php';

/*
    INSERIMENTO AUTORE
*/

$queryverificaautore="
    SELECT CASE WHEN EXISTS (
        SELECT *
        FROM autore
        WHERE nome='$nomea' AND cognome='$cognomea'
    )
    THEN TRUE
    ELSE FALSE END
";

$resultverificaautore=pg_query($db, $queryverificaautore);
if(!$resultverificaautore){
  echo pg_last_error($db);
  exit;
}else
  $presenzaAUTORE=pg_fetch_result($resultverificaautore, 0, 0);
if($presenzaAUTORE=='f'){
      $queryinserimentoautore="
                  INSERT INTO autore(nome,cognome)
                  VALUES ('$nomea','$cognomea')
      ";
      $resultinserimentoautore=pg_query($db, $queryinserimentoautore);
      if(!$resultinserimentoautore) {
            echo pg_last_error($db);
            exit;
      }
}else {
  echo "";
}

  /*
    INSERIMENTO CASA EDITRICE
  */
  $queryverificacasaeditrice="
      SELECT CASE WHEN EXISTS (
          SELECT *
          FROM casaeditrice
          WHERE nomece='$nomece'
      )
      THEN TRUE
      ELSE FALSE END
  ";

  $resultverificacasaeditrice=pg_query($db, $queryverificacasaeditrice);
  if(!$resultverificacasaeditrice){
    echo pg_last_error($db);
    exit;
  }else
    $presenzaCASAEDITRICE=pg_fetch_result($resultverificacasaeditrice, 0, 0);

  if($presenzaCASAEDITRICE=='f'){

      $queryinserimentocasaeditrice="
              INSERT INTO casaeditrice(nomece)
              VALUES ('$nomece')
      ";
        $resultinserimentocasaeditrice=pg_query($db, $queryinserimentocasaeditrice);
        if(!$resultinserimentocasaeditrice) {
              echo pg_last_error($db);
              exit;
        }
  }else{
    echo "";
  }



  /*
    INSERIMENTO OPERA
  */

  $queryverificaopera="
      SELECT CASE WHEN EXISTS (
          SELECT *
          FROM opera
          WHERE titolo='$titolo' AND linguaorig='$linguaorig' AND annopub='$annopub'
      )
      THEN TRUE
      ELSE FALSE END
  ";

  $resultverificaopera=pg_query($db, $queryverificaopera);
  if(!$resultverificaopera){
    echo pg_last_error($db);
    exit;
  }else
    $presenzaOPERA=pg_fetch_result($resultverificaopera, 0, 0);

  if($presenzaOPERA=='f'){
        $queryprendiIDautore="
              SELECT idautore
              FROM autore
              WHERE nome='$nomea' AND cognome='$cognomea'
        ";
        $resultprendiIDautore=pg_query($db, $queryprendiIDautore);
        if($resultprendiIDautore){
            while($row = pg_fetch_array($resultprendiIDautore)) {
              $idautore=$row[0];
            }
        }
          //inserisco la nuova opera
        $queryinserimentoopera="
          INSERT INTO opera(titolo,linguaorig,annopub,idautore)
          VALUES ('$titolo','$linguaorig','$annopub','$idautore')
        ";
        $resultinserimentoopera=pg_query($db, $queryinserimentoopera);
        if(!$resultinserimentoopera) {
              echo pg_last_error($db);
              exit;
        }
  }else{
    echo "";
  }




//Creare la copia
//prendo l'IDopera per inserirlo in copia in seguito
$queryprendiIDopera="
    SELECT idopera
    FROM opera
    WHERE titolo='$titolo' AND linguaorig='$linguaorig' AND annopub='$annopub'
";

$resultprendiIDopera=pg_query($db, $queryprendiIDopera);
if($resultprendiIDopera){
    $idopera=pg_fetch_result($resultprendiIDopera, 0, 0);
}
//inserisco la nuova copia
$queryinserimentocopia="
      INSERT INTO copia(codisbn,annostampa,lingua,edizione,sezione,scaffale,idopera,nomece)
      VALUES('$codisbn','$annostampa','$linguacopia','$nedizione','$sezione','$scaffale','$idopera','$nomece')
";


$resultinserimentocopia=pg_query($db, $queryinserimentocopia);

if(!$resultinserimentocopia) {
      echo pg_last_error($db);
      exit;
}else
          echo "inserimento copia avvenuto con successo";


// chiudo la connessione
pg_close($db);

?>
</body>
</html>
