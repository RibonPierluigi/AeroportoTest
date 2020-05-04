<?php
if(file_exists("Tempo.csv"))
{
	$file=fopen("Tempo.csv","r");
	$vett=fgetcsv($file);
	echo "<table width='100%' style='background-color:white;' border='2px';>";
		echo "<th>Nome</th><th>Cognome</th><th>Sesso</th><th>Data di Nascita (YYYY/MM/DD)</th><th>Email</th>";
		echo "<tr>";
		echo "<td style='text-align:center'>".$vett[0]."</td>";
        echo "<td style='text-align:center'>".$vett[1]."</td>";
        echo "<td style='text-align:center'>".$vett[2]."</td>";
        echo "<td style='text-align:center'>".$vett[3]."</td>";
		echo "<td style='text-align:center'>".$vett[4]."</td>";
		echo "</tr>";
	echo "</table>";
}
else
{
	echo "<h3>Errore!Account inesistente!</h3>";
	echo "<h2>Provi a riavviare la pagina</h2>";
}
?>