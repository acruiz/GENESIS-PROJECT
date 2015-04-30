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
//URL de Bosnie-Herzégovine (République Serbe) --> Años (1992-2007) -->Referencias(469) --> ID(ba-srp)
$url_ba_srp='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index51c0.html?p=ba-srp';
//URL de Nations Unies (Genève) --> Años (1969-2004) -->Referencias(540) --> ID(onu-g)
$url_onu_g='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index465f.html?p=onu-g';
//URL de Nations Unies (Vienne) --> Años (1979-2005) -->Referencias(481) --> ID(onu-w)
$url_onu_w='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index5226.html?p=onu-w';
//URL de  Polynésie française --> Años (1958-2005) -->Referencias(1023) --> ID(pf)
$url_pf='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index7021.html?p=pf';
//URL de  Terres Australes et Antarctiques Françaises --> Años (1955-2005) -->Referencias(606) --> ID(tf-aq)
$url_tf_aq='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index3440.html?p=tf-aq';
//URL de  Slovénie --> Años (1991-2008) -->Referencias(860) --> ID(si)
$url_si='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index2c71.html?p=si';
//URL de République monastique du Mont Athos --> Años (2008-2011) -->Referencias(89) --> ID(gr-69)
$url_gr_69='http://localhost/genesis/christophemaetz/philatelie/basededonnees/index69ee.html?p=gr-69';
//Clase que contiene los años
$classAnys='bddContenuOnglet bddContenuOnglet_annee';
//Clase que contiene las categorias
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
//$inici -> numero que dira en que año empezar segun su posicion en la array de años (el primero (0), el segundo(1)...).
//$final -> numero que dira en que año terminar segun su posicion en la array de años (el quinto(4), el sexto(5)....).
//$miurl -> array que contiene todas las URL de cada año del pais.
//$classFilas -> clase en donde esta la informacion de los sellos (para saber cuantos sellos hay).
//$tabla -> nombre de la tabla en la base de datos segells.
//$textPrimer -> nombre de la primera categoría.
//$textSegon -> nombre de la segunda categoría.
//$textTercer -> nombre de la tercera categoría.
//$primerCamp -> nombre del primer campo de la tabla para insertar la primera categoria.
//$segonCamp -> nombre del segundo campo de la tabla para insertar la segunda categoria.
//$tercerCamp -> nombre del tercer campo de la tabla para insertar la tercera categoria.
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function inserta($inici,$final,$miurl,$classFilas,$tabla,$textPrimer,$textSegon,$textTercer,$primerCamp,$segonCamp,$tercerCamp){
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
			//Comprobamos si esta la primera categoria
			$pC=strpos(trim($tots), $textPrimer);
			//Comprobamos si esta la segunda categoria
			$sC=strpos(trim($tots), $textSegon);
			
			//Si esta la primera categoria
			if($pC!==false){
				//Si esta la segunda categoria y la primera
				if($sC!==false){
					//Almacenamos a la primera categoria, que sera desde el principi, hasta la segunda categoria
					$primeraCat=substr(trim($tots), 0, $sC);
					echo "<br>".$primeraCat."<br>";
					//Comprobamos si esta la tercera categoria apartir de la segunda
					$tC=strpos(substr(trim($tots), $sC), $textTercer);
					//Si esta la tercera y la primera y la segunda
					if($tC!==false){
						//Almacenamos la segunda
						$segundaCat=substr(trim($tots), $sC,$tC);
						echo $segundaCat."<br>";
						//Almacenamos a la tercera categoria a partir de la segunda
						$terceraCat=substr(substr(trim($tots), $sC), $tC);
						echo $terceraCat."<br>";
					}
					//Si no esta la tercera categoria y si esta la primera y la segunda
					else{
						//Almacenamos la segunda
						$segundaCat=substr(trim($tots), $sC);
						echo $segundaCat."<br>";
						$terceraCat=$textTercer;
						echo $terceraCat."<br>";
					}
				}
				//Si no esta la segunda categoria y si la primera
				else{
					$segundaCat=$textSegon;
					//Comprobamos si esta la tercera categoria a partir de la primera
					$tC=strpos(substr(trim($tots), $pC), $textTercer);
					//Si esta la tercera categoria y la primera y no la segunda
					if($tC!==false){
						$primeraCat=substr(trim($tots), 0, $tC);
						echo "<br>".$primeraCat."<br>";
						$terceraCat=substr(substr(trim($tots), $pC), $tC);
						echo $terceraCat."<br>";
					}
					//Si no esta la tercera ni la segunda y si la primera
					else{
						$primeraCat=$tots;
						echo $segundaCat."<br>";
						$terceraCat=$textTercer;
						echo $terceraCat."<br>";
					}
					echo $segundaCat;
				}
			}
			//Si no esta la primera categoria
			else{
				$primeraCat=$textPrimer;
				$tC=strpos(substr(trim($tots), $sC), $textTercer);
				//Si esta la segunda y no esta la primera
				if($sC!==false){
					//Si esta la tercera y la segunda y no esta la primera
					if($tC!==false){
						$segundaCat=substr(trim($tots), 0, $tC);
						echo "<br>".$segundaCat."<br>";
						$terceraCat=substr(trim($tots), $tC);
						echo $terceraCat."<br>";
					}
					//Si no esta la primera ni la tercera y si la segunda
					else{
						$segundaCat=$tots;
						echo "<br>".$segundaCat."<br>";
						$terceraCat=$textTercer;
						echo $terceraCat."<br>";
					}
				}
				//Si no esta la segunda categoria ni la primera
				else{
					$segundaCat=$textSegon;
					//Si esta la tercera y no esta ni la segunda ni la primera
					if($tC!==false){
						$terceraCat=$tots;
						echo $terceraCat."<br>";
					}
					//Si no esta la tercera ni la segunda
					else{
						$terceraCat=$textTercer;
						echo $terceraCat."<br>";
					}
				}
				echo $segundaCat;
			}
				
			//Para las imagenes
			$image[$i][$a] = $arrayImgs[$m][$a];
			// Read image path, convert to base64 encoding
			$imageData[$i][$a] = base64_encode(file_get_contents($image[$i][$a]));
			// Format the image SRC:  data:{mime};base64,{data};
			$src[$i][$a] = 'data: '.base64_decode($image[$i][$a]).';base64,'.$imageData[$i][$a];
			echo $src[$i][$a]."<br>";

			$numPrimer=strlen($textPrimer);
			$numSegon=strlen($textSegon);
			$numTercer=strlen($textTercer);
			$primeraCat=substr($primeraCat, $numPrimer);
			$segundaCat=substr($segundaCat, $numSegon);
			$terceraCat=substr($terceraCat, $numTercer);
			

			$sql = "INSERT INTO ".$tabla."(id_pais,any,imatge,".$primerCamp.",".$segonCamp.",".$tercerCamp.") VALUES ('".$tabla."','".(int)$arrayAnys[$i][$a]."','".$src[$i][$a]."','".$primeraCat."','".$segundaCat."','".$terceraCat."')";
			$connexio -> query($sql);
		}
	}
	$i++;	
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////LLAMADAS//////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////A cada país le pertenece una array que contiene las URLs de los años///////////
$miurlOrigin_dd_de=donamiUrl($urlp,$url_dd_de,$classAnys);
$miurlOrigin_de=donamiUrl($urlp,$url_de,$classAnys);
$miurlOrigin_ba_srp=donamiUrl($urlp,$url_ba_srp,$classAnys);
$miurlOrigin_onu_g=donamiUrl($urlp,$url_onu_g,$classAnys);
$miurlOrigin_onu_w=donamiUrl($urlp,$url_onu_w,$classAnys);
$miurlOrigin_pf=donamiUrl($urlp,$url_pf,$classAnys);
$miurlOrigin_tf_aq=donamiUrl($urlp,$url_tf_aq,$classAnys);
$miurlOrigin_si=donamiUrl($urlp,$url_si,$classAnys);
$miurlOrigin_gr_69=donamiUrl($urlp,$url_gr_69,$classAnys);


///////////Descomentar cada linea para mostrar e insertar los datos a la base de datos segells/////////
/*********************************Allemagne(République Démocretique)*********************************/
//inserta(0,42,$miurlOrigin_dd_de,$classFilas,'dd_de',"Michel","Yvert-et-Tellier","Scott","michel","yvert","scott");
/*********************************Allemagne(République Fédérale)*********************************/
//inserta(0,56,$miurlOrigin_de,$classFilas,'de',"Michel","Yvert-et-Tellier","Scott","michel","yvert","scott");
/*********************************Bosnie-Herzégovine (République Serbe)*********************************/
//inserta(0,15,$miurlOrigin_ba_srp,$classFilas,'ba_srp',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/********************************* Nations Unies (Genève) *********************************/
inserta(0,36,$miurlOrigin_onu_g,$classFilas,'onu_g',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/*********************************Nations Unies (Vienne)*********************************/
//inserta(0,27,$miurlOrigin_onu_w,$classFilas,'onu_w',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/*********************************Polynésie française *********************************/
//inserta(0,47,$miurlOrigin_pf,$classFilas,'pf',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/*********************************Terres Australes et Antarctiques Françaises *********************************/
//inserta(0,49,$miurlOrigin_tf_aq,$classFilas,'tf_aq',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/*********************************Slovénie*********************************/
//inserta(0,17,$miurlOrigin_si,$classFilas,'si',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");
/*********************************République monastique du Mont Athos*********************************/
//inserta(0,4,$miurlOrigin_gr_69,$classFilas,'gr_69',"Yvert-et-Tellier","Michel","Scott","yvert","michel","scott");


	
?>
</html>
