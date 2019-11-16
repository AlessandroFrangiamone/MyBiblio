<HTML>
	<head>
	<link href="css/style.css" rel="stylesheet">
	</head>

<Body>

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
        ';
      }else
        echo '
        <li style="float:right"> <a href="LibreriaUtente.php">Libreria</a></li>
				<li style="float:right"> <a href="NewsLibri.php">Novità</a></li>
        <li style="float:right"> <a href="ProfiloUtente.php">Profilo</a></li>
        ';
    ?>


	</ul>
       </div>

    <form action="CompletaProfilo.php" method="post" >

            <fieldset>
                <legend>Informazioni personali:</legend>

                Sesso: <br>
            <input type="radio" name="sex" value="M" checked>Maschio

            <input type="radio" name="sex" value="F">Femmina <br>

                Luogo di nascita:<br>
                <input type="text" name="luogonascita" value="luogonascita" onfocus="if (this.value=='luogonascita') this.value='';">
                <br>

                Data di nascita: <br>
                <input type="date" name="datanascita" value="gg-mm-aaaa" onfocus="if (this.value=='gg-mm-aaaa') this.value='';">
                <br>

                <fieldset>
                <legend> Residenza:
                    </legend>
                    Citta':<br>
                <input type="text" name="citta" value="citta" onfocus="if (this.value=='citta') this.value='';">
                <br>
                    Provincia:<br>
                <input type="text" name="provincia" value="provincia" onfocus="if (this.value=='provincia') this.value='';">
                <br>
                    Stato:<br>
                <input type="text" name="stato" value="stato" onfocus="if (this.value=='stato') this.value='';">
                <br>

                </fieldset>
        </fieldset>


    <input type="submit" value="Invio">

    </form>

</Body>


</HTML>
