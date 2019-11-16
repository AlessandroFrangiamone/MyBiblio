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

	 <div id="sidebar" >
		 <h3>Profilo Utente: </h3> <br>
<?php
  session_start();

  include 'ConnessioneServer.php';

  $user=$_SESSION["username"];

  $queryDati= "
      SELECT *
      FROM utente
      WHERE username = '$user'; ";

  $resultDati=pg_query($db, $queryDati);

  if(!$resultDati) {
    echo pg_last_error($db);
    exit;
  }else
    while($row = pg_fetch_array($resultDati)) {
      echo "Nome: ".$row['nome']."<br><br>";
      echo "Cognome: ".$row['cognome']."<br><br>";
      echo "Telefono: ".$row['telefono']."<br><br>";
      echo "Numero Tessera: ".$row['ntessera']."<br><br>";
      echo "Data Registrazione: ".$row['dataregistrazione']."<br><br>";
    }

 ?>


<form method="get" action="CompletaProfiloGriglia.php">
<button type="submit">Modifica Profilo</button>
</form>

</div> <!-- chiusura sidebar-->

		<div id="tabelle" > <!--pagina tabelle-->
	<?php

	$user=$_SESSION["username"];


	//-------------------------------------------------------------------------------------------------
	//-------------------------------------------------------------------------------------------------
	//Libri in attesa di accettazione
	echo "<center><br><br><br><h2>Libri in Attesa di Accettazione</h2></center>";
	$queryaccettazionelibri="
			SELECT *
			FROM prestito
			JOIN copia ON prestito.numeroreg=copia.numeroreg
			WHERE accettato='FALSE' AND username='$user'
	";

	$resultaccettazionelibri=pg_query($db, $queryaccettazionelibri);

	if(!$resultaccettazionelibri) {
		echo pg_last_error($db);
		exit;
	}else{
		echo "<center><table>";
		echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td></tr>";
		while($row = pg_fetch_array($resultaccettazionelibri)) {

				$usernameACC = $row['username'];
				$numeroregACC = $row['numeroreg'];
				$edizioneACC = $row['edizione'];

				//Query prelevamento titolo del libro iesimo
				$querycercalibro="
					SELECT titolo
					FROM copia JOIN opera ON copia.idopera=opera.idopera
					WHERE numeroreg='$numeroregACC'
				";

				$resultcercalibro=pg_query($db, $querycercalibro);
				if(!$resultcercalibro){
					echo pg_last_error($db);
					exit;
				}else
					//Prende la cella 0,0 del risultato resultcercalibro
					$titoloACC=pg_fetch_result($resultcercalibro, 0, 0);



				echo "<tr>
				<td>".$usernameACC."<input name=usernameACC type=hidden value='".$usernameACC."'></td>
				<td>".$numeroregACC."<input name=numeroregACC type=hidden value='".$numeroregACC."'></td>
				<td>".$titoloACC."<input name=titoloACC type=hidden value='".$titoloACC."'></td>
				<td>".$edizioneACC."<input name=edizioneACC type=hidden value='".$edizioneACC."'></td>
				</tr>";
		}
		echo "</table> </center> <br><br>";
	}


	//----------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------
	//libri in attesa di restituzione
	echo "<center><br><br><h2>Libri in Attesa di Restituzione</h2></center>";
	$queryelencoprestiti="
			SELECT *
			FROM prestito
			JOIN copia ON prestito.numeroreg=copia.numeroreg
			WHERE accettato='TRUE' AND datariconsegna IS NULL AND username='$user'
	";

	$resultelencoprestiti=pg_query($db, $queryelencoprestiti);

	if(!$resultelencoprestiti) {
		echo pg_last_error($db);
		exit;
	}else{
		echo "<center><table>";
		echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td>  <td><p>DATA INIZIO</p></td>  <td><p>DATA SCADENZA</p></td>  </tr>";
		while($row = pg_fetch_array($resultelencoprestiti)) {

				$usernameRES = $row['username'];
				$numeroregRES = $row['numeroreg'];
				$datainizioRES = $row['datainizio'];
				$edizioneRES = $row['edizione'];

				//Controllo tipologia utente per ricavarne la data massima di riconsegna
				if(strcmp($_SESSION["tipo"],"studente    ")==0){
				  $datariconsegna=date( "Y-m-d", strtotime( "$datainizioRES +2 month" ) );
				}

				if(strcmp($_SESSION["tipo"],"docente     ")==0){
				  $datariconsegna=date( "Y-m-d", strtotime( "$datainizioRES +3 month" ) );
				}

				if(strcmp($_SESSION["tipo"],"altro       ")==0){
				  $datariconsegna=date( "Y-m-d", strtotime( "$datainizioRES +2 week" ) );
				}

				//Query prelevamento titolo del libro iesimo
				$querycercalibro="
					SELECT titolo
					FROM copia JOIN opera ON copia.idopera=opera.idopera
					WHERE numeroreg='$numeroregRES'
				";

				$resultcercalibro=pg_query($db, $querycercalibro);
				if(!$resultcercalibro){
					echo pg_last_error($db);
					exit;
				}else
					//Prende la cella 0,0 del risultato resultcercalibro
					$titoloRES=pg_fetch_result($resultcercalibro, 0, 0);



				echo "
				<tr>
				<td>".$usernameRES."<input name=usernameRES type=hidden value='".$usernameRES."'></td>
				<td>".$numeroregRES."<input name=numeroregRES type=hidden value='".$numeroregRES."'></td>
				<td>".$titoloRES."<input name=titoloRES type=hidden value='".$titoloRES."'></td>
				<td>".$edizioneRES."<input name=edizioneRES type=hidden value='".$edizioneRES."'></td>
				<td>".$datainizioRES."<input name=datainizioRES type=hidden value='".$datainizioRES."'></td>
				<td>".$datariconsegna."<input name=titoloRES type=hidden value='".$datariconsegna."'></td>
				</tr>";
		}
		echo "</table></center>";
	}


	//----------------------------------------------------------------------------------------------
	//----------------------------------------------------------------------------------------------
	//Libri restituiti

	echo "<center><br><br><h2>Libri restituiti</h2></center>";
	$queryelencorestituiti="
			SELECT *
			FROM prestito
			JOIN copia ON prestito.numeroreg=copia.numeroreg
			WHERE accettato='TRUE' AND datariconsegna IS NOT NULL AND username='$user'
	";

	$resultelencorestituiti=pg_query($db, $queryelencorestituiti);

	if(!$resultelencorestituiti) {
		echo pg_last_error($db);
		exit;
	}else{
		echo "<center><table>";
		echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td>  <td><p>DATA INIZIO</p></td> <td><p>DATA FINE</p></td>  </tr>";
		while($row = pg_fetch_array($resultelencorestituiti)) {

				$usernameF_RES = $row['username'];
				$numeroregF_RES = $row['numeroreg'];
				$datainizioF_RES = $row['datainizio'];
				$datariconsegnaF_RES = $row['datariconsegna'];
				$edizioneF_RES = $row['edizione'];

				//Query prelevamento titolo del libro iesimo
				$querycercalibro="
					SELECT titolo
					FROM copia JOIN opera ON copia.idopera=opera.idopera
					WHERE numeroreg='$numeroregF_RES'
				";

				$resultcercalibro=pg_query($db, $querycercalibro);
				if(!$resultcercalibro){
					echo pg_last_error($db);
					exit;
				}else
					//Prende la cella 0,0 del risultato resultcercalibro
					$titoloF_RES=pg_fetch_result($resultcercalibro, 0, 0);



				echo "<tr><form  method='POST' action='ValutazioneLibro.php'>
				<td>".$usernameF_RES."<input name=usernameF_RES type=hidden value='".$usernameF_RES."'></td>
				<td>".$numeroregF_RES."<input name=numeroregF_RES type=hidden value='".$numeroregF_RES."'></td>
				<td>".$titoloF_RES."<input name=titoloF_RES type=hidden value='".$titoloF_RES."'></td>
				<td>".$edizioneF_RES."<input name=edizioneF_RES type=hidden value='".$edizioneF_RES."'></td>
				<td>".$datainizioF_RES."<input name=datainizioF_RES type=hidden value='".$datainizioF_RES."'></td>
				<td>".$datariconsegnaF_RES."<input name=datariconsegnaF_RES type=hidden value='".$datariconsegnaF_RES."'></td>
				<td><input type='submit' value='Valuta'></td>
				</form></tr>";
		}
		echo "</table></center>";
	}

	?>
		</div>
	</body>
</html>
