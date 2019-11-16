<html>
<head>

	<link href="css/style.css" rel="stylesheet">


	</head>
	<body>

	<div>
	<ul>
		<!--<h1 align="left"><span><a>Biblioteca</a></span></h1>-->
		<li><h1>Biblioteca</h1></li>

		<li style="float:right"><a class="active" href="disconnetti.php">Disconnetti</a>   </li>

		<li style="float:right"> <a href="LibreriaDipendente.php">Libreria</a></li>
		<li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
		<li style="float:right"> <a href="ProfiloDipendente.php">Profilo</a></li>
		<li style="float:right"> <a href="NuovoLibro.php">Inserisci Libro</a></li>


	</ul>

       </div>


<h2>Libreria:</h2>

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
  echo "<tr>   <td><p>CODICE ISBN</p></td>  <td><p>SEZIONE</p></td>  <td><p>SCAFFALE</p></td>  <td><p>TITOLO</p></td>  <td><p>LINGUA</p></td>  <td><p>ANNO</p></td>  <td><p>EDIZIONE</p></td>  <td><p>AUTORE</p></td>  <td><p>CASA EDITRICE</p></td> </tr>";
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

    echo "<tr>
    <td>".$codisbn."</td>
    <td>".$sezione."</td>
    <td>".$scaffale."</td>
    <td>".$titolo."</td>
    <td>".$lingua."</td>
    <td>".$annopub."</td>
		<td>".$edizione."</td>
    <td>".$autore."</td>
    <td>".$casaeditrice."</td>
    </tr>";

  }
  echo "</table></center>";
}

pg_close($db);
 ?>
		</body>
</html>
