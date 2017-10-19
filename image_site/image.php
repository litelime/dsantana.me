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

			$years = $myAdaptor->getYears();
			rsort($years);

			$year="2017";
			$iso="false";

			if(isset($_POST['year'])){

				$year=$_POST['year'];
				$iso=$_POST['iso'];

			}else{

				$first = $myAdaptor->getNamesOfYear(2017);
				$isos  = $myAdaptor->getIsos(2017);
				sort($isos);

				echo '<div id="mainBox">';
				echo '<div id="options">';
				echo '<p>Options</p>';


				echo '<div id="dateBox">';
				//SELECT BOXES
		 		echo "<label id='datelabel'> Year Taken: <select disabled='disabled' name='date' id='date'>";
		 		foreach ($years as $value ) {
		 			echo "<option> {$value} </option>";
		 		}
				echo "</select></label>";
				echo "</div><br><br>";


				echo '<input type="checkbox" id="ISO" name="ISO" value="ISO">';
				echo '<label id="isolabel"> ISO: <select name="ISOselect" id="ISOselect">';
		 		foreach ($isos as $value ) {
		 			echo "<option> {$value} </option>";
		 		}
		 		echo '</select></label>';

				echo '</div>';


				echo '<div id="imgbox">';
				echo '<img id="main" src="../Fotos/';
				echo $first[0];
				echo '">';
				echo "</div></div>";

				echo "<div id='allPhotosBox'>";
				echo "<div id='allPhotos'>";
				echo "<div id='allPhotosIn'>"; 

			}

			if($iso==='false'){
				$names = $myAdaptor->getNamesOfYear($year);
			}else{
				$names = $myAdaptor->getNamesOfYearandISO($year,$iso);
			}

			if(isset($_POST["isoChange"])&&$_POST["isoChange"]==='true'){
				//Print isos on every change so iso box only shows isos available for those photos. 
				$isos  = $myAdaptor->getIsos($year);
				sort($isos);

				foreach ($isos as $value) {
			 		echo "<option> {$value} </option>";
				}
			}

			foreach ($names as $fileName) {

				$path = "../FotosSmall/".$fileName;
				echo ' <img class="foto" onload="setScrollWidth()" src="';
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