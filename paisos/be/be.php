<?php
for ($data = 2001; $data <= 2001; $data++) {
	$url = "http://localhost/philatelie/basededonnees/indexf726.html?p=be&d=2001".$data;
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
	
	$dir = "";
	//preg_match_all("(<td class=\"bL bB maintd\">1931</td>(.*)</table>)siU", $result , $title);
	preg_match_all("(<tr class=\"bddCouleurTimbre\">(.*)</table>)siU", $result , $title);//per a saber quantes imatges hi ha
    //var_dump($title); //var_dump dirà quantes imatges hi ha a la pàgina
	$num_segells = count($title[0]);

		$mysqli = new mysqli("localhost", "root", "", "segells");//USAR PDO!!!!
		if ($mysqli->connect_errno) {
			echo "Falla la conexió MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		};

		//$conexion = new PDO('mysql:host=localhost;dbname=segells','root','');
		
		for ($x = 0; $x < $num_segells; $x++) {
			for ($y = 0; $y <=  908; $y++) {
				//var_dump($title[0]);
				$dir .= $title[0][$x][$y]; //guardo tota la url a dir
			} 
			//f = foto; a = any; p = pais; c = cataleg; y = Yvert-et-Tellier; e = Edifil; m = Michel; s = Scott;
			preg_match("(src='(.*)')siU", $dir, $f); //trec tot el que hi ha abans del http
			preg_match("(<td class=\"bL bB maintd\">(.*)</td>)siU", $dir, $a); //agafo l'any
			preg_match("(scans/(.*)/)siU", $dir, $p); //agafo el pais
			preg_match("(Yvert-et-Tellier</td><td align=\"right\">(.*?)</td>)", $dir, $y); //agafo el YT
			preg_match("(COB</td><td align=\"right\">(.*?)</td>)", $dir, $COB); //agafo el COB
			preg_match("(Michel</td><td align=\"right\">(.*?)</td>)", $dir, $m); //agafo el Mi
			preg_match("(Scott</td><td align=\"right\">(.*?)</td>)", $dir, $s); //agafo el SC
			echo $p[1]."<br><br>";
			echo $a[1]."<br><br>";
			echo $f[1]."<br><br>";


			$pais = $p[1];
			$any = $a[1];
			$img = $f[1];
			$img = file_get_contents($img);
			$img = base64_encode($img);
			echo $dir."<br><br>";
			$id_pais = "be";
							
							
					$mysqli->query("INSERT INTO be (any, imatge, yvert, michel, scott, cob, id_pais) VALUES ('$any', '$img', '$y[1]', '$m[1]', '$s[1]', '$COB[1]', '$id_pais')");
					
	if (!$mysqli->query("INSERT INTO be (any, imatge, yvert, michel, scott, cob, id_pais) VALUES ('$any', '$img', '$y[1]', '$m[1]', '$s[1]', '$COB[1]', '$id_pais'")) {
    	echo "Error :@" . $mysqli->errno . ") " . $mysqli->error;
		echo "<br />";
	};
					/*$sql = $conexion->prepare("INSERT INTO be ('id' , 'any', 'imatge', 'yvert', 'michel', 'scott', 'cob', 'id_pais') VALUES (:pais , :any, :img, :yvert, :michel, :scott, :cob, :id_pais)");
					$sql->bindParam(':pais', $pais);
					$sql->bindParam(':any', $any);
					$sql->bindParam(':img', $img);
					$sql->bindParam(':yvert', $y[1]);
					$sql->bindParam(':michel', $m[1]);
					$sql->bindParam(':scott', $s[1]);
					$sql->bindParam(':cob', $COB[1]);
					$sql->bindParam(':id_pais', $id_pais);
					$sql->execute();*/
					
					
			
			$dir='';
		};
	};
//echo 'Valors enregistrats correctament'."<br><br>";


?>
