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

$username=$_POST["usernameF_RES"];
$numeroreg=$_POST["numeroregF_RES"];
$titolo=$_POST["titoloF_RES"];
$datainizio=$_POST["datainizioF_RES"];
$datariconsegna=$_POST["datariconsegnaF_RES"];

include 'ConnessioneServer.php';

pg_close($db);
 ?>

 <h4>Giudizio (min 1, max 10)</h4>
 <form  method="POST" action="InvioRecensione.php">

 <input name="username" type=hidden value="<?php echo $username?>">
 <input name="numeroreg" type=hidden value="<?php echo $numeroreg?>">
 <input name="titolo" type=hidden value="<?php echo $titolo?>">
 <input name="datainizio" type=hidden value="<?php echo $datainizio?>">
 <input name="datariconsegna" type=hidden value="<?php echo $datariconsegna?>">

 <input name="giudizio" type=text><br><br>
 <h4>Commento (max 100 caratteri)</h4>
 <textarea name=commento > </textarea>

 <input type="submit" value="Invia">

 </form>
</body>
</html>
