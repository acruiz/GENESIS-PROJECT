<?php
//require 'conexion.php';
$berlin_oest = array(
'indexb03e.html?p=de-wb&d=1948',
'index57a1.html?p=de-wb&d=1949',
'indexec34.html?p=de-wb&d=1950',
'index51a7.html?p=de-wb&d=1951',
'indexb158.html?p=de-wb&d=1952',
'index7594.html?p=de-wb&d=1953',
'indexd77e.html?p=de-wb&d=1954',
'indexc003.html?p=de-wb&d=1955',
'index755a.html?p=de-wb&d=1956',
'index60b8.html?p=de-wb&d=1957',
'index8b47.html?p=de-wb&d=1958',
'indexbf5d.html?p=de-wb&d=1959',
'indexa4dd.html?p=de-wb&d=1960',
'index15bd.html?p=de-wb&d=1961',
'indexedce.html?p=de-wb&d=1962',
'index28dd.html?p=de-wb&d=1963',
'indexea06.html?p=de-wb&d=1964',
'index7c08.html?p=de-wb&d=1965',
'index8e64.html?p=de-wb&d=1966',
'indexbbe4.html?p=de-wb&d=1967',
'indexd6fb.html?p=de-wb&d=1968',
'index51da.html?p=de-wb&d=1969',
'index9869.html?p=de-wb&d=1970',
'indexecee.html?p=de-wb&d=1971',
'index0349.html?p=de-wb&d=1972',
'index6fe6.html?p=de-wb&d=1973',
'indexac02.html?p=de-wb&d=1974',
'indexb4f7.html?p=de-wb&d=1975',
'index980d.html?p=de-wb&d=1976',
'index032a.html?p=de-wb&d=1977',
'index2316.html?p=de-wb&d=1978',
'indexac68.html?p=de-wb&d=1979',
'index8f61.html?p=de-wb&d=1980',
'indexc6e2.html?p=de-wb&d=1981',
'index1bb0.html?p=de-wb&d=1982',
'indexe614.html?p=de-wb&d=1983',
'index74f2.html?p=de-wb&d=1984',
'indexceb0.html?p=de-wb&d=1985',
'indexcae7.html?p=de-wb&d=1986',
'index2243.html?p=de-wb&d=1987',
'index71a2.html?p=de-wb&d=1988',
'index9331.html?p=de-wb&d=1989',
'index39d6.html?p=de-wb&d=1990');


for ($i = 0; $i < sizeof($berlin_oest) ; $i++) {
	$url = "http://localhost/sg/philatelie/basededonnees/".$berlin_oest[$i];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch); 

	//preg_match_all("(<td class=\"bL bB maintd\">1931</td>(.*)</table>)siU", $result , $title);
	preg_match_all("(<tr class=\"bddCouleurTimbre\">(.*)</table>)siU", $result , $title);//per a saber quantes imatges hi ha
    //var_dump($title); //var_dump dirà quantes imatges hi ha a la pàgina
	$num_segells = count($title[0]);

	//Conectamos a la base de datos.
	//$conexion = conectar();
	$conexion = new mysqli("localhost", "root", "", "segells");//USAR PDO!!!!
	if ($conexion->connect_errno) {
	    echo "Falla la conexió MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error;
	}
$dir = '';
for ($x = 0; $x < $num_segells; $x++) {
for ($y = 0; $y <= 1000; $y++) {
	//var_dump($title[0][$x][$y]);
    //var_dump($title[1]);
    $dir .= $title[0][$x][$y]; //guardo tota la url a dir
} 
//f = foto; a = any; p = pais; c = cataleg; y = Yvert-et-Tellier; e = Edifil; m = Michel; s = Scott;
preg_match("(src='(.*)')siU", $dir, $f); //trec tot el que hi ha abans del http
preg_match("(<td class=\"bL bB maintd\">(.*)</td>)siU", $dir, $a); //agafo l'any
preg_match("(scans/(.*)/)siU", $dir, $p); //agafo el pais
preg_match("(Yvert-et-Tellier</td><td align=\"right\">(.*?)</td>)", $dir, $y); //agafo el YT
preg_match("(Edifil</td><td align=\"right\">(.*?)</td>)", $dir, $e); //agafo el Ed
preg_match("(Michel</td><td align=\"right\">(.*?)</td>)", $dir, $m); //agafo el Mi
preg_match("(Scott</td><td align=\"right\">(.*?)</td>)", $dir, $s); //agafo el SC
echo $p[1]."<br><br>";
echo $a[1]."<br><br>";
echo $f[1]."<br><br>";
$c = 'Yvert-et-Tellier '.' '.$y[1]."\n".' Michel '.' '.$m[1]."\n".' Scott '.' '.$s[1]."\n";
echo $c."<br>";
$pais = $p[1];
$any = $a[1];
$img = $f[1];
$img = file_get_contents($img);
$img = base64_encode($img);
echo $dir."<br><br>";

//var_dump($y[1]);
// Insertamos los datos adquiridos a la base de datos.
// implode(' ',explode('&nbsp;',$y[1]))
$consulta = "INSERT INTO de_wb(any,imatge,yvert,michel,scott,id_pais) VALUES('$any','$img','".$y[1]."','".$m[1]."','".$s[1]."','de-wb')";

/*if (!$mysqli->query("INSERT INTO segells(pais, any, foto, cataleg) VALUES ('$pais', '$any','$img','$c')")) {
    echo "Error :@" . $mysqli->errno . ") " . $mysqli->error;
}*/
//die(var_dump($consulta));

$conexion->query($consulta);

$dir='';
}
}
//echo 'Valors enregistrats correctament'."<br><br>";


?>
