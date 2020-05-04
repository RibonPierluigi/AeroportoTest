<?php
$controlloErrore=false;
$NomErr=$CognomeErr="";
if(file_exists("Temp.csv"))
{
	$file=fopen("Temp.csv","r");
	$riga=fgetcsv($file);
	if(!preg_match("/^[A-Z a-z0-9]*$/",$riga[1]))
		$controlloErrore=true;
	if(!filter_var($riga[0],FILTER_VALIDATE_EMAIL))
		$controlloErrore=true;
	elseif(file_exists("RegistroUtenti.csv"))
	{
		$Errore=false;
		$fi=fopen("RegistroUtenti.csv","r");
		$ttev=fgetcsv($fi);
		while(!feof($fi))
		{
			if($riga[0]==$ttev[5])
				$Errore=true;
			$ttev=fgetcsv($fi);
		}
		if(!$Errore)
			$controlloErrore=false;
		else
			$controlloErrore=true;
		fclose($fi);
	}
	fclose($file);
}
else
	$controlloErrore=true;
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if($controlloErrore==true)
	{
		$file=fopen("Temp.csv","w");
		if(preg_match("/^[A-Z a-z0-9]*$/",$_POST["password"])==true && filter_var($_POST["mail"],FILTER_VALIDATE_EMAIL)==true)
		{
			if(!file_exists("RegistroUtenti.csv"))
			{
				fputcsv($file,array($_POST["mail"],$_POST["password"]));
				$controlloErrore=false;
			}
			else
			{
				$Errore=false;
				$fi=fopen("RegistroUtenti.csv","r");
				$ttev=fgetcsv($fi);
				while(!feof($fi))
				{
					if($_POST["mail"]==$ttev[5])
						$Errore=true;
					$ttev=fgetcsv($fi);
				}
				if(!$Errore)
				{
					fputcsv($file,array($_POST["mail"],$_POST["password"]));
					$controlloErrore=false;
				}
				fclose($fi);
			}
		}
		fclose($file);
	}
}
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if(!preg_match("/^[A-Z a-z]*$/",$_POST["Nome"]))
		$NomErr="Formato non corretto nel nome";
	if(!preg_match("/^[A-Z a-z]*$/",$_POST["Cognome"]))
		$CognomeErr="Formato non corretto nel cognome";
	if($CognomeErr=="" && $NomErr=="" && $controlloErrore==false)
	{
		echo "<h1>Operazione completata correttamente!</h1>";
		$file=fopen("Temp.csv","r");
		$arr=fgetcsv($file);
		fclose($file);
		$arg=array();
		if(file_exists("Counter.csv"))
		{
			$file=fopen("Counter.csv","r");
			$arg=fgetcsv($file);
			fclose($file);
			$file=fopen("Counter.csv","w");
			fputcsv($file,array($arg[0]+1));
			fclose($file);
		}
		else
		{
			$file=fopen("Counter.csv","w");
			fputcsv($file,array("2"));
			$arg[]=1;
			fclose($file);
		}
		$file=fopen("RegistroUtenti.csv","a");
		fputcsv($file,array($arg[0],$_POST["Nome"],$_POST["Cognome"],$_POST["Sesso"],$_POST["Data"],$arr[0],$arr[1]));
		fclose($file);
		$file=fopen("Tempo.csv","w");
		fputcsv($file,array($_POST["Nome"],$_POST["Cognome"],$_POST["Sesso"],$_POST["Data"],$arr[0],$arr[1]));
		fclose($file);
		$file=fopen("Counter.csv","r");
		$tt=fgetcsv($file);
		fclose($file);
		$file=fopen("CounterCorrente.csv","w");
		fputcsv($file,$tt);
		fclose($file);
		@unlink("Temp.csv");
		die();
	}
}
?>
<html>
<body>
<h2 style="margin-left:135px;margin-top:40px">Passo 2 - Completamento Account</h2>
<form style="margin-left:100px" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
<?php
if($NomErr!="" && $CognomeErr!="")
	echo "<span style='color:red;padding-left:5px;'>".$NomErr."</span><span style='color:red;padding-left:20px;'>".$CognomeErr."</span><br><br>";
elseif($NomErr!="")
	echo "<span style='color:red;padding-left:110px;'>".$NomErr."</span><br><br>";
elseif($CognomeErr!="")
	echo "<span style='color:red;padding-left:100px;'>".$CognomeErr."</span><br><br>";
?>
<span style="padding-left:35px">Inserisci il Nome: </span><span style="padding-left:75px" required="true">Inserisci il Cognome:</span><br>
<span style="padding-left:35px"></span><input type="textbox" name="Nome" placeholder="Luppolo"><span style="padding-left:32px"></span><input type="textbox" name="Cognome" placeholder="Sossi" required="true"><br><br>
<?php
if($controlloErrore==true)
{
	echo "<span style='padding-left:75px;color:red'>Mail o password inserite incorrettamente </span><br><br>";
	echo "<span style='padding-left:80px;'>Inserisci di nuovo la mail: </span><br>";
	echo "<span style='padding-left:80px;'></span>";
	echo "<input type='textbox' name='mail' style='width:250px;' placeholder='mail@gmail.com' required='true'><br>";
	echo "<span style='padding-left:80px;'>Inserisci di nuovo la password: </span><br>";
	echo "<span style='padding-left:80px;'></span>";
	echo "<input type='textbox' name='password' style='width:250px;' placeholder='********' required='true' maxlength='8'><br><br>";
}
?>
<span style="padding-left:42px">Inserisci il sesso: </span><span style="padding-left:73px" required="true">Inserisci la data di nascita:</span><br>
<input type="radio" name="Sesso" value="Uomo" required="true">Man<span style="padding-left:10px"></span><input type="radio" name="Sesso" value="Donna" required="true">Female<span style="padding-left:10px"></span><input type="radio" name="Sesso" value="Altro" required="true">Other<span style="padding-left:33px"></span><input type="date" name="Data" min="1920-01-01" max="<?php echo date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y')-18)); ?>" required="true"><br><br>
<span style="padding-left:122px"><input type="submit" value="Conferma"><span style="padding-left:32px"></span><input type="reset" value="Annulla"><br><br>
</form>
</body>
</html>