

<?php
session_start();

if (isset($_SESSION["username"])){
    if($_SESSION["tipo"]=="dipendente")
        header("Location: ProfiloDipendente.php");
    else
        if($_SESSION["tipo"]!=null)
          header("Location: ProfiloUtente.php");

}else
session_unset();
{
?>
<html>
	<head>
		<link href="css/style.css" rel="stylesheet">
	</head>
<body>
	<!-- Prove navbar -->
		<div>
			<form action="Autenticazione.php" method="POST">
	<ul>
		<!--<h1 align="left"><span><a>Biblioteca</a></span></h1>-->
		<li><h1>Biblioteca</h1></li>
		
		<li style="float:right; padding-top: 25px; padding-left: 2px"><input type="reset" value="Cancella"></li>
		<li style="float:right; padding-top: 25px; padding-left: 2px"><input type="submit" value="OK"></li>
		
		<li style="float:right; padding-top: 25px; padding-left: 5px"><input type="password" name="pwd" maxlength="10" ></li>
		<li style="float:right; padding-top: 25px; padding-left: 15px"><label for="pass">Password</label></li>
		
		<li style="float:right; padding-top: 25px; padding-left: 5px"><input type="text" name="username" maxlength="60" value="Email" onfocus="if (this.value=='Email') this.value='';" ></li>
		<li style="float:right; padding-top: 25px"><label for="username">Username</label></li>
		
		
		
	</ul>
			</form>
       </div>   
  
      
 <div id="img"> <img src="img/libro.jpeg"></div> 

<div id="reg">
<fieldset ><legend>Registration Form</legend>
<form action="registrazione.php" method="POST" >
<table border="0">
<tr>
<td>Nome</td><td> <input type="text" name="nome"></td>
</tr>

<tr>
<td>Cognome</td><td> <input type="text" name="cognome"></td>
</tr>

<tr>
<td>Telefono</td><td> <input type="tel" name="telefono"></td>
</tr>

<tr>
<td>Email</td><td> <input type="text" name="email"></td>
</tr>
<!-- Per  -->
<tr>
<td>Password</td><td> <input type="password" name="pwd"></td>
</tr>

<tr>
<td>Tipologia account:</td><td>
<input type="radio" name="tipo" value="dipendente" checked>Dipendente
<input type="radio" name="tipo" value="docente" checked>Docente
<input type="radio" name="tipo" value="studente" checked>Studente
<input type="radio" name="tipo" value="altro" checked>Altro
</td>
</tr>

<tr>
<td><input type="submit" value="OK"> <input type="reset" value="Cancella"></td>

</tr>

</table>
</form>
</fieldset>
</div>

</body>
</html>
<?php
}
?>
