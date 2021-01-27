<?php
require_once(realpath('app/queryes/database.php'));
require_once(realpath('app/queryes/api/films.php'));
require_once(realpath('app/queryes/api/actors.php'));
require_once(realpath('app/queryes/api/genres.php'));


function route($method, $uri){

	$param = [];


	/*
	* Распарсиваем параметры по которым определяется запрос
	*/
	for($i = 1; $i < count($uri); $i++){
		$dp = explode('-',$uri[$i]);
		$param[] = [
			'key' => $dp[0],
			'val' => $dp[1]
		];
	}

	switch ($uri[0]) {
		case 'films':
			$A = new Films($uri[0], $method, $param, (new Database)->getConnection());
			break;
		case 'actors':
			$A = new Actors($uri[0], $method, $param, (new Database)->getConnection());
			break;
		case 'genres':
			$A = new Genres($uri[0], $method, $param, (new Database)->getConnection());
			break;
		

	}

	
}


?>