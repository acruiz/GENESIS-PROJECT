<?php
$id_pais = "fo";

include_once("anysFo.php");

/*
echo sizeof($anys);

echo "<pre>";

	var_dump($anys);
echo "</pre>";

exit();
*/


////////////// CONNEXIÓ A BD AMB PDO \\\\\\\\\\\\\\\\\\\\\\\\\\/
$nomUsuari = "root";
$password = "";
$connexio = new PDO ('mysql:host=localhost;dbname=segells',$nomUsuari,$password);

for ($i = 25; $i < 31; $i++) {
	// http://localhost/segells/philatelie/basededonnees/index8cdf.html?p=fo&d=1975
	$url = "http://localhost/segells/philatelie/basededonnees/".$anys[$i];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
	curl_setopt($ch, CURLOPT_TIMEOUT, 31);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch); 

	//preg_match_all("(<td class=\"bL bB maintd\">1931</td>(.*)</table>)siU", $result , $title);
	preg_match_all("(<tr class=\"bddCouleurTimbre\">(.*)</table>)siU", $result , $title);//per a saber quantes imatges hi ha
    var_dump($title); //var_dump dirà quantes imatges hi ha a la pàgina
	$num_segells = count($title[0]);

/*$mysqli = new mysqli("domini", "user", "pass", "taula");//USAR PDO!!!!
if ($mysqli->connect_errno) {
    echo "Falla la conexió MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}*/



$dir = "";
for ($x = 0; $x < $num_segells; $x++) {
	
	for ($y = 0; $y <= 700; $y++) {
    //var_dump($title[0]);
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
// $c = 'Yvert-et-Tellier '.' '.$y[1]."\n".' Edifil '.' '.$e[1]."\n".' Michel '.' '.$m[1]."\n".' Scott '.' '.$s[1]."\n";
// echo $c."<br>";
$pais = $p[1];
$any = $a[1];
$img = $f[1];
$img = file_get_contents($img);
$img = base64_encode($img);
echo $dir."<br><br>";

/*if (!$mysqli->query("INSERT INTO segells(pais, any, foto, cataleg) VALUES ('$pais', '$any','$img','$c')")) {
    echo "Error :@" . $mysqli->errno . ") " . $mysqli->error;
}*/
$pais = "fo";
//////////// INSERCIÓ //////////////////////
$insercio = $connexio->prepare('INSERT INTO fo (any,imatge,yvert, michel, scott, id_pais)  VALUES (:any, :imatge, :yvert, :michel, :scott, :idPais)');


$insercio->bindParam(':any',$any);
$insercio->bindParam(':imatge',$img);
$insercio->bindParam(':yvert',$y[1]);
$insercio->bindParam(':michel',$m[1]);
$insercio->bindParam(':scott',$s[1]);
$insercio->bindParam(':idPais',$pais);
//$insercio->bindParam(':edifil',$e[1]);


$insercio->execute();

$dir="";
}

}
//echo 'Valors enregistrats correctament'."<br><br>";
$connexio->connection = null;

?>
