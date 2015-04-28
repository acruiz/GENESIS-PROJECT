<meta charset="UTF-8">
<?php
try {
 $pdo= new PDO('mysql:dbname=segells;host=localhost','root','');//USAR PDO!!!!
 } catch (PDOException $e) {
 echo 'Connection failed: ' . $e->getMessage();
 }
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function scrape_between($data, $start, $end) {
	$data2 = stristr($data, $start);
 // Stripping all data from before $start
	$data2 = substr($data2, strlen($start));
 // Stripping $start
	$stop = stripos($data2, $end);
 // Getting the position of the $end of the data to scrape
	$data2 = substr($data2, 0, $stop);
 // Stripping all data from after and including the $end of the data to scrape
	return $data2;
 // Returning the scraped data from the function
}

for ($data = 1840; $data <= 2013; $data++) {
	$url = "http://www.christophemaetz.fr/philatelie/basededonnees/?p=fr&d=".$data;
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
    //var_dump($title[0]); //var_dump dirà quantes imatges hi ha a la pàgina
	//$num_segells = count($title[0]);
	for($item=0;$item<count($title[0]);$item++){
		$pais= "fr";
		$any = $data;
		$img = scrape_between((string)$title[0][$item],"<img src='","'");
		$img = file_get_contents($img);
		$img = base64_encode($img);
		$yevet=scrape_between((string)$title[0][$item],"Yvert-et-Tellier</td><td align=\"right\">","</td>");
		$michel=scrape_between((string)$title[0][$item],"Michel</td><td align=\"right\">","</td>");
		$scott=scrape_between((string)$title[0][$item],"Scott</td><td align=\"right\">","</td>");
		if(!$pdo->query("INSERT INTO `fr` (`any`, `imatge`, `yvert`, `michel`, `scott`, `edifil`, `unificato`, `cob`, `id_pais`) VALUES ($any , '$img', '$yevet', '$michel', '$scott', '', '', '', 'fr')")){
				echo "no se ha insterado";
		}else{
			echo "Inserción correcta <br>";
		}
	}
}
