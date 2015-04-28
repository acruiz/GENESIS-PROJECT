<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />


<?php
header('Content-Type: text/html; charset=ISO-8859-1');

/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////VARIABLES INFO DE LA PAGINA////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
//URL principal
$urlp='http://localhost/genesis/christophemaetz/philatelie/basededonnees/';
//URL de Allemagne(République Démocretique) --> Años (1949-1990) -->Referencias(3445) --> ID(dd-de)
$url_dd_de='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index0205.html?p=dd-de';
//URL de Allemagne(République Fédérale) --> Años (1949-2004) -->Referencias(2403) --> ID(de)
$url_de='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index0deb.html?p=de';
$classAnys='bddContenuOnglet bddContenuOnglet_annee';
$classFilas='bdd';
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////FUNCIONES/////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////
//****Funcion que sacara el html de la url****//
////////////////////////////////////////////////
function curl($url) {
	// Setting the useragent
	$options = Array(	CURLOPT_RETURNTRANSFER => TRUE, 
						CURLOPT_FOLLOWLOCATION => TRUE, 
						CURLOPT_AUTOREFERER => TRUE, 
						CURLOPT_CONNECTTIMEOUT => 120,
						CURLOPT_TIMEOUT => 120,  
						CURLOPT_MAXREDIRS => 10, 
						CURLOPT_USERAGENT => "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8", 
						CURLOPT_URL => $url, );
	// Initialising cURL
	$ch = curl_init();
	// Setting cURL's options using the previously assigned array data in $options
	curl_setopt_array($ch, $options);
	// Executing the cURL request and assigning the returned data to the $data variable
	$data = curl_exec($ch);
	// Closing cURL
	curl_close($ch);
	// Returning the data from the function    
	return $data;
}

////////////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que retornara los nodos de la url que se adapten a la expresion pasada por parametro****//
///////////////////////////////////////////////////////////////////////////////////////////////////////
function dameDiv($url,$expr){
	$doc = new DOMDocument();
	$doc->preserveWhiteSpace = false;
	//@$doc->loadHTML($url);
	@$doc->loadHTML(curl($url));
	$finder = new DomXPath($doc);
	$spaner = $finder->query($expr);
	return $spaner;
}
/////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que retornara una array con el contenido de la expresion pasada por parametro****//
/////////////////////////////////////////////////////////////////////////////////////////////////
function returnD($url,$expr){
	$paraules=dameDiv($url,$expr);
	$a=array();
	$i=0;
		
	foreach($paraules as $node) {
		$a[$i]=$node->nodeValue;
		$i++;
	}
	return $a;
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que retornara en una array los enlaces que uniendolos con la url principal nos llevaran a cada año****//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function trobaHrefAny($url,$class){
	$array=returnD($url,"//div[@class='$class']/ul[@class='date']/a/@href");
	return $array;
}

////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que pasandole los href por array retornara en una array las URLs de cada año****//
////////////////////////////////////////////////////////////////////////////////////////////////
function trobaUrlAny($url,$array){
	$urlA=array();
	for($i=0;$i<count($array);$i++){
		$urlA[$i]=$url.$array[$i];
	}
	return $urlA;
}
////////////////////////////////////////////////////////
//****Funcion que retornara en una array los años****//
///////////////////////////////////////////////////////
function donamiQuantitat($url,$classF){
	$a=returnD($url,"//table[@id='myTable']/tbody/tr[contains(@class, '$classF')]/td[@class='bL bB maintd']");
	return $a;
}
///////////////////////////////////////////////////////////////////////
//****Funcion que retornara en una array los src de las imagenes****//
/////////////////////////////////////////////////////////////////////
function donamiImg($url,$classF){
	$a=returnD($url,"//table[@id='myTable']/tbody/tr[contains(@class, '$classF')]/td[@class='bL bB bR']/img/@src");
	return $a;
}
////////////////////////////////////////////////////////////////////
//****Funcion que retornara en una array todas las categorias****//
///////////////////////////////////////////////////////////////////
function donamiTot($url,$classF){
	$a=returnD($url,"//table[@id='myTable']/tbody/tr[contains(@class, '$classF')]/td[@class='bB bR']//tr/..");
	return $a;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que retornara en una array todas las URLs de los años apartir de la url principal y la url del pais****//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function donamiUrl($urlpri,$url,$classA){
	//Array que contendra todas las URL de cada año
	$miurl=array();
	//Aray que retornara lo el href de los enlaces a la url de cada año
	$arrayAnysHref=trobaHrefAny($url,$classA);
	//Array que retornara las urls completas de cada año
	$arrayAnysUrl=trobaUrlAny($url,$arrayAnysHref);
	//Poner todas las URL de los años en las arrays miurlOrigin
	for($d=0;$d<count($arrayAnysUrl);$d++){
		$miurl[$d]=$urlpri.$arrayAnysHref[$d];
	}
	return $miurl;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////FUNCION PRINCIPAL////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//****Funcion que insertara en la base de datos segells, en la tabla especificada los datos del pais que en la url hace referencia****//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function inserta($inici,$final,$miurl,$classFilas,$tabla){
	/////////////////CONNEXIO/////////////////
	$host = 'localhost';
	$username= 'root';
	$password = '';
	$dbname = 'segells';
	$connexio = new mysqli($host,$username,$password,$dbname);
	/////////////////////////////////////////////
	$arrayAnys=array();
	$i=0; //index arrays
	for($m=$inici;$m<$final;$m++){
		//Anys
		$arrayAnys[$i]=donamiQuantitat($miurl[$m],$classFilas);
		//Quantitat de segells
		$quants=count($arrayAnys[$i]);
		//Array que contindra tot el que esta a les categories
		$arrayComprova=donamiTot($miurl[$m],$classFilas);
		//Array que contiene las imagenes
		$arrayImgs[$m]=donamiImg($miurl[$m],$classFilas);
		echo "<br>---------------------------------<br>".$arrayAnys[$i][0]."<br>---------------------------------<br>";
		for($a=0;$a<$quants;$a++){
			//Cogemos todo el texto que hay en las columnas de caracteristicas
			//Como esta codificado en ISO lo decoedificamos a un sencillo Byte ISO(para poder leer ñ , acentos y caracteres, ya que sino salen caracteres raros)
			$tots=utf8_decode($arrayComprova[$a]);
			//Comprobamos si esta Michel
			$ma=strpos(trim($tots), "Michel");
			//Comprobamos si esta Yvert
			$yv=strpos(trim($tots), "Yvert-et-Tellier");
			//Si esta Michel
			if($ma!==false){
				//Si esta Yvert
				if($yv!==false){
					//Almacenamos a Michel, que sera desde el principi, hasta Yvert(ya que Yvert esta en la segunda posicion)
					$michel=substr(trim($tots), 0, $yv);
					echo "<br>".$michel."<br>";
					//Comprobamos si esta Scott apartir de Yvert(no desde el principio de la cadena, osea Michel se olvida)
					$sc=strpos(substr(trim($tots), $yv), "Scott");
					//Si esta Scott
					if($sc!==false){
						//ALmacenamos a Yvert
						$yvert=substr(trim($tots), $yv,$sc);
						echo $yvert."<br>";
						//Almacenamos a Scott a partir de la posicion de Yvert
						$scott=substr(substr(trim($tots), $yv), $sc);
						echo $scott."<br>";
					}
					//Si no esta Scott
					else{
						//ALmacenamos a Yvert
						$yvert=substr(trim($tots), $yv);
						echo $yvert."<br>";
						$scott="Scott";
						echo $scott."<br>";
					}
				}
				//Si no esta Yvert
				else{
					//Comprobamos si esta Scott apartir del principio de la cadena
					$sc=strpos(trim($tots), "Scott");
					$yvert="Yvert-et-Tellier";
					//Si esta Scott
					if($sc!==false){
						//Almacenamos a Michel, que sera desde el principi, hasta Yvert(ya que Yvert esta en la segunda posicion)
						$michel=substr(trim($tots), 0, $sc);
						echo $michel."<br>";
						$scott=substr(trim($tots), $sc);
						echo $scott."<br>";
					}
					//Si no esta Scott
					else{
						$michel=substr(trim($tots), 0);
						$scott="Scott";
						echo $michel."<br>";
						echo $scott."<br>";
					}
					echo $yvert;
				}
			}
			else{
				echo "NO HAY MICHEL****ALGO PASA CON MICHEEL! (-.-) MICHEL SIEMPRE ESTA! :'O";
			}
			
			//Para las imagenes
			$image[$i][$a] = $arrayImgs[$m][$a];
			// Read image path, convert to base64 encoding
			$imageData[$i][$a] = base64_encode(file_get_contents($image[$i][$a]));
			// Format the image SRC:  data:{mime};base64,{data};
			$src[$i][$a] = 'data: '.base64_decode($image[$i][$a]).';base64,'.$imageData[$i][$a];
			echo $src[$i][$a]."<br>";

			$michel=substr($michel, 6);
			$scott=substr($scott, 5);
			$yvert=substr($yvert, 16);

			$sql = "INSERT INTO ".$tabla."(id_pais,any,imatge,michel,scott,yvert) VALUES ('".$tabla."','".(int)$arrayAnys[$i][$a]."','".$src[$i][$a]."','".$michel."','".$scott."','".$yvert."')";
			$connexio -> query($sql);
		}
	}
	$i++;	
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////LLAMADAS//////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
$miurlOrigin_dd_de=donamiUrl($urlp,$url_dd_de,$classAnys);
$miurlOrigin_de=donamiUrl($urlp,$url_de,$classAnys);

//Decomentar para ir ejecutando
//inserta(0,20,$miurlOrigin_dd_de,$classFilas,'dd_de');
//inserta(20,42,$miurlOrigin_dd_de,$classFilas,'dd_de');
//inserta(0,20,$miurlOrigin_de,$classFilas,'de');
//inserta(20,40,$miurlOrigin_de,$classFilas,'de');
//inserta(40,56,$miurlOrigin_de,$classFilas,'de');

?>
</html>
