<?php


class Films{

	private $conn;
	private $uri;
	private $method;
	private $param;

	public function __construct($uri, $method, $param, $conn){
		$this->conn = $conn;
		$this->uri = $uri;
		$this->method = $method;
		$this->param = $param;

		/*

		* Выбираем какой запрос к нам пришел и вызываем определенный метод

		*/
		if ($this->uri)
			switch ($this->method) {
				case 'GET':
					echo json_encode($this->get());
					die();
				case 'POST':
					echo json_encode($this->post());
					die();
				case 'DELETE':
					echo json_encode($this->delete());
					die();
				case 'PATCH':
					echo json_encode($this->patch());
					die();
			}
	}


	private function get(){
		$array_res = [];

		if (!$this->param){

			/*
			*	Если запрос пришел без параметров, делаем обычный вывод всех фильмов
			*/
			$query = "SELECT films.id_film, films.film, genres.genre 
						FROM films 
						JOIN genres ON genres.id_genre = films.id_genre";

		} elseif (count($this->param) === 2){

			/*
			*	Если было 2 параметра, делаем фильтр по жанрам и актерам
			*/

			$key_1 = $this->param[0]['key'];
			$key_2 = $this->param[1]['key'];
			$val_1 = $this->param[0]['val'];
			$val_2 = $this->param[1]['val'];
			$query =   "SELECT films.id_film, films.film, genres.genre
						FROM films
						JOIN (SELECT *
							  FROM film_actor_m2m
						 	  WHERE id_$key_2 = $val_2) AS t
						ON films.id_film = t.id_film
						JOIN genres ON genres.id_genre = films.id_genre
						WHERE films.id_$key_1 = $val_1";
		} else {


			/*
			*	Если было 1 параметр, нужно понять сортировать или фильтровать данные
			*/


			if (!$this->param[0]['val']){
				

				/*
				*	Если нет значения параметра (после '-'), то это сортировка
				*/

				if ($this->param[0]['key'] === 'genre')

					/*
					*	Сортировка по жанрам у фильмов
					*/

					$query = "SELECT films.id_film, films.film, genres.genre
								FROM `films`
								JOIN genres ON genres.id_genre = films.id_genre
								ORDER BY films.id_genre";
				elseif ($this->param[0]['key'] === 'actor')

					/*
					*	Сортировка по количествам актеров у фильмов
					*/

					$query_sort = "SELECT t.id_film, films.film, t.cnt
									FROM films
									JOIN (SELECT id_film, COUNT(*) as cnt
									FROM film_actor_m2m
									GROUP BY id_film) AS t ON t.id_film = films.id_film
									ORDER BY t.cnt DESC";
				else
					return array('status' => false);
			} else {

				/*
				*	Если значение параметра есть, то это фильтрация
				*/


				if ($this->param[0]['key'] === 'genre'){

					/*
					*	Фильтраия по жанрам у фильмов
					*/

					$val = $this->param[0]['val'];
					$query = "SELECT films.id_film, films.film, genres.genre 
							FROM films 
							JOIN genres ON genres.id_genre = films.id_genre
							WHERE films.id_genre = $val
							";
				} elseif ($this->param[0]['key'] === 'actor'){


					/*
					*	Фильтраия по актерам у фильмов
					*/


					$val = $this->param[0]['val'];
					$query =   "SELECT films.id_film, films.film, genres.genre
								FROM films
								JOIN (SELECT *
								  	  FROM film_actor_m2m
									  WHERE id_actor = $val) AS t
								ON films.id_film = t.id_film
								JOIN genres ON genres.id_genre = films.id_genre";
				} elseif ($this->param[0]['key'] === 'id'){

					/*
					*	Фильтраия по id у фильмов
					*/


					$val = $this->param[0]['val'];
					$query = "SELECT films.id_film, films.film, genres.genre 
							FROM films 
							JOIN genres ON genres.id_genre = films.id_genre
							WHERE films.id_film = $val
							";
				} else {
					return array('status' => false);
				}
			}
		}


		/*
		* Возвращение массива полученного из запроса
		*/

		if (!$query_sort){

			/*
			* Если идет сортировка по актерам, то 3 ключь не жанр, а количество актеров
			*/

			$res = mysqli_query($this->conn, $query);
			if ($res){
				while ($row = mysqli_fetch_assoc($res)){
					$array_res[] = [
						'id_film' => $row['id_film'],
						'film' => $row['film'],
						'genre' => $row['genre'],
					];
				}
				return $array_res;
			}
			else
				return array('status' => false);
		} else {

			/*
			* Если идет сортировка по жанрам, то 3 ключь жанр
			*/

			$res = mysqli_query($this->conn, $query_sort);
			if ($res){
				while ($row = mysqli_fetch_assoc($res)){
					$array_res[] = [
						'id_film' => $row['id_film'],
						'film' => $row['film'],
						'count' => $row['cnt'],
					];
				}
				return $array_res;
			}
			else
				return array('status' => false);
		}

	}


	private function delete(){

		/*
		* Запрос на удаление определнного фильма по его id
		*/

		if ($this->param[0]['key'] === 'id' && $this->param[0]['val']){
			$val = $this->param[0]['val'];
			$query = "DELETE FROM `films` WHERE `films`.`id_film` = $val";
			$res = mysqli_query($this->conn, $query);
			if ($res)
				return array('status' => true);
			else
				return array('status' => false);
		}
		else
			return array('status' => false);
	}


	private function post(){

		/*
		* Запрос на добавление определнного фильма, данные передаются в formdata
		*/

		$id_genre = $_POST['id_genre'];
		$film = $_POST['film'];
		if ($id_genre && $film){
			$query = "INSERT INTO films (id_genre, film) VALUE ($id_genre, '$film')";
			$res = mysqli_query($this->conn, $query);
			if ($res)
				return array('status' => true);
			else
				return array('status' => false);
		}
		else
			return array('status' => false);
	}

	private function patch(){

		/*
		* Запрос на изменение данных определнного фильма, данные передаются в raw
		*/

		$id = $this->param[0]['val'];
		$data = file_get_contents('php://input');

		$data = json_decode($data);

		$id_genre = $data->id_genre;
		$film = $data->film;

		if ($this->param[0]['key'] === 'id' && $this->param[0]['val']){
			$query = "UPDATE `films` SET `id_genre` = '$id_genre', `film` = '$film' WHERE `films`.`id_film` = $id;";
			$res = mysqli_query($this->conn, $query);
			if ($res)
				return array('status' => true);
			else
				return array('status' => false);
		}
		else
			return array('status' => false);

	}

}


?>