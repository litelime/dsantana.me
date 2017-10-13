<!DOCTYPE html>

<html>
	<head>
		<title>David Santana's Photos</title>
		<link href="./image.css?ver=1.0" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="./prototype.js"></script>
		<script type="text/javascript" src="./image.js?ver=1.0"></script>

	</head>

	<body>

		<?php

			$allExif=getAllExif();

			$dates = getDates($allExif);

			$year="2017";

			if(isset($_POST['year'])){

				$year=$_POST['year'];

			}else{

				$randIndex=rand(1,sizeof($allExif)-1);

				$randFile=$allExif[$randIndex]["FileName"];
				$randPath="../Fotos/".$randFile;

				$years  = getYears($dates);

				echo '<div id="mainBox">';
				echo '<img id="main" src="';
				echo $randPath;
				echo '">';
				echo "</div>";

				echo "<div id='allPhotosBox'>";

				echo '<div id="selectBox">';
				//SELECT BOXES
		 		echo "<select disabled='disabled' name='date' id='date'>";
		 		foreach ($years as $value ) {
		 			echo "<option> {$value} </option>";
		 		}
				echo "</select>";
				echo "</div>";

				echo "<div id='allPhotos'>";
				echo "<div id='allPhotosIn'>"; 

			}

				foreach ($dates as $date) {
					if(substr($date, 0,4)===$year){
						$index = array_search($date, array_column($allExif, 'DateTimeOriginal'));
						if(isset($allExif[$index]["FileName"])){
							$fileName = $allExif[$index]["FileName"];
							$path = "../Fotos/".$fileName;
							echo ' <img class="foto" src="';
							echo $path;
							echo '"> ';
						}
					}
				}

				if(!isset($_POST['year'])){
					echo "</div></div></div>";
				}


			function getAllExif(){
				opendir("../Fotos");
				$count=0;
				$photoNames = array();

				while (false !== ($entry = readdir())) {
					array_push($photoNames, $entry);
	    		}		

	    		//all photos with a path to Fotos. 
	    		$photoPaths = array_map(function ($item) {return "../Fotos/".$item;}, $photoNames);

	    		$allExif = array();

	    		foreach ($photoPaths as $photo) {
	    			$exifData = @exif_read_data($photo);
	    			array_push($allExif, $exifData);
	   			}

	    		closedir();

	    		$finalArray = array();

	    		for($i=2; $i<count($allExif); $i++){
	    			array_push($finalArray, $allExif[$i]);
	    		}
				
	    		return $finalArray;
			}

			function getDates($allExif){

				$allDates = array();

				foreach ($allExif as $photo) {
					if(isset($photo["DateTimeOriginal"])){
						$date = $photo["DateTimeOriginal"];
						array_push($allDates, $date);
					}
				}

				sort($allDates);

				return $allDates;
			}

			function getUniqueExposures($allExif){

				$allExposure = array();

				foreach ($allExif as $photo) {
					if(isset($photo["ExposureTime"])){
						$exposure = $photo["ExposureTime"];
						array_push($allExposure, $exposure);
					}
				}

				$allExposure = array_unique($allExposure);
				$allExposure = array_values($allExposure);

				return $allExposure;
			}

			function getYears($allDates){

				$yearsArray=array();

				foreach ($allDates as $date) {
					$date = substr($date, 0,4);
					if(!in_array($date, $yearsArray)){
						array_unshift($yearsArray, $date);
					}
				}

				return $yearsArray;

			}
			?>
		</div>

	</body>

</html>