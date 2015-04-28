<?php


$anysLie = array(
"index5cfe.html?p=li&amp;d=1912",
"index2f47.html?p=li&amp;d=1917",
"index949c.html?p=li&amp;d=1918",
"index5eac.html?p=li&amp;d=1920",
"indexc94b.html?p=li&amp;d=1921",
"index9c47.html?p=li&amp;d=1924",
"index32c3-2.html?p=li&amp;d=1925",
"index43cd.html?p=li&amp;d=1926",
"index0003.html?p=li&amp;d=1927",
"index7b22.html?p=li&amp;d=1928",
"index5b79.html?p=li&amp;d=1929",
"index78d9.html?p=li&amp;d=1930",
"indexb3da.html?p=li&amp;d=1931",
"indexb840.html?p=li&amp;d=1932",
"index8b17.html?p=li&amp;d=1933",
"indexbc76.html?p=li&amp;d=1934",
"indexcaf4.html?p=li&amp;d=1935",
"indexfcd3.html?p=li&amp;d=1936",
"index9feb.html?p=li&amp;d=1937",
"indexfe97.html?p=li&amp;d=1938",
"index415b.html?p=li&amp;d=1939",
"index912f.html?p=li&amp;d=1940",
"indexbabe.html?p=li&amp;d=1941",
"indexc544.html?p=li&amp;d=1942",
"index3335.html?p=li&amp;d=1943",
"index9e2b.html?p=li&amp;d=1944",
"index4617.html?p=li&amp;d=1945",
"indexf3c5.html?p=li&amp;d=1946",
"index961c.html?p=li&amp;d=1947",
"index0b62.html?p=li&amp;d=1948", 
"indexce4d.html?p=li&amp;d=1949",
 "index860f.html?p=li&amp;d=1950",
 "index85a9.html?p=li&amp;d=1951",
  "index5c06.html?p=li&amp;d=1952",
   "index6f6d.html?p=li&amp;d=1953",
    "index15f3.html?p=li&amp;d=1954",
    "index8d73.html?p=li&amp;d=1955",
     "indexe068.html?p=li&amp;d=1956",
      "index25f1.html?p=li&amp;d=1957",
       "index5de7-2.html?p=li&amp;d=1958",
        "indexb786.html?p=li&amp;d=1959",
         "index6270.html?p=li&amp;d=1960",
          "index3bdc.html?p=li&amp;d=1961",
           "indexbf30.html?p=li&amp;d=1962",
            "index50b6.html?p=li&amp;d=1963",
             "index7987.html?p=li&amp;d=1964",
             "index0635-2.html?p=li&amp;d=1965",
              "index7ff1.html?p=li&amp;d=1966",
               "indexafd5.html?p=li&amp;d=1967",
                "indexedbe.html?p=li&amp;d=1968",
                 "index90a2.html?p=li&amp;d=1969",
                  "indexb755.html?p=li&amp;d=1970",
                   "indexe184.html?p=li&amp;d=1971",
                    "index8605.html?p=li&amp;d=1972",
                     "index865f.html?p=li&amp;d=1973",
                      "index0d2a.html?p=li&amp;d=1974",
                       "indexf019.html?p=li&amp;d=1975",
                        "index6f77.html?p=li&amp;d=1976",
                         "index4035.html?p=li&amp;d=1977",
                          "indexf593.html?p=li&amp;d=1978",
                           "index024b.html?p=li&amp;d=1979",
                            "index6445.html?p=li&amp;d=1980",
                             "indexd017.html?p=li&amp;d=1981",
                              "index3cfb.html?p=li&amp;d=1982",
                               "indexd4a1.html?p=li&amp;d=1983",
                                "indexb491.html?p=li&amp;d=1984",
                                 "index6e42.html?p=li&amp;d=1985",
                                  "index5b3a.html?p=li&amp;d=1986",
                                   "index3d6e.html?p=li&amp;d=1987",
                                    "indexf97a.html?p=li&amp;d=1988",
                                     "index4c0a.html?p=li&amp;d=1989",
                                      "index1fb3.html?p=li&amp;d=1990",
                                       "indexa8d1.html?p=li&amp;d=1991",
                                        "index4db7.html?p=li&amp;d=1992",
                                         "index558b.html?p=li&amp;d=1993",
                                          "index13ea.html?p=li&amp;d=1994",
                                           "index787d-2.html?p=li&amp;d=1995",
                                           "indexcc32.html?p=li&amp;d=1996",
                                           "index0439.html?p=li&amp;d=1997",
                                            "index3b59.html?p=li&amp;d=1998",
                                            "indexac80.html?p=li&amp;d=1999",
                                            "indexbc20.html?p=li&amp;d=2000",
                                            "index1559.html?p=li&amp;d=2001",
                                             "indexf4ae.html?p=li&amp;d=2002",
                                              "index11f2.html?p=li&amp;d=2003"
);


////////////// CONNEXIÓ A BD AMB PDO \\\\\\\\\\\\\\\\\\\\\\\\\\/
$nomUsuari = "root";
$password = "";
$connexio = new PDO ('mysql:host=localhost;dbname=segells',$nomUsuari,$password);

for ($i = 0; $i < sizeof($anysLie); $i++) {
// for ($i = 13; $i < 85; $i++) {
	// http://localhost/segells/philatelie/basededonnees/index8cdf.html?p=fo&d=1975
	$url = "http://localhost/segells/philatelie/basededonnees/".$anysLie[$i];
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
$pais = "li";
//////////// INSERCIÓ //////////////////////
$insercio = $connexio->prepare('INSERT INTO li (any,imatge,yvert, michel, scott, id_pais)  VALUES (:any, :imatge, :yvert, :michel, :scott, :idPais)');


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
