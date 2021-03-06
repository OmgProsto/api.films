<?php


class Actors {


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
			}
	}


	private function get(){
		$array_res = [];

		if (!$this->param){

			$query = "SELECT * FROM actors";
		} elseif (count($this->param) === 1 && $this->param[0]['key'] === 'id' && $this->param[0]['val']){
			$id = $this->param[0]['val'];
			$query = "SELECT * FROM actors WHERE id_actor = $id";
		}


		$res = mysqli_query($this->conn, $query);
		if ($res){
			while ($row = mysqli_fetch_assoc($res)){
				$array_res[] = [
					'id_actor' => $row['id_actor'],
					'actor' => $row['actor'],
				];
			}
			return $array_res;
		}
		else
			return array('status' => false);
	}


	private function post(){


		$actor = $_POST['actor'];

		if ($actor){
			$val = $this->param[0]['val'];
			$query = "INSERT INTO `actors` (actor) VALUES  ('$actor')";
			$res = mysqli_query($this->conn, $query);
			if ($res)
				return array('status' => true);
			else
				return array('status' => false);
		}
		else
			return array('status' => false);

	}

	private function delete(){



		if ($this->param[0]['key'] === 'id' && $this->param[0]['val']){
			$val = $this->param[0]['val'];
			$query = "DELETE FROM `actors` WHERE `actors`.`id_actor` = $val";
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
