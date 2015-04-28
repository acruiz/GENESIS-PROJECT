<?php
//require 'conexion.php';

for ($data = 2004; $data <= 2008; $data++) {
	$url = "http://www.christophemaetz.fr/philatelie/basededonnees/?p=ad-es&d=".$data;
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
$c = 'Yvert-et-Tellier '.' '.$y[1]."\n".' Edifil '.' '.$e[1]."\n".' Michel '.' '.$m[1]."\n".' Scott '.' '.$s[1]."\n";
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
$consulta = "INSERT INTO ad_es(any,imatge,yvert,michel,scott,edifil,id_pais) VALUES('$any','$img','".$y[1]."','".$m[1]."','".$s[1]."','".$e[1]."','ad-es')";

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