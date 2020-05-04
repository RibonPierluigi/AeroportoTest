<?php
if(file_exists("Tempo.csv"))
{
	if(file_exists("Prenotazioni.csv"))
	{
		if($_SERVER["REQUEST_METHOD"]!="POST")
		{
			$contatore=0;
			$arg=array();
			$filer=fopen("Prenotazioni.csv","r");
			$arr=fgetcsv($filer);
			$filew=fopen("CounterCorrente.csv","r");
			$affa=fgetcsv($filew);
			fclose($filew);
			while(!feof($filer))
			{
				if($affa[0]==$arr[13])
				{
						$arg[]=$arr[14];
						$contatore++;
				}
				$arr=fgetcsv($filer);
			}
			fclose($filer);
			if($contatore==0)
			{
			echo "<h3>Nessun volo prenotato in sistema</h3>";
			die();
			}
			else
			{
			$y=0;
			$file=fopen("Prenotazioni.csv","r");
			echo "<form action='EliminaPrenotazione.php' method='POST'>";
			echo "<table width='100%' style='background-color:white;' border='2px';>";
			echo "<th>TipoAereo</th><th>Destinazione</th><th>Orario di partenza</th><th>Tempo di arrivo</th><th>Numero posti</th><th>Data</th><th>Prenotazione</th><th>Codice</th>";
			for($i=0;$i<count($arg);$i++)
			{
				for(;$y<($arg[$i]-1);$y++)
				{
					fgetcsv($file);
				}
			$vett=fgetcsv($file);
			echo "<tr style='text-align:center;'>";
			echo "<td>".$vett[1]."</td>";
			echo "<td>".$vett[2]."</td>";
			echo "<td>".$vett[3]."</td>";
			echo "<td>".$vett[4]."min</td>";
			echo "<td>".$vett[5]."</td>";
			echo "<td>".$vett[6]."</td>";
			echo "<td>".$vett[14]."</td>";
			echo "<td><input type='radio' value='".$vett[14]."' name='prenotazione' required='true'</td>";
			echo "</tr>";
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
			$y=$_POST["prenotazione"];
			$fi=fopen("CounterC.csv","r");
			$ya=fgetcsv($fi);
			fclose($fi);
			$file=fopen("Prenotazioni.csv","r");
			$fil=fopen("Oenaropmet.csv","w");
			$i;
			for($i=0;$i<($y)-1;$i++)
			{
				$vett=fgetcsv($file);
				fputcsv($fil,$vett);
			}
			$roger=fgetcsv($file);
			for($i;$i<($ya[0]-2);$i++)
			{
				$vett=fgetcsv($file);
				$vett[14]=$vett[14]-1;
				fputcsv($fil,$vett);
			}
			fclose($file);
			fclose($fil);
			$counter=$roger[0];
			$fi=fopen("CounterC.csv","w");
			fputcsv($fi,array($ya[0]-1));
			fclose($fi);
			@unlink("Prenotazioni.csv");
			rename("Oenaropmet.csv", "Prenotazioni.csv");
			$fi=fopen("CounterB.csv","r");
			$ya=fgetcsv($fi);
			fclose($fi);
			$file=fopen("ListaVoli.csv","r");
			$fil=fopen("Oenaropmet.csv","w");
			$i;
			for($i=0;$i<($counter-1);$i++)
			{
				$vett=fgetcsv($file);
				fputcsv($fil,$vett);
			}
			$vesc=fgetcsv($file);
			$vesc[5]=$vesc[5]+1;
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
			echo "<h3>Operazione completata!</h3>";
			die();
		}
	}
	else
	{
		echo "<h3>Nessuna prenotazione presente nel sistema!</h3>";
		die();
	}
}
else
{
	$controllo=false;
	echo "<h3>Errore!Account inesistente!</h3>";
	echo "<h2>Provi a riavviare la pagina</h2>";
	die();
}
?>