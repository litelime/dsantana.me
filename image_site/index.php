<!DOCTYPE html>

<html>
	<head>
		<title>David Santana's Photos</title>
		<link href="./image.css?ver=1.1" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="./prototype.js"></script>
		<script type="text/javascript" src="./image.js"></script>

	</head>

	<body>

		<?php
				$allExif=getAllExif();
				$dates = getDates($allExif);
				$years  = getYears($dates);

				//SELECT BOXES
				echo "<label>Date Taken: ";
		 		echo "<select disabled='disabled' name='date' id='date'>";
		 		foreach ($years as $value ) {
		 			echo "<option> {$value} </option>";
		 		}
				echo "</select><br>";
				echo "</label></br>";

				echo "<div id='allPhotos'>";

				$printCount=1;

				foreach ($dates as $date) {
					if(substr($date, 0,4)==="2013"){
						$index = array_search($date, array_column($allExif, 'DateTimeOriginal'));
						if(isset($allExif[$index]["FileName"])){
							$fileName = $allExif[$index]["FileName"];
							$path = "../Fotos/".$fileName;
							echo ' <img class="foto" src="';
							echo $path;
							echo '"> ';
							if($printCount%5==0)
								echo "</br>";
							$printCount++;
						}
					}
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
						array_push($yearsArray, $date);
					}
				}

				return $yearsArray;

			}
			?>
		</div>

	</body>

</html>