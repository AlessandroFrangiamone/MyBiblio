
<html>
<head>

<link href="css/style.css" rel="stylesheet">

</head>
<body>

<div>
<ul>

  <li><h1>Biblioteca</h1></li>

  <li style="float:right"><a class="active" href="index.php">Torna alla Hompage</a>   </li>

</ul>
</div>

<?php
session_start();
// Lettura da variabili globali dei valori passati in post
   $user  = $_POST["username"];
   $pwd = $_POST["pwd"];

    include 'ConnessioneServer.php';

$query =<<<EOF
      SELECT * from utente where username='$user' and pwd='$pwd';
EOF;

$result=pg_query($db, $query);
if(!$result) {
      echo pg_last_error($db);
      exit;

}else{
	while($row = pg_fetch_array($result)) {
		  echo "Bentornato signor ". $row[3] . " ". $row[2].",<br><br>";
      $_SESSION["username"]=$user;
      $_SESSION["pwd"]=$pwd;
      $_SESSION["nome"]=$row[2];
      $_SESSION["cognome"]=$row[3];
      $_SESSION["tipo"]=$row[13];
      if(strcmp($_SESSION["tipo"],"dipendente  ")==0){
        header("Location: ProfiloDipendente.php");
        exit;
      }else{
        header("Location: ProfiloUtente.php");
        exit;
      }
	}
  echo "Errore di inserimento email o password errate.";
}


// chiudo la connessione
pg_close($db);

?>
