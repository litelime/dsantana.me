<?php
class DataBase {

		private $DB;

		public function __construct(){
			$db = 'mysql:dbname=u632321490_image;host=sql122.main-hosting.eu';
			$user = 'u632321490_david';
			$password ='Silencedb1!';

			try{
				$this->DB = new PDO ($db, $user, $password);
				$this->DB->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $e){
				echo ("Error Establishing Connection");
				exit();
			}
		}

		public function getYears(){
			$stmt = $this->DB->prepare ("SELECT DISTINCT YearTaken FROM `Image`");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		public function getNamesOfYear($year){
			$stmt = $this->DB->prepare ("SELECT Filename FROM `Image` WHERE YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}		
}

?>