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

		<li style="float:right"> <a href="LibreriaDipendente.php">Libreria</a></li>
		<li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
		<li style="float:right"> <a href="ProfiloDipendente.php">Profilo</a></li>


	</ul>

       </div>




<div id="Sidebar">

<h3>Profilo Dipendente: </h3> <br>

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
      echo "Data Registrazione: ".$row['dataregistrazione']."<br><br>";
    }

?>


	<form method="get" action="CompletaProfiloGriglia.php">
    <button type="submit">Modifica Profilo</button>
</form>


	</div>

	<div id="tabelle">


	<?php


    //-------------------------------------------------------------------------------------------------
    //Ricerca dei prestiti in attesa di accettazione
    echo "<center><br><br><h2>Prestiti in Attesa di Accettazione</h2></center>";
    $queryaccettazioneprestiti="
        SELECT *
        FROM prestito
				JOIN copia ON prestito.numeroreg=copia.numeroreg
        WHERE accettato='FALSE'
    ";

    $resultaccettazioneprestiti=pg_query($db, $queryaccettazioneprestiti);

    if(!$resultaccettazioneprestiti) {
      echo pg_last_error($db);
      exit;
    }else{
      echo "<center><table>";
      echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td>  <td>ACCETTA</td>  <td>RIFIUTA</td>   </tr>";
      while($row = pg_fetch_array($resultaccettazioneprestiti)) {

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



          echo "<tr><form  method='POST' action='AccettazionePrestito.php'>
          <td>".$usernameACC."<input name=usernameACC type=hidden value='".$usernameACC."'></td>
          <td>".$numeroregACC."<input name=numeroregACC type=hidden value='".$numeroregACC."'></td>
          <td>".$titoloACC."<input name=titoloACC type=hidden value='".$titoloACC."'></td>
					<td>".$edizioneACC."<input name=edizioneACC type=hidden value='".$edizioneACC."'></td>
          <td><input type='submit' name=azione value='Accetta'></td>
          <td><input type='submit' name=azione value='Rifiuta'></td>
          </form></tr>";
      }
      echo "</table> </center> <br><br>";
    }


    //----------------------------------------------------------------------------------------------

    //Ricerca dei prestiti in attesa di restituzione
    echo "<center><br><br><h2>Prestiti in Attesa di Restituzione</h2></center>";
    $queryelencoprestiti="
        SELECT *
        FROM prestito
				JOIN copia ON prestito.numeroreg=copia.numeroreg
        WHERE accettato='TRUE' AND datariconsegna IS NULL
    ";

    $resultelencoprestiti=pg_query($db, $queryelencoprestiti);

    if(!$resultelencoprestiti) {
      echo pg_last_error($db);
      exit;
    }else{
      echo "<center><table>";
      echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td>  <td>DATA INIZIO</td>  <td>DATA SCADENZA</td>  <td></td>   </tr>";
      while($row = pg_fetch_array($resultelencoprestiti)) {

          $usernameRES = $row['username'];
          $numeroregRES = $row['numeroreg'];
					$datainizioRES = $row['datainizio'];
					$edizioneRES = $row['edizione'];

					$queryCERCATIPOUTENTE="
								select tipo
								from utente
								where username='$usernameRES'
					";
					$resultCERCATIPOUTENTE=pg_query($db, $queryCERCATIPOUTENTE);
					if(!$resultCERCATIPOUTENTE){
						echo pg_last_error($db);
						exit;
					}else
						//Prende la cella 0,0 del risultato resultcercalibro
						$tipoutenteRES=pg_fetch_result($resultCERCATIPOUTENTE, 0, 0);



					if(strcmp($tipoutenteRES,"studente    ")==0){
					  $datariconsegna=date( "Y-m-d", strtotime( "$datainizioRES +2 month" ) );
					}

					if(strcmp($tipoutenteRES,"docente     ")==0){
					  $datariconsegna=date( "Y-m-d", strtotime( "$datainizioRES +3 month" ) );
					}

					if(strcmp($tipoutenteRES,"altro       ")==0){
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



          echo "<tr><form  method='POST' action='RestituzionePrestito.php'>
          <td>".$usernameRES."<input name=usernameRES type=hidden value='".$usernameRES."'></td>
          <td>".$numeroregRES."<input name=numeroregRES type=hidden value='".$numeroregRES."'></td>
          <td>".$titoloRES."<input name=titoloRES type=hidden value='".$titoloRES."'></td>
					<td>".$edizioneRES."<input name=edizioneRES type=hidden value='".$edizioneRES."'></td>
          <td>".$datainizioRES."<input name=UsernameDIP type=hidden value='".$datainizioRES."'></td>
					<td>".$datariconsegna."<input name=UsernameDIP type=hidden value='".$datariconsegna."'></td>
          <td><input type='submit' name=azioneRES value='Restituito'></td>
          </form></tr>";
      }
      echo "</table></center>";
    }




		//----------------------------------------------------------------------------------------------

		//Ricerca dei prestiti scaduti
		echo "<center><br><br><h2>Prestiti Scaduti</h2></center>";
		$queryelencoprestitiB="
				SELECT *
				FROM prestito
				JOIN copia ON prestito.numeroreg=copia.numeroreg
				WHERE accettato='TRUE' AND datariconsegna IS NULL
		";

		$resultelencoprestitiB=pg_query($db, $queryelencoprestitiB);

		if(!$resultelencoprestitiB) {
			echo pg_last_error($db);
			exit;
		}else{
			echo "<center><table>";
			echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td>  <td><p>EDIZIONE</p></td>  <td>SCADUTO IL</td>  </tr>";
			while($row = pg_fetch_array($resultelencoprestitiB)) {

					$usernameSCAD = $row['username'];
					$numeroregSCAD = $row['numeroreg'];
					$datainizioSCAD = $row['datainizio'];
					$edizioneSCAD = $row['edizione'];

					$queryCERCATIPOUTENTE="
								select tipo
								from utente
								where username='$usernameSCAD'
					";
					$resultCERCATIPOUTENTE=pg_query($db, $queryCERCATIPOUTENTE);
					if(!$resultCERCATIPOUTENTE){
						echo pg_last_error($db);
						exit;
					}else
						//Prende la cella 0,0 del risultato resultcercalibro
						$tipoutenteSCAD=pg_fetch_result($resultCERCATIPOUTENTE, 0, 0);

					if(strcmp($tipoutenteSCAD,"studente    ")==0){
					  $datariconsegnaB=date( "Y-m-d", strtotime( "$datainizioSCAD +2 month" ) );
					}

					if(strcmp($tipoutenteSCAD,"docente     ")==0){
					  $datariconsegnaB=date( "Y-m-d", strtotime( "$datainizioSCAD +3 month" ) );
					}

					if(strcmp($tipoutenteSCAD,"altro       ")==0){
					  $datariconsegnaB=date( "Y-m-d", strtotime( "$datainizioSCAD +2 week" ) );
					}

					$today = date("Y-m-d");

					if($datariconsegnaB<$today){

								//Query prelevamento titolo del libro iesimo
								$querycercalibroB="
									SELECT titolo
									FROM copia JOIN opera ON copia.idopera=opera.idopera
									WHERE numeroreg='$numeroregSCAD'
								";

								$resultcercalibroB=pg_query($db, $querycercalibroB);
								if(!$resultcercalibroB){
									echo pg_last_error($db);
									exit;
								}else
									//Prende la cella 0,0 del risultato resultcercalibro
									$titoloSCAD=pg_fetch_result($resultcercalibroB, 0, 0);

//prove colore

								echo "<tr class='odd'><form  method='POST' action='RestituzionePrestito.php'>
								<td>".$usernameSCAD."</td>
								<td>".$numeroregSCAD."</td>
								<td>".$titoloSCAD."</td>
								<td>".$edizioneSCAD."</td>
								<td>".$datariconsegnaB."</td>
								</form></tr>";
				 }
			}
			echo "</table></center>";
		}

		//----------------------------------------------------------------------------------------------
		//----------------------------------------------------------------------------------------------
		//Libri restituiti

		echo "<center><br><br><h2>Storico Prestiti</h2></center>";
		$queryelencorestituiti="
				SELECT *
				FROM prestito
				JOIN copia ON prestito.numeroreg=copia.numeroreg
				WHERE accettato='TRUE' AND datariconsegna IS NOT NULL
		";

		$resultelencorestituiti=pg_query($db, $queryelencorestituiti);

		if(!$resultelencorestituiti) {
			echo pg_last_error($db);
			exit;
		}else{
			echo "<center><table>";
			echo "<tr>   <td><p>UTENTE</p></td>  <td><p>NUMERO REG</p></td>  <td><p>TITOLO</p></td> <td><p>EDIZIONE</p></td>  <td><p>DATA INIZIO</p></td> <td><p>DATA FINE</p></td>  </tr>";
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
					</form></tr>";
			}
			echo "</table></center>";
		}


 ?>
	</div>
	</body>
</html>
