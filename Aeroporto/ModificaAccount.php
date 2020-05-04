<?php
if(file_exists("Sblocco.csv"))
{
	$fil=fopen("Sblocco.csv","r");
	$arr=fgetcsv($fil);
	if($arr[0]==false)
		$sblocco=false;
	else
		$sblocco=true;
	fclose($fil);
}
else
	$sblocco=false;
$controllo=false;
$NomErr=$CognomeErr="";
if(file_exists("Tempo.csv"))
{
	$controllo=true;
	if($_SERVER["REQUEST_METHOD"]=="POST" && $sblocco==false)
	{
		$file=fopen("Tempo.csv","r");
		$ar=fgetcsv($file);
		if($ar[5]==$_POST["password"])
		{
			$fil=fopen("Sblocco.csv","w");
			fputcsv($fil,array(true));
			$sblocco=true;
			fclose($fil);
		}
		else
		{
			$fil=fopen("Sblocco.csv","w");
			fputcsv($fil,array(false));
			fclose($fil);
		}
		fclose($file);
		$_SERVER["REQUEST_METHOD"]="";
	}
	$file=fopen("Tempo.csv","r");
	$ar=fgetcsv($file);
	fclose($file);
	if($_SERVER["REQUEST_METHOD"]=="POST" && $sblocco==true)
	{
		if(!preg_match("/^[A-Z a-z]*$/",$_POST["Nome"]))
			$NomErr="Formato non corretto nel nome";
		if(!preg_match("/^[A-Z a-z]*$/",$_POST["Cognome"]))
			$CognomeErr="Formato non corretto nel cognome";
		if($CognomeErr=="" && $NomErr=="")
		{
			$fi=fopen("Tempo.csv","w");
			fputcsv($fi,array($_POST["Nome"],$_POST["Cognome"],$_POST["Sesso"],$_POST["Data"],$ar[4],$ar[5]));
			fclose($fi);
			$fi=fopen("CounterCorrente.csv","r");
			$yarra=fgetcsv($fi);
			fclose($fi);
			$fi=fopen("Counter.csv","r");
			$y=fgetcsv($fi);
			fclose($fi);
			if($y[0]==$yarra[0])
			{
				$fi=fopen("RegistroUtenti.csv","r+");
				for($i=0;$i<($yarra[0]-2);$i++)
				{
					$yarr=fgetcsv($fi);
				}
				$a=($yarra[0]-1).",".$_POST["Nome"].",".$_POST["Cognome"].",".$_POST["Sesso"].",".$_POST["Data"].",".$ar[4].",".$ar[5];
				fwrite($fi,$a);
				fclose($fi);
			}
			else
			{
				$file=fopen("RegistroUtenti.csv","r");
				$fil=fopen("Oenaropmet.csv","w");
				$i;
				for($i=0;$i<($yarra[0]-2);$i++)
					{
					$vett=fgetcsv($file);
					fputcsv($fil,$vett);
					}
				fgetcsv($file);
				fputcsv($fil,array(($yarra[0]-1),$_POST["Nome"],$_POST["Cognome"],$_POST["Sesso"],$_POST["Data"],$ar[4],$ar[5]));
				for(;$i<($y[0]-2);$i++)
					{
					$vett=fgetcsv($file);
					fputcsv($fil,$vett);
					}
				fclose($file);
				fclose($fil);
				@unlink("RegistroUtenti.csv");
				rename("Oenaropmet.csv", "RegistroUtenti.csv");
			}
			echo "<h1>Operazione completata correttamente!</h1>";
			@unlink("Sblocco.csv");
			die();
		}
	}
}
else
{
	$controllo=false;
	echo "<h3>Errore!Account inesistente!</h3>";
	echo "<h2>Provi a riavviare la pagina</h2>";
}
?>

<html>
<body>
<?php
if($controllo==true && $sblocco==false)
{
	echo "<h2 style='margin-bottom:10px;'>Modifica Account</h2><br>";
	echo "<form method='POST' action='".$_SERVER['PHP_SELF']."'>";
	echo "Per sicurezza reinserisca la password:<br>";
	echo "<input type='textbox' placeholder='********' name='password' required='true' maxlength='8'>";
	echo "<input type='submit' value='Conferma'><br>";
	echo "</form>";
}
if($sblocco==true)
{
	echo "<h2 style='margin-bottom:10px;'>Completamento Modifica</h2><br>";
	echo "<form method='POST' action='".$_SERVER['PHP_SELF']."'>";
	if($NomErr!="" && $CognomeErr!="")
		echo "<span style='color:red;padding-left:0px;'>".$NomErr."</span><span style='color:red;padding-left:25px;'>".$CognomeErr."</span><br><br>";
	elseif($NomErr!="")
		echo "<span style='color:red;padding-left:0px;'>".$NomErr."</span><br><br>";
	elseif($CognomeErr!="")
		echo "<span style='color:red;padding-left:0px;'>".$CognomeErr."</span><br><br>";
	if($_SERVER["REQUEST_METHOD"]!="POST")
	{
		echo "<span>Inserisci il Nome: </span><span style='padding-left:75px' required='true'>Inserisci il Cognome:</span><br>";
		echo "<span></span><input type='textbox' name='Nome' value='".$ar[0]."'><span style='padding-left:32px'></span><input type='textbox' name='Cognome' value='".$ar[1]."' required='true'><br><br>";
		echo "<span>Inserisci il sesso: </span><span style='padding-left:115px' required='true'>Inserisci la data di nascita:</span><br>";
		echo "<input type='radio' name='Sesso' value='Uomo' required='true'>Man<span style='padding-left:10px'></span><input type='radio' name='Sesso' value='Donna' required='true'>Female<span style='padding-left:10px'></span><input type='radio' name='Sesso' value='Altro' required='true'>Other<span style='padding-left:33px'></span><input type='date' name='Data' value='".$ar[3]."' min='1920-01-01' max='".date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y')-18))."' required='true'><br><br>";
		echo "<span><input type='submit' value='Conferma'><span style='padding-left:32px'></span><input type='reset' value='Annulla'><br><br>";
	}
	else
	{
		echo "<span>Inserisci il Nome: </span><span style='padding-left:105px' required='true'>Inserisci il Cognome:</span><br>";
		echo "<span></span><input type='textbox' name='Nome' placeholder='Mario'><span style='padding-left:62px'></span><input type='textbox' name='Cognome' placeholder='Rossi' required='true'><br><br>";
		echo "<span>Inserisci il sesso: </span><span style='padding-left:115px' required='true'>Inserisci la data di nascita:</span><br>";
		echo "<input type='radio' name='Sesso' value='Uomo' required='true'>Man<span style='padding-left:10px'></span><input type='radio' name='Sesso' value='Donna' required='true'>Female<span style='padding-left:10px'></span><input type='radio' name='Sesso' value='Altro' required='true'>Other<span style='padding-left:33px'></span><input type='date' name='Data' min='1920-01-01' max='".date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y')-18))."' required='true'><br><br>";
		echo "<span><input type='submit' value='Conferma'><span style='padding-left:32px'></span><input type='reset' value='Annulla'><br><br>";
	}
	echo "</form>";
}
?>
</body>
</html>