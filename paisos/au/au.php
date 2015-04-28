<?php
ini_set('max_execution_time', 3600);

$array = [

"index21a8.html?p=at&amp;d=1945",
"index5874.html?p=at&amp;d=1946",
"indexaefc.html?p=at&amp;d=1947",
"indexc087.html?p=at&amp;d=1948",
"index8ee9.html?p=at&amp;d=1949",
"index1316.html?p=at&amp;d=1950",
"indexe485.html?p=at&amp;d=1951",
"indexb987.html?p=at&amp;d=1952",
"indexc357.html?p=at&amp;d=1953",
"index0d4f.html?p=at&amp;d=1954",
"indexa299.html?p=at&amp;d=1955",
"index1956.html?p=at&amp;d=1956",
"index438c.html?p=at&amp;d=1957",
"index7e74.html?p=at&amp;d=1958",
"index9235.html?p=at&amp;d=1959",
"index5958.html?p=at&amp;d=1960",
"index6dd4.html?p=at&amp;d=1961",
"index738d.html?p=at&amp;d=1962",
"index3b26.html?p=at&amp;d=1963",
"index5b90.html?p=at&amp;d=1964",
"index7ed7.html?p=at&amp;d=1965",
"indexbfe2.html?p=at&amp;d=1966",
"index8302.html?p=at&amp;d=1967",
"index8700.html?p=at&amp;d=1968",
"indexdbbf.html?p=at&amp;d=1969",
"indexcb2c.html?p=at&amp;d=1970",
"index4e53.html?p=at&amp;d=1971",
"index9389.html?p=at&amp;d=1972",
"index0b68.html?p=at&amp;d=1973",
"index8ee6.html?p=at&amp;d=1974",
"indexad1d.html?p=at&amp;d=1975",
"index0667.html?p=at&amp;d=1976",
"indexa689.html?p=at&amp;d=1977",
"indexacdf.html?p=at&amp;d=1978",
"index5c7a.html?p=at&amp;d=1979",
"indexc1ed.html?p=at&amp;d=1980",
"index2387.html?p=at&amp;d=1981",
"index1dc8.html?p=at&amp;d=1982",
"index00c4.html?p=at&amp;d=1983",
"index6551.html?p=at&amp;d=1984",
"index0700.html?p=at&amp;d=1985",
"index2cce.html?p=at&amp;d=1986",
"index3866.html?p=at&amp;d=1987",
"indexa773.html?p=at&amp;d=1988",
"indexcb73-2.html?p=at&amp;d=1989",
"indexcc66.html?p=at&amp;d=1990",
"index043a.html?p=at&amp;d=1991",
"index8638.html?p=at&amp;d=1992",
"indexc5f0.html?p=at&amp;d=1993",
"index26eb.html?p=at&amp;d=1994",
"index091a.html?p=at&amp;d=1995",
"indexf131.html?p=at&amp;d=1996",
"index08b5.html?p=at&amp;d=1997",
"index9155.html?p=at&amp;d=1998",
"indexcb5a.html?p=at&amp;d=1999",
"indexe859.html?p=at&amp;d=2000",
"index56b4.html?p=at&amp;d=2001",
"index0e03.html?p=at&amp;d=2002",
"indexca80.html?p=at&amp;d=2003",
"index756b.html?p=at&amp;d=2004"
];

for ($data = 0; $data <= 1; $data++) {
	$url = "http://localhost/www.christophemaetz.fr/philatelie/basededonnees/".$array[$data];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language: es-es,en"));
	curl_setopt($ch, CURLOPT_TIMEOUT, 100);
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$result = curl_exec($ch);
	$error = curl_error($ch);
	curl_close($ch);

	//preg_match_all("(<td class=\"bL bB maintd\">1931</td>(.*)</table>)siU", $result , $title);
	preg_match_all("(<tr class=\"bddCouleurTimbre\">(.*)</table>)siU", $result , $title);//per a saber quantes imatges hi ha
    //var_dump($title); //var_dump dirà quantes imatges hi ha a la pàgina
	$num_segells = count($title[0]);
	//echo $num_segells;

$server = "localhost";
$user = "root";
$pass = "";
$bd = "segells";

$mysqli = new mysqli($server, $user, $pass, $bd);//USAR PDO!!!!

if ($mysqli->connect_errno) {
    echo "Falla la conexió MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$dir ="";
for ($x = 0; $x < $num_segells; $x++) {
	for ($y = 0; $y <= 600; $y++) {
    $dir .= $title[0][$x][$y]; //guardo tota la url a dir
} 
//echo($dir);
//f = foto; a = any; p = pais; c = cataleg; y = Yvert-et-Tellier; e = Edifil; m = Michel; s = Scott;
preg_match("(src='(.*)')siU", $dir, $f); //trec tot el que hi ha abans del http
preg_match("(<td class=\"bL bB maintd\">(.*)</td>)siU", $dir, $a); //agafo l'any
preg_match("(scans/(.*)/)siU", $dir, $p); //agafo el pais
preg_match("(Yvert-et-Tellier</td><td align=\"right\">(.*?)</td>)", $dir, $y); //agafo el YT
preg_match("(Michel</td><td align=\"right\">(.*?)</td>)", $dir, $m); //agafo el Mi
//preg_match("(Scott</td><td align=\"right\">(.*?)</td>)", $dir, $s); //agafo el SC
//echo $p[1]."<br><br>";
//echo $a[1]."<br><br>";
//echo $f[1]."<br><br>";
$pais = $p[1];
$any = $a[1];
$img = $f[1];
$img = file_get_contents($img);
$img = base64_encode($img);
$yvert = $y[1];
$michel = $m[1];


/*
----- PROVA PER VISUALITZAR DADES QUE SERÀN INSERIDES ------
echo($any. " || ");
echo($yvert. " || ");
echo($michel. " || ");
echo($img);
echo("<br></br>");

*/
$mysqli->query("INSERT INTO au (any, imatge, yvert, michel, id_pais) VALUES ('12', '0ades', 'sdfsf', 'qwerty', 'au')");

$dir = "";
  }
}

?>
