<?php
if(file_exists("Tempo.csv"))
{
	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		if(!file_exists("Tempor.csv"))
		{
			$contatore=0;
			if(file_exists("ListaVoli.csv"))
			{
				$arg=array();
				$file=fopen("ListaVoli.csv","r");
				$arr=fgetcsv($file);
				while(!feof($file))
				{
					if($_POST["Data"]==$arr[6] && $_POST["Destinazione"]==$arr[2])
					{
						$arg[]=$arr[0];
						$contatore++;
					}
					$arr=fgetcsv($file);
				}
				fclose($file);
				if($contatore==0)
				{
				echo "<h3>Nessun volo presente in sistema</h3>";
				echo "<h3>Attenda che un operatore inserisca i voli!</h3>";
				die();
				}
				else
				{
					$_SERVER["REQUEST_METHOD"]=="";
					$file=fopen("Tempor.csv","w");
					fputcsv($file,$arg);
					fclose($file);
					$file=fopen("ListaVoli.csv","r");
					$y=0;
					echo "<form action='PrenotaVolo.php' method='POST'>";
					echo "<table width='100%' style='background-color:white;' border='2px';>";
					echo "<th>TipoAereo</th><th>Destinazione</th><th>Orario di partenza</th><th>Tempo di arrivo</th><th>Numero posti</th><th>Data</th><th>Prenotazione</th>";
					for($i=0;$i<count($arg);$i++)
					{
						for(;$y<($arg[$i]-1);$y++)
						{
							fgetcsv($file);
						}
						$vett=fgetcsv($file);
						if($vett[5]!=0)
						{
							echo "<tr style='text-align:center;'>";
							echo "<td>".$vett[1]."</td>";
							echo "<td>".$vett[2]."</td>";
							echo "<td>".$vett[3]."</td>";
							echo "<td>".$vett[4]."min</td>";
							echo "<td>".$vett[5]."</td>";
							echo "<td>".$vett[6]."</td>";
							echo "<td><input type='radio' value='".$vett[0]."' name='prenotazione' required='true'</td>";
							echo "</tr>";
						}
						$y++;
					}
					echo "</table>";
					echo "<br><input type='submit' value='Conferma'>";
					echo "</form>";
					fclose($file);
				}
			}
			else
			{
				echo "<h3>Nessun volo presente in sistema</h3>";
				echo "<h3>Attenda che un operatore inserisca i voli!</h3>";
				die();
			}
		}
		else
		{
			$file=fopen("ListaVoli.csv","r");
			$fil=fopen("Prenotazioni.csv","a");
			$fi=fopen("Tempo.csv","r");
			for($i=0;$i<($_POST["prenotazione"]-1);$i++)
			{
				fgetcsv($file);
			}
			$ve=fgetcsv($file);
			$ve[5]=$ve[5]-1;
			$str=implode(",",$ve);
			$vec=fgetcsv($fi);
			$stra=implode(",",$vec);
			if(file_exists("CounterC.csv"))
			{
				$filetto=fopen("CounterC.csv","r");
				$argh=fgetcsv($filetto);
				fclose($filetto);
				$filetto=fopen("CounterC.csv","w");
				fputcsv($filetto,array($argh[0]+1));
				fclose($filetto);
			}
			else
			{
				$filetto=fopen("CounterC.csv","w");
				fputcsv($filetto,array("2"));
				$argh[]=1;
				fclose($filetto);
			}
			$stravi=implode(",",$argh);
			$finger=fopen("CounterCorrente.csv","r");
			$afffff=fgetcsv($finger);
			fclose($finger);
			$stratos=implode(",",$afffff);
			$st=$str.",".$stra.",".$stratos.",".$stravi;
			$ves=explode(",",$st);
			fputcsv($fil,$ves);
			fclose($file);
			fclose($fil);
			fclose($fi);
			$fi=fopen("CounterB.csv","r");
			$ya=fgetcsv($fi);
			fclose($fi);
			$file=fopen("ListaVoli.csv","r");
			$fil=fopen("Oenaropmet.csv","w");
			$i;
			for($i=0;$i<($_POST["prenotazione"]-1);$i++)
			{
				$vett=fgetcsv($file);
				fputcsv($fil,$vett);
			}
			$vesc=fgetcsv($file);
			$vesc[5]=$vesc[5]-1;
			fputcsv($fil,$vesc);
			for($i;$i<($ya[0]-2);$i++)
			{
				$vett=fgetcsv($file);
				fputcsv($fil,$vett);
			}
			fclose($file);
			fclose($fil);
			@unlink("ListaVoli.csv");
			rename("Oenaropmet.csv", "ListaVoli.csv");
			echo "<h3>Operazione Completata!</h3>";
			$_SERVER["REQUEST_METHOD"]=="";
			@unlink("Tempor.csv");
			die();
		}
	}
}
else
{
	echo "<h3>Errore!Account inesistente!</h3>";
	echo "<h2>Provi a riavviare la pagina</h2>";
	die();
}
?>
<?php
if(!file_exists("Tempor.csv"))
{
	$York="New-York";
	echo "<html>";
	echo "<body>";
	echo "<h2>Prenotazione Volo</h2>";
	echo "<form action='PrenotaVolo.php' method='POST'>";
	echo "Destinazione<br>";
	echo "<select name='Destinazione' required='true'>";
	echo "<option value='Roma'>Roma</option>";
	echo "<option value='Venezia'>Venezia</option>";
	echo "<option value='".$York."'>New-York</option>";
	echo "<option value='Detroit'>Detroit</option>";
	echo "<option value='Mosca'>Mosca</option>";
	echo "</select><br><br>";
	echo "Giorno di partenza<br>";
	echo "<input type='date' name='Data' min='".date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y')))."' max='".date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y')+2))."' required='true'><br><br>";
	echo "<input type='submit' value='conferma'>";
	echo "</form>";
	echo "</body>";
	echo "</html>";
}
?>