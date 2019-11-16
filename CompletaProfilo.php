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

		<li style="float:right"><a class="active" href="disconnetti.php">Disconnetti</a></li>

<?php
    session_start();
    if(strcmp($_SESSION["tipo"],"dipendente  ")==0){
      echo '
      <li style="float:right"> <a href="LibreriaDipendente.php">Libreria</a></li>
      <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
      <li style="float:right"> <a href="ProfiloDipendente.php">Profilo</a></li>
      </ul>
      </div>
      ';
    }else
      echo '
      <li style="float:right"> <a href="LibreriaUtente.php">Libreria</a></li>
      <li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
      <li style="float:right"> <a href="ProfiloUtente.php">Profilo</a></li>
      </ul>
      </div>
      ';

  $sesso = $_POST["sex"];
  $luogonascita = $_POST["luogonascita"];
  $datanascita = date("Y-m-d", strtotime($_POST["datanascita"]));
  $citta = $_POST["citta"];
  $provincia = $_POST["provincia"];
  $stato = $_POST["stato"];

  include 'ConnessioneServer.php';

  $user=$_SESSION["username"];

  $query ="
                UPDATE utente
                SET sesso = '".$sesso."', luogonascita = '".$luogonascita."', datanascita = '".$datanascita."', citta = '".$citta."', provincia = '".$provincia."', stato = '".$stato."'
                WHERE username='".$user."'";

  echo $query . "<br><br>";

  $result=pg_query($db, $query);

  if(!$result) {
        echo pg_last_error($db);
        exit;
  }else{
  	  if(strcmp($_SESSION["tipo"],"dipendente  ")==0){
        header("Location: ProfiloDipendente.php");
        exit;
      }else{
        header("Location: ProfiloUtente.php");
        exit;
      }
  }

  pg_close($db);



?>
</body>
</html>
