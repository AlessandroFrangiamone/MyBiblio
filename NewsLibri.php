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

<?php
session_start();

if(strcmp($_SESSION["tipo"],"dipendente  ")==0){
  echo '
  <li style="float:right"> <a href="LibreriaDipendente.php">Libreria</a></li>
  <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
  <li style="float:right"> <a href="ProfiloDipendente.php">Profilo</a></li>
  </ul>
  </div>
  <h2>Libreria:</h2>
  <center>
  <h3>Novità (ultime opere inserite)<h3>
  </center>
  ';
}else
  echo '
  <li style="float:right"> <a href="LibreriaUtente.php">Libreria</a></li>
  <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
  <li style="float:right"> <a href="ProfiloUtente.php">Profilo</a></li>
  </ul>
  </div>
  <h2>Libreria:</h2>
  <center>
  <h3>Novità (ultime opere inserite)<h3>
  </center>
  ';

include 'ConnessioneServer.php';

$query ="
			SELECT *
			FROM opera
			JOIN autore ON autore.idautore=opera.idautore
			ORDER BY opera.idopera DESC
			LIMIT 3
			";

// eseguo la query
$result=pg_query($db, $query);

if(!$result) {
  echo pg_last_error($db);
  exit;
}else{
  echo "<center><table>";
  echo "<tr><td><p>TITOLO</p></td>  <td><p>ANNO</p></td>  <td><p>AUTORE</p></td> </tr>";
  while($row = pg_fetch_array($result)) {

      $titolo = $row['titolo'];
      $annopub = $row['annopub'];
      $autore = $row['nome']." ".$row['cognome'];


      echo "<tr><form  method='POST' action='richiediPrestito.php'>
      <td>".$titolo."<input name=titolo type=hidden value='".$titolo."'></td>
      <td>".$annopub."<input name=annopub type=hidden value='".$annopub."'></td>
      <td>".$autore."<input name=autore type=hidden value='".$autore."'></td>
      </form></tr>";
  }
  echo "</table></center>";
}

pg_close($db);
 ?>
		</body>
</html>
