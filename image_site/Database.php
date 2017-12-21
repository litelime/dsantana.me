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

		public function getIsos($year){
			$stmt = $this->DB->prepare ("SELECT DISTINCT ISO FROM `Image` where YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}
    
        public function getTimes($year){
			$stmt = $this->DB->prepare ("SELECT DISTINCT ExposureTime FROM `Image` where YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		public function getNamesOfYearWithAttributes($year, $iso, $time){
            $query = "SELECT Filename FROM `Image` WHERE YearTaken={$year}";
            
            if($time!='false')
                $query = $query . " AND ExposureTime='{$time}'";
            if($iso!='false')
                $query = $query . " AND ISO={$iso}";
            
			$stmt = $this->DB->prepare ($query);
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