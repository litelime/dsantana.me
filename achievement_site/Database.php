<?php
class DataBase {

		private $DB;

		public function __construct(){
			$db = 'mysql:dbname=u160287738_dsant;host=localhost';
			$user = 'u160287738_ftp';

			try{
				$this->DB = new PDO ($db, $user, db_password);
				$this->DB->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $e){
				echo ("Error Establishing Connection");
				exit();
			}
		}

		public function isValid($name){

			$stmt = $this->DB->prepare ("SELECT Name FROM Achievement WHERE Name=:name");
			$stmt ->bindParam(":name", $name);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
			return count($result);

		}

		public function insertAccount($name, $id){
			$stmt = $this->DB->prepare ("Insert Into Achievement Values (:name, :id)");
			$stmt->bindParam(":id", $id);
			$stmt->bindParam(":name", $name);
			$stmt->execute();
			return;
		}

		public function getSteamID($name){
			$stmt = $this->DB->prepare ("SELECT id, Name FROM Achievement WHERE Name=:name");
			$stmt ->bindParam(":name", $name);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_COLUMN);
			return $result[0];

		}
}


?>