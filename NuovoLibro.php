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

	</ul>

       </div>


<div id="Inserimento">
<fieldset style="width:30%"><legend>Inserimento Nuovo Libro</legend>
<form action="NuovoLibroInserimento.php" method="POST" >
<table border="0">
<tr>
<td>Titolo</td><td> <input type="text" name="titolo"></td>
</tr>

<tr>
<td>Codice ISBN</td><td> <input type="text" name="codisbn"></td>
</tr>

<tr>
<td>Nome Autore</td><td> <input type="tel" name="nomea"></td>
</tr>

<tr>
<td>Cognome Autore</td><td> <input type="text" name="cognomea"></td>
</tr>
<!-- Per  -->
<tr>
<td>Nome Casa Editrice</td><td> <input type="text" name="nomece"></td>
</tr>

<tr>
<td>Lingua Originale</td><td><input type="text" name="linguaorig"></td>
</tr>

<tr>
<td>Lingua Copia</td><td> <input type="text" name="linguacopia"></td>
</tr>

<tr>
<td>Anno Pubblicazione</td><td> <input type="text" name="annopub"></td>
</tr>

<tr>
<td>Anno Stampa</td><td> <input type="text" name="annostampa"></td>
</tr>

<tr>
<td>Numero Edizione</td><td> <input type="text" name="nedizione"></td>
</tr>

<tr>
<td>Sezione</td><td> <input type="text" name="sezione"></td>
</tr>

<tr>
<td>Scaffale</td><td> <input type="text" name="scaffale"></td>
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
