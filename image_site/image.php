<!DOCTYPE html>

<html>
	<head>
		<title>David Santana's Photos</title>
		<link href="./image.css?ver=1.1" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="./prototype.js"></script>
		<script type="text/javascript" src="./image.js?ver=1.0"></script>

	</head>

	<body>

		<?php

			require_once("./Database.php");

			$myAdaptor = new DataBase();

			//start homepage at 2017
			$year="2017";
			$iso="false";
            $time="false";
        
			//if this is not the first page load retrieve set values.
			if(isset($_POST['year'])){

				$year=$_POST['year'];
				$iso=$_POST['iso'];
                $time=$_POST['time'];

			}else{
				firstPageLoad();
			}

            $names = $myAdaptor->getNamesOfYearWithAttributes($year,$iso,$time);

			//if the year changed recreate the isos option box and exposures. 
			if(isset($_POST["yearChange"])&&$_POST["yearChange"]==='true'){

				$isos  = $myAdaptor->getIsos($year);
				sort($isos);
                
				foreach ($isos as $value) {
			 		echo "<option class='iso'> {$value} </option>";
				}
             
                echo "</select>";
                
                //get all unique times for the users chosen year. 
                $times  = $myAdaptor->getTimes($year);
                
                foreach ($times as $value) {
			 		echo "<option class='time'> {$value} </option>";
				}
                
			}

			//printing all the photos in the scrollbar at bottom of page. 
			foreach ($names as $fileName) {

				$path = "../FotosSmall/".$fileName;
				echo ' <img class="foto" onload="setScrollWidth()" src="';
				echo $path;
				echo '"> ';
			
			}

			//closing divs on the first page load. 
			if(!isset($_POST['year'])){
				echo "</div></div></div>";
			}


			/* firstPageLoad()
				called the first time a user opens the site.
				writes all html divs for site layout.
				calls database to retrieve photos. 
			*/
			function firstPageLoad(){
			
				$myAdaptor = new DataBase();

				//all years of photos taken in database. 
				$years = $myAdaptor->getYears();
				rsort($years);

				//the names of files of photos taken in 2017
				$first = $myAdaptor->getNamesOfYear(2017);

				//all unique iso value from 2017
				$isos  = $myAdaptor->getIsos(2017);

				//all unique exposure times from 2017. 
                $times = $myAdaptor->getTimes(2017);

                sort($times);
				sort($isos);

				//mainBox is all except the bottom scrollbar. 
				echo '<div id="mainBox">';
					//options is the left side of screen where the options are. 
					echo '<div id="options">';

						echo '<p>Options</p>';

						//YEAR TAKEN SELECT
		 				echo "<label id='datelabel'> Year Taken: <select disabled='disabled' name='date' id='date'>";

		 					foreach ($years as $value ) 
		 						echo "<option> {$value} </option>";
		 					
						echo "</select></label><br><br>";

						//ISO CHECKBOX does user want to filter by ISO?. 
						echo '<input type="checkbox" id="ISO" name="ISO" value="ISO">'; 

						//ISO SELECT choose what iso value to filter by. 
						echo '<label id="isolabel"> ISO: <select name="ISOselect" id="ISOselect">';

							//options of each unique iso value. 
		 					foreach ($isos as $value ) 
		 						echo "<option> {$value} </option>";
		 					
		 				echo '</select></label><br><br>';
                
                		//TIME CHECKBOX. does user want to filter by exposure time?
						echo '<input type="checkbox" id="time" name="time" value="time">'; 

						//TIME SELECT    listing of unique exposure times. 
						echo '<label id="timelabel"> Exposure Time: <select name="timeSelect" id="timeSelect">';

		 					foreach ($times as $value ) 
		 						echo "<option> {$value} </option>";
		 					
		 				echo '</select></label>';

					echo '</div>'; //CLOSE OPTIONS

					//div imgbox is where the large main image is displayed 
					echo '<div id="imgbox">';

						echo '<img id="main" src="../Fotos/';
						echo $first[0];
						echo '">';

					echo "</div>"; //CLOSE IMGBOX

				echo "</div>";//CLOSE MAINBOX

				echo "<div id='allPhotosBox'>";
				echo "<div id='allPhotos'>";
				echo "<div id='allPhotosIn'>"; 

			}

			?>
		</div>

	</body>

</html>