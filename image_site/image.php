<!DOCTYPE html>

<html>
	<head>
		<title>David Santana's Photos</title>
		<link href="./image.css?ver=1.1" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="./prototype.js"></script>
		<script type="text/javascript" src="./image.js?ver=1.1"></script>

	</head>

	<body>

		<?php

			require_once("./Database.php");

			$myAdaptor = new DataBase();

			$years = $myAdaptor->getYears();
			rsort($years);

			$year="2017";

			if(isset($_POST['year'])){

				$year=$_POST['year'];

			}else{

				$first = $myAdaptor->getNamesOfYear(2017);

				echo '<div id="mainBox">';
				echo "<div id='maintext'></div>";
				echo '<img id="main" src="../Fotos/';
				echo $first[0];
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

			$names = $myAdaptor->getNamesOfYear($year);

			foreach ($names as $fileName) {

				$path = "../FotosSmall/".$fileName;
				echo ' <img class="foto" src="';
				echo $path;
				echo '"> ';
			
			}

			if(!isset($_POST['year'])){
				echo "</div></div></div>";
			}

			?>
		</div>

	</body>

</html>