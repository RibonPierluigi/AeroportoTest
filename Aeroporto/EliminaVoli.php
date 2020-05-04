<?php
if(file_exists("ListaVoli.csv"))
{
	$file=fopen("ListaVoli.csv","r");
	echo "<table width='100%' style='background-color:white;' border='2px';>";
		echo "<th>Codice</th><th>TipoAereo</th><th>Destinazione</th><th>Orario di partenza</th><th>Tempo di arrivo</th><th>Numero posti</th><th>Data</th>";
		$vett=fgetcsv($file);
		while(!feof($file))
		{
			echo "<tr style='text-align:center;'>";
			echo "<td>".$vett[0]."</td>";
			echo "<td>".$vett[1]."</td>";
			echo "<td>".$vett[2]."</td>";
			echo "<td>".$vett[3]."</td>";
			echo "<td>".$vett[4]."min</td>";
			echo "<td>".$vett[5]."</td>";
			echo "<td>".$vett[6]."</td>";
			echo "</tr>";
			$vett=fgetcsv($file);
		}
	echo "</table>";
	fclose($file);
}
else
{
	echo "<h1>Nessun volo eliminabile!</h1>";
}
$errore="";
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if(!preg_match("/^[0-9]*$/",$_POST["codice"]))
	{
		$errore="Errore";
	}
	else
	{
		if(file_exists("ListaVoli.csv"))
		{
			$y=-1;
			$file=fopen("ListaVoli.csv","r");
			$ve=fgetcsv($file);
			while(!feof($file))
			{
				if($ve[0]==$_POST["codice"])
					$y=$ve[0];
				$ve=fgetcsv($file);
			}
			fclose($file);
			$fi=fopen("CounterB.csv","r");
			$ya=fgetcsv($fi);
			fclose($fi);
			$file=fopen("ListaVoli.csv","r");
			$fil=fopen("Oenaropmet.csv","w");
			$i;
			for($i=0;$i<($y)-1;$i++)
				{
				$vett=fgetcsv($file);
				fputcsv($fil,$vett);
				}
			fgetcsv($file);
			for($i;$i<($ya[0]-2);$i++)
				{
				$vett=fgetcsv($file);
				$vett[0]=$vett[0]-1;
				fputcsv($fil,$vett);
				}
			fclose($file);
			fclose($fil);
			$fi=fopen("CounterB.csv","w");
			fputcsv($fi,array($ya[0]-1));
			fclose($fi);
			@unlink("ListaVoli.csv");
			rename("Oenaropmet.csv", "ListaVoli.csv");
			if(file_exists("Prenotazioni.csv"))
			{
				$file=fopen("Prenotazioni.csv","r");
				$fil=fopen("Oenaropmet.csv","w");
				$vert=fgetcsv($file);
				while(!feof($file))
				{
					if($vert[0]!=$y)
						fputcsv($vert,$fil);
					$vert=fgetcsv($file);
				}
				fclose($fil);
				fclose($file);
				@unlink("Prenotazioni.csv");
				rename("Oenaropmet.csv", "Prenotazioni.csv");
			}
			echo "<h3>Operazione completata!</h3>";
			header("Refresh:0");
			die();
		}
		else
			$errore="Errore";
	}
}
?>
<html>
<body>
<form action="EliminaVoli.php" method="POST">
<?php
	if($errore!="")
		echo "<span style='color:red'>Errore nel codice</span>"
?>
	<br><br>Inserisci il codice<br>
	<input type="number" name="codice" placeholder="***" required="true">
	<input type="submit" value="conferma">
</form>
</body>
</html>