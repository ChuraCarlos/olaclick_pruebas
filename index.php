<?php

	/*
		Realizar un json de Peliculas Agrupados por Categorías, en base al archivo movies.json, calcular la cantidad de peliculas por categorias y el promedio en minutos.

		Ejemplo:
		{
			"Comedy": {
		        "name": "Comedy",
		        "total_movies": 2,
		        "average_minutes": 43,
		        "total_minutes": 86,
		        "movies": [
		            {
		                "title": "Vikings",
		                "runtime": 44,
		                "year": "2013\u2013",
		                "director": "N\/A",
		                "writer": "Michael Hirst",
		                "actors": "Travis Fimmel, Clive Standen, Gustaf Skarsg\u00e5rd, Katheryn Winnick",
		                "plot": "The world of the Vikings is brought to life through the journey of Ragnar Lothbrok, the first Viking to emerge from Norse legend and onto the pages of history - a man on the edge of myth.",
		                "lenguage": "English, Old English, Norse, Old, Latin"
		            },
		            {
		                "title": "Gotham",
		                "runtime": 42,
		                "year": "2014\u2013",
		                "director": "N\/A",
		                "writer": "Bruno Heller",
		                "actors": "Ben McKenzie, Donal Logue, David Mazouz, Sean Pertwee",
		                "plot": "The story behind Detective James Gordon's rise to prominence in Gotham City in the years before Batman's arrival.",
		                "lenguage": "English"
		            }
		        ]
		    }
	 	}
	 	######################
			Postulante: carlos alberto chura flores
			Fecha: 09/03/2023
			Telefono: 930918603
			Corre: chura.f5@gmail.com
		######################
	*/
	header('Content-type: application/json;');
	$url = './movies.json'; // path to your JSON file
	$data = file_get_contents($url); // put the contents of the file into a variable
	$movies = json_decode($data, true);

	$newArray = [];
	$total_movies = [];

	// We put all the categories together in an arrangement.
	foreach($movies as $list) {
		foreach($list["genre"] as $genre) {
			
			
			if(!isset($newArray[$genre]["movies"])) {	// check if array exists
				$row = 0;
			}else{
				$row = count($newArray[$genre]["movies"]);
			}
			if(!isset($newArray[$genre]["total_movies"])) {	// check if array exists
				$newArray[$genre]["total_movies"]=0;
			}
			
			$newArray[$genre]["name"] = $genre;
			$newArray[$genre]["total_movies"] += 1; // We add the interactions for each category

			$total_movies[$genre][] = $list["runtime"]; // we keep the minutes of the movies in an array
			$countArray = count($total_movies[$genre]); // we count the values
			$sumArray = array_sum($total_movies[$genre]); //returns the sum of all the values in the array
			$round_minute = round($sumArray/$countArray); // we round off the sum
			$newArray[$genre]["average_minutes"] = $round_minute; 
			$newArray[$genre]["total_minutes"] = $sumArray;
			
			$newArray[$genre]["movies"][$row]["title"] = $list["title"];
			$newArray[$genre]["movies"][$row]["runtime"] = $list["runtime"];
			$newArray[$genre]["movies"][$row]["year"] = $list["year"];
			$newArray[$genre]["movies"][$row]["director"] = $list["director"];
			$newArray[$genre]["movies"][$row]["writer"] = $list["writer"];
			$newArray[$genre]["movies"][$row]["actors"] = $list["actors"];
			$newArray[$genre]["movies"][$row]["plot"] = $list["plot"];
			$newArray[$genre]["movies"][$row]["lenguage"] = $list["lenguage"];
		}
	}
	
	/*Ïmprime contenido del Json*/
	// print_r(json_encode($movies, JSON_PRETTY_PRINT));

	/*Ïmprime contenido del nuevo Array*/
	print_r(json_encode($newArray, JSON_PRETTY_PRINT));
?>