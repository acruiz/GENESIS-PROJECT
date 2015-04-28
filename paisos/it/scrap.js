var request = require('request');
var cheerio = require('cheerio');
var mysql   = require('mysql');


var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : '',
	database: 'segells'
});

connection.connect();

//ejecuta: node scrap.js
var idPais = "it"; 
for (var i = 1843; i <= 1843; i++) {
	peticio(i);
};














//funcions
function descarregaEnBase64(url,cb) {
	var request = require('request').defaults({ encoding: null });

	request.get(url, function (error, response, body) {
		if (!error && response.statusCode == 200) {
			data = "data:" + response.headers["content-type"] + ";base64," + new Buffer(body).toString('base64');
			cb(data);
		}
	});
}
function peticio(any) {
	request("http://www.christophemaetz.fr/philatelie/basededonnees/?p=" + idPais + "&d=" + any, function (error, response, html) {
		if (!error && response.statusCode == 200) {
	  	//parseja html 
	  	var $ = cheerio.load(html);
	    //per cada element amb clase .bddCouleurTimbre
	    	$(".bddCouleurTimbre").each(function(index, el) {
		    	var valors = [];
		    	var any = $(el).find(".maintd").text();
		    	var imatgeUrl = $(el).find("img").attr("src");
		    	var filesCataleg = $(el).find("table").find("tr");


		    	valors.any = any;

		    	filesCataleg.each(function(index, el) {
		    		var cataleg = $(el).find("td").eq(0).text();
		    		var valor = $(el).find("td").eq(1).text();
		    		valors[cataleg] = valor;
		    	});
		    	
		    	descarregaEnBase64(imatgeUrl, function(data) {
		    		valors.imatge = data;
		    		var valorsPerInserir = [];
		    		valorsPerInserir.push(parseInt(valors.any));
		    		valorsPerInserir.push(valors.imatge);
		    		valorsPerInserir.push(valors["Yvert-et-Tellier"] != undefined ? valors["Yvert-et-Tellier"] : "");
		    		valorsPerInserir.push(valors["Michel"] != undefined ? valors["Michel"] : "");
		    		valorsPerInserir.push(valors["Scott"] != undefined ? valors["Scott"] : "");
		    		valorsPerInserir.push(valors["Edifil"] != undefined ? valors["Edifil"] : "");
		    		valorsPerInserir.push(valors["Unificato"] != undefined ? valors["Unificato"] : "");
		    		valorsPerInserir.push(valors["Cob"] != undefined ? valors["Cob"] : "");
		    		valorsPerInserir.push(idPais);

		    		//mostra els valors que s'han d'inserir
		    		console.log(valorsPerInserir);

		    		var consulta = "INSERT INTO " + idPais + "(any, imatge, yvert, michel, scott, edifil, unificato, cob, id_pais) VALUES(?,?,?,?,?,?,?,?,?)";

		    		connection.query({
		    			sql: consulta,
		    			values: valorsPerInserir
		    		}, function (error, results, fields) {
		    			if (error) {
		    				throw error;
		    			}
		    			console.log("insertat");
		    		});

	    		});

			});



		}
	});
}





