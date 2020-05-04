<?php
if($_SERVER["REQUEST_METHOD"]=="POST")
{
	if(file_exists("CounterB.csv"))
		{
			$file=fopen("CounterB.csv","r");
			$arg=fgetcsv($file);
			fclose($file);
			$file=fopen("CounterB.csv","w");
			fputcsv($file,array($arg[0]+1));
			fclose($file);
		}
		else
		{
			$file=fopen("CounterB.csv","w");
			fputcsv($file,array("2"));
			$arg[]=1;
			fclose($file);
		}
	$file=fopen("ListaVoli.csv","a");
	fputcsv($file,array($arg[0],$_POST["TipoAereo"],$_POST["Destinazione"],$_POST["Opartenza"],$_POST["TempoArrivo"],$_POST["NumeroPosti"],$_POST["Data"]));
	fclose($file);
	echo "<h1>Operazione completata correttamente!</h1>";
	die();
}
?>
<html>
<body>
<h2>Aggiunta Volo</h2>
<form action="AggiungiVolo.php" method="POST">
Tipo di Aereo<br>
<input type="textbox" name="TipoAereo" placeholder="Boeing B-52 Stratofortress" required="true"><br><br>
Destinazione<br>
<select name="Destinazione" required="true">
<option value="Roma">Roma</option>
<option value="Venezia">Venezia</option>
<option value="New-York">New-York</option>
<option value="Detroit">Detroit</option>
<option value="Mosca">Mosca</option>
</select><br><br>
Orario di partenza<span style="padding-left:45px"></span>Tempo di arrivo<br>
<select name="Opartenza" required="true">
<option value="4.00">4.00</option>
<option value="8.00">8.00</option>
<option value="16.00">16.00</option>
<option value="20.00">20.00</option>
</select>
<span style="padding-left:100px"></span>
<input type="number" name="TempoArrivo" style="width:110px;" min="60" max="900">&nbsp min<br><br>
Numero posti<span style="padding-left:70px"></span>Giorno di partenza<br>
<input type="number" name="NumeroPosti" min="4" max="1000" style="width:110px;"><span style="padding-left:45px"></span><input type="date" name="Data" min="<?php echo date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y'))); ?>" max="<?php echo date("Y-m-d", mktime(0,0,0,date('m'),date('d'),date('Y')+2)); ?>" required="true"><br><br>
<input type="submit" value="conferma">
</form>
</body>
</html>