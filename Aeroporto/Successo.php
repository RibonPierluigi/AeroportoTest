<?php
	$file=fopen("CounterCorrente.csv","r");
	$counter=fgetcsv($file);
	fclose($file);
	$file=fopen("RegistroUtenti.csv","r+");
	for($i=0;$i<($counter[0]-1);$i++)
	{
		$arr=fgetcsv($file);
	}
	fclose($file);
	$file=fopen("Tempo.csv","w");
	fputcsv($file,array($arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6]));
	fclose($file);
?>
<html>
<body>
<h3>Accesso all'account eseguito con successo!</h3>
</body>
</html>