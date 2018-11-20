<?php

/*
DataBase

This class used for a PDO database connection. 

*/
include 'pass.php';

class DataBase {

		private $DB;

		public function __construct(){

			//my db connection
			$db = 'mysql:dbname=u160287738_dsant;host=localhost';
			$user = 'u160287738_ftp';

			//try connection print error if exception caught
			try{
				$this->DB = new PDO ($db, $user, db_password);
				$this->DB->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch (PDOException $e){
				echo ("Error Establishing Connection");
				exit();
			}
		}

		/* getYears()

			get from the db all the unique year values 
			in the form of a single column array.
			Ex: [2014, 2015, 2015]      */
		public function getYears(){
			$stmt = $this->DB->prepare ("SELECT DISTINCT YearTaken FROM `Image`");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		/* getIsos

			get all the unique iso values in the form 
			of a single column array
			Ex: [100,400,1600]            */
		public function getIsos($year){
			$stmt = $this->DB->prepare ("SELECT DISTINCT ISO FROM `Image` where YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}
    
    	/* getTimes
    		get all unique exposure times in the form
    		of a single column array. 
    		Ex: [1/60, 1, 4, 1/1000]         */
        public function getTimes($year){
			$stmt = $this->DB->prepare ("SELECT DISTINCT ExposureTime FROM `Image` where YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		/*    getNamesOfYearWithAttributes

			retrieves a single column array of fileNames.
			Always select based on a given year. 
			Optionally select based on iso and time as well. 
			iso and time should be set to 'false' if not desired to be used
		*/
		public function getNamesOfYearWithAttributes($year, $iso, $time){
            $query = "SELECT Filename FROM `Image` WHERE YearTaken={$year}";
            
            //if we want time add it on. 
            if($time!='false')
                $query = $query . " AND ExposureTime='{$time}'";
            if($iso!='false')
                $query = $query . " AND ISO={$iso}";
            
			$stmt = $this->DB->prepare ($query);
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}

		/* 		getNamesOfYear.
			get all fileNames for a given year. 
		*/
		public function getNamesOfYear($year){
			$stmt = $this->DB->prepare ("SELECT Filename FROM `Image` WHERE YearTaken={$year}");
			$stmt->execute();
			return $stmt->fetchAll(PDO::FETCH_COLUMN);
		}		
}

?>