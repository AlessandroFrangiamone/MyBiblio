<html>
<head>

	<link href="css/style.css" rel="stylesheet">

	</head>

	<body>
		<!-- Prove navbar -->
		<div>
	<ul>
		<!--<h1 align="left"><span><a>Biblioteca</a></span></h1>-->
		<li><h1>Biblioteca</h1></li>

		<li style="float:right"><a class="active" href="disconnetti.php">Disconnetti</a>   </li>

		<li style="float:right"> <a href="LibreriaUtente.php">Libreria</a></li>
		<li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
		<li style="float:right"> <a href="ProfiloUtente.php">Profilo</a></li>


	</ul>

       </div>



<h2>Libreria:</h2>

<p>Cerca:</p>
<form action="LibreriaUtenteRicerca.php" method="POST" >
	<input type="text" name="ricerca" placeholder="Inserisci autore o libro">
	<input type="submit" value="Invio">
</form>

<?php
session_start();

include 'ConnessioneServer.php';

$query =<<<EOF
      SELECT *
      FROM opera
      JOIN copia ON opera.idopera = copia.idopera
      JOIN autore ON opera.idautore = autore.idautore
      JOIN casaeditrice ON copia.nomece = casaeditrice.nomece
EOF;

// eseguo la query
$result=pg_query($db, $query);

if(!$result) {
  echo pg_last_error($db);
  exit;
}else{
  echo "<center><table>";
  echo "<tr>   <td><p>CODICE ISBN</p></td>  <td><p>SEZIONE</p></td>  <td><p>SCAFFALE</p></td>  <td><p>TITOLO</p></td>  <td><p>LINGUA</p></td>  <td><p>ANNO</p></td> <td><p>EDIZIONE</p></td>  <td><p>AUTORE</p></td>  <td><p>CASA EDITRICE</p></td> <td><p>GIUDIZIO</p></td> <td>RICHIEDI PRESTITO</td> </tr>";
  while($row = pg_fetch_array($result)) {





      $titolo = $row['titolo'];
      $lingua = $row['lingua'];
      $annopub = $row['annopub'];
      $autore = $row['nome']." ".$row['cognome'];
      $casaeditrice=$row['nomece'];
      $codisbn=$row['codisbn'];
      $sezione=$row['sezione'];
      $scaffale=$row['scaffale'];
      $numeroreg=$row['numeroreg'];
			$edizione=$row['edizione'];



      $querymediagiudizio="
        SELECT AVG(voto)
        FROM recensione JOIN copia ON recensione.numeroreg=copia.numeroreg
        WHERE recensione.numeroreg='$numeroreg'
      ";
      $resultmediagiudizio=pg_query($db, $querymediagiudizio);
      if(!$resultmediagiudizio){
        echo pg_last_error($db);
        exit;
      }else
        $mediagiudizio=round(pg_fetch_result($resultmediagiudizio, 0, 0),2);




      echo "<tr><form  method='POST' action='richiediPrestito.php'>
      <td>".$codisbn."<input name=codisbn type=hidden value='".$codisbn."'></td>
      <td>".$sezione."<input name=sezione type=hidden value='".$sezione."'></td>
      <td>".$scaffale."<input name=scaffale type=hidden value='".$scaffale."'></td>
      <td>".$titolo."<input name=titolo type=hidden value='".$titolo."'></td>
      <td>".$lingua."<input name=linguaorig type=hidden value='".$lingua."'></td>
      <td>".$annopub."<input name=annopub type=hidden value='".$annopub."'></td>
			<td>".$edizione."<input name=edizione type=hidden value='".$edizione."'></td>
      <td>".$autore."<input name=autore type=hidden value='".$autore."'></td>
      <td>".$casaeditrice."<input name=casaeditrice type=hidden value='".$casaeditrice."'></td>
      <td>".$mediagiudizio."<input name=casaeditrice type=hidden value='".$mediagiudizio."'></td>
      <td><input name=numeroreg type=hidden value='".$numeroreg."'><input type='submit' value='Prestito'></td>
      </form></tr>";
  }
  echo "</table></center>";
}

pg_close($db);
 ?>
		</body>
</html>
