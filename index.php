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

	$count_movies = count($movies);
	$genre_list = [];

	// We put all the categories together in an arrangement.
	foreach($movies as $list) {
		foreach($list["genre"] as $genre) {
			$genre_list[]=$genre;
		}
	}
	
	$order_unique = array_values(array_unique($genre_list)); // then we extract the ones that are not repeated and then we reset their indexes.
	
	$newArray = [];
	$tag_id = [];

	//Once separated by categories, the indices are extracted.
	foreach($movies as $key => $index) {
		foreach($index["genre"] as $genre){
			if(in_array($genre,$order_unique)) {
				$tag_id[$genre]["id"][] = $key;
			}
		}
	}

	// Finally, information is extracted with the organized indices.
	foreach($tag_id as $genre => $index) {
		$newArray[$genre]["name"] = $genre;
		$newSum = [];
		foreach($index["id"] as $list => $ok){
			$newSum[]=intval($movies[$ok]["runtime"]);
			$newArray[$genre]["total_movies"] += 1;
			$newArray[$genre]["average_minutes"] = "";
			$newArray[$genre]["total_minutes"] = "";
			$newArray[$genre]["movies"][$list]["title"] = $movies[$ok]["title"];
			$newArray[$genre]["movies"][$list]["runtime"] = $movies[$ok]["runtime"];
			$newArray[$genre]["movies"][$list]["year"] = $movies[$ok]["year"];
			$newArray[$genre]["movies"][$list]["director"] = $movies[$ok]["director"];
			$newArray[$genre]["movies"][$list]["writer"] = $movies[$ok]["writer"];
			$newArray[$genre]["movies"][$list]["actors"] = $movies[$ok]["actors"];
			$newArray[$genre]["movies"][$list]["plot"] = $movies[$ok]["plot"];
			$newArray[$genre]["movies"][$list]["lenguage"] = $movies[$ok]["lenguage"];
			
		}

		$countArray = count($newSum); // we count the values
		$sumArray = array_sum($newSum); //returns the sum of all the values in the array
		$newArray[$genre]["average_minutes"] = round($sumArray/$countArray); //we average the array
		$newArray[$genre]["total_minutes"] = $sumArray; // returns the sum
		
	}
	// print_r($newArray);

	/*Ïmprime contenido del Json*/
	// print_r(json_encode($movies, JSON_PRETTY_PRINT));

	/*Ïmprime contenido del nuevo Array*/
	print_r(json_encode($newArray, JSON_PRETTY_PRINT));
?>