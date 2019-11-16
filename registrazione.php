
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
// Lettura da variabili globali dei valori passati in post

    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $telefono = $_POST["telefono"];
    $username  = $_POST["email"];
    $pwd = $_POST["pwd"];
    $tipo = $_POST['tipo'];

   include 'ConnessioneServer.php';

   $data = date('Y-m-d');

$query =<<<EOF
  INSERT INTO utente (username,pwd,nome,cognome,telefono,dataregistrazione,tipo)
  VALUES ('$username','$pwd','$nome','$cognome','$telefono','$data','$tipo');
EOF;

$result=pg_query($db, $query);

if(!$result) {
      echo pg_last_error($db);
      exit;
}else
  echo "Complimenti, ti sei registrato";


pg_close($db);

?>

<br><br>
<form method="get" action="disconnetti.php">
    <button type="submit">Homepage</button>
</form>
</body>
</html>
