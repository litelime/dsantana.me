	
		<?php

			if(isset($_POST['year'])){

				$printCount=1;

				$allExif=getAllExif();
				$dates = getDates($allExif);

				foreach ($dates as $date) {
					if(substr($date, 0,4)===$_POST['year']){
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
			}

			
			/*
				returns an array of associative arrays
				which contain exif data on every photo 
				in the Fotos directory. 
			*/
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

		?>	
