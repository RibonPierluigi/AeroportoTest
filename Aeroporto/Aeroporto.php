<?php
$errore="";
$end="falso";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if($_POST["secret"]=="reg")
	{
		$end="mod1";
		$file=fopen("Temp.csv","w");
		fputcsv($file,array($_POST["mail"],$_POST["password"]));
		fclose($file);
	}
	elseif($_POST["secret"]=="acc")
	{
		if(!filter_var($_POST["mail"],FILTER_VALIDATE_EMAIL))
		{
			$file=fopen("SuperUtente.csv","r");
			$super=fgetcsv($file);
			while(!feof($file))
			{
				if($super[0]==$_POST["mail"] && $super[1]==$_POST["password"])
					$end="modS";
				$super=fgetcsv($file);
			}
		}
		else
		{
			if(preg_match("/^[A-Z a-z0-9]*$/",$_POST["password"]))
			{
				if(file_exists("Counter.csv"))
				{
					$file=fopen("Counter.csv","r");
					$arr=fgetcsv($file);
					fclose($file);
					$file=fopen("RegistroUtenti.csv","r");
					$save=0;
					for($i=0;$i<($arr[0]-2);$i++)
					{
						$ya=fgetcsv($file);
						if($ya[5]==$_POST["mail"] && $ya[6]==$_POST["password"])
						{
							$end="mod2";
							$save=$i+2;
						}
					}
					fclose($file);
					if($save!=0)
					{
					$file=fopen("CounterCorrente.csv","w");
					fputcsv($file,array($save));
					fclose($file);
					}
				}
			}
		}
		if($end=="falso")
		{
			$errore="Errore nell'inserimento della mail o password";
			$end="end";
		}
	}
}
if(file_exists("Tempo.csv"))
	@unlink("Tempo.csv");
if(file_exists("Sblocco.csv"))
	@unlink("Sblocco.csv");
if(file_exists("Tempor.csv"))
	@unlink("Tempor.csv");
if($_SERVER["REQUEST_METHOD"]!="POST")
	if(file_exists("CounterCorrente.csv"))
		@unlink("CounterCorrente.csv");
if($_SERVER["REQUEST_METHOD"]!="POST")
	if(file_exists("Temp.csv"))
		@unlink("Temp.csv");
?>
<html>
<head>
<title>Transylvania Airport</title>
<link rel="stylesheet" type="text/css" href="Aeroporto.css">
<script>
function registrazione()
{
	document.getElementById('Registrati').style.display="block";
	document.getElementById('Accedi').style.display="none";
}
function accedi()
{
	document.getElementById('Registrati').style.display="none";
	document.getElementById('Accedi').style.display="block";
}
</script>
</head>
<body>
<div id="div1"><h1 id="h1Stile">Transylvania Airport</h1></div>
<div id="div2">
	<div id="Start">
		<h4 style="margin-bottom:10px;margin-top:50px;color:yellow;">Per poter entrare nel sistema bisogna <button type="button" id="link" onclick="registrazione()">registrare</button> un account.</h4>
		<h4 style="color:yellow;">In caso ne possiedi gia' uno puoi <button type="button" id="link" onclick="accedi()">accedere</button>.</h4>
		<div id="Registrati" class="Register">
			<form method="POST">
			Mail<br>
			<input type="textbox" name="mail" placeholder="example@gmail.com" required="true"><br>
			Password<br>
			<input type="textbox" name="password" placeholder="********" required="true" maxlength="8"><br><br>
			<input type="hidden" name="secret" value="reg">
			<input type="submit" value="Conferma" id="link">
			</form>
		</div>
		<div id="Accedi" class="Login">
			<form method="POST">
			Mail<br>
			<input type="textbox" name="mail" placeholder="example@gmail.com" required="true"><br>
			Password<br>
			<input type="textbox" name="password" placeholder="********" required="true"  maxlength="8"><br><br>
			<input type="hidden" name="secret" value="acc">
			<input type="submit" value="Conferma" id="link" onclick="ControlloAccount()">
			<p style="color:darkred"><?php echo $errore;?></p>
			</form>
		</div>
	</div>
	<div id="NormalUtente" class="Utente" style="margin-top:80px">
			<h3><a target="frame" href="VisualizzaAccount.php" id="lin">Visualizza Profilo</a></h3><br>
			<h3><a target="frame" href="ModificaAccount.php" id="lin">Modifica Profilo</a></h3><br>
			<h3><a target="frame" href="PrenotaVolo.php" id="lin">Prenota un Volo</a></h3><br>
			<h3><a target="frame" href="EliminaPrenotazione.php" id="lin">Elimina Prenotazione</a></h3>
	</div>
	<div id="SuperUtente" class="Utente" style="margin-top:120px">
			<h3><a target="frame" href="AggiungiVolo.php" id="lin">Aggiungi un volo</a></h3><br>
			<h3><a target="frame" href="VisualizzaVoli.php" id="lin">Visualizza i voli</a></h3><br>
			<h3><a target="frame" href="EliminaVoli.php" id="lin">Elimina un volo</a></h3>
	</div>
</div>
<div id="div3">
	<iframe name="frame" src="aereo.jpg" id="item" style="height:100%; width:100%; background-color:lightgray;"></iframe>
</div>
<div id="div1"></div>
<script>
var name = <?php echo json_encode($end); ?>;
if(name == "mod1")
{
	document.getElementById('item').src="CompletaAccount.php";
	document.getElementById('Start').style.display="none";
	document.getElementById('NormalUtente').style.display="block";
}
if(name == "mod2")
{
	document.getElementById('item').src="Successo.php";
	document.getElementById('Start').style.display="none";
	document.getElementById('NormalUtente').style.display="block";
}
if(name == "modS")
{
	document.getElementById('Start').style.display="none";
	document.getElementById('SuperUtente').style.display="block";
}
if(name == "end")
{
	document.getElementById('Accedi').style.display="block";
}
</script>
</body>
</html>