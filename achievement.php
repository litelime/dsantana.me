<?php 

		function addSurroundingChars ($array){
			foreach ($array as &$element){
				$element="[".$element."]";
			}
			return $array;
		}

		#width of given string. 
		function lengthOfChars($string){

			#length values based on steam font looked at by eye. Not exact...
			#sizes are relative, ex: Capital W(16) looks 4 times bigger than Capital J(4)
			$charArray = ['['=>7,']'=>7,'#'=>8,' '=>7,'-'=>7,':'=>7,'.'=>7,'Û'=>12,','=>7,'!'=>7,'`'=>7,'*'=>7,
			'a'=>8,'b'=>8,'c'=>8,'d'=>8,'e'=>8,'f'=>7,'g'=>8,'h'=>8,'i'=>4,'j'=>4,'k'=>8,'l'=>4,'m'=>14,'n'=>8,'o'=>8,'p'=>8,'q'=>8,'r'=>7,
				's'=>8,'t'=>7,'u'=>8,'v'=>8,'w'=>12,'x'=>8,'y'=>8,'z'=>8,
			'1'=>8,'2'=>8,'3'=>8,'4'=>8,'5'=>8,'6'=>8,'7'=>8,'8'=>8,'9'=>8,'0'=>8,
			'A'=>12,'B'=>12,'C'=>12,'D'=>12,'E'=>12,'F'=>11,'G'=>13,'H'=>12,'I'=>7,'J'=>4,'K'=>12,'L'=>8,'M'=>14,'N'=>12,'O'=>13,'P'=>12,
				'Q'=>13,'R'=>12,'S'=>12,'T'=>11,'U'=>12,'V'=>12,'W'=>16,'X'=>12,'Y'=>12,'Z'=>11];

			$str_arr = str_split($string);
			$len = 0;
			foreach ($str_arr as $char){
				if(array_key_exists($char,$charArray))
					$len+=$charArray[$char];
				else {
					$len+=8;
				}
			}
			return $len;
			
		}

		#Return array of how many games completed in a year
		#returns: [year=>numGamesCompleted]
		function createYearArray ($datesArray){

			$text = $tempStr=implode(",",$datesArray);
			preg_match_all('/\d\d\d\d/', $text,$yearArray,PREG_PATTERN_ORDER);
			$returnArray=array_count_values($yearArray[0]);
		
			return $returnArray;

		}

		#Return array of how many games completed per month
		#returns: [year-month=>numGamesCompleted]
		function createMonthArray ($datesArray){

			$text = $tempStr=implode(",",$datesArray);
			preg_match_all('/\d\d\d\d-\d\d/', $text,$yearArray,PREG_PATTERN_ORDER);
			$returnArray=array_count_values($yearArray[0]);


			return $returnArray;

		}

		function getYear($str){

			preg_match('/\d\d\d\d/', $str,$temp);
			return $temp[0];

		}

		function getMonthYearNum($str){
			preg_match('/\d\d\d\d-\d\d/', $str,$temp);
			return $temp[0];
		}

		function getMonthYearString($str){
			
			$formatstring="";

			$months = [1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 =>'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'];

			preg_match_all('/\d+/', $str,$temp);

			$month_num = $temp[0][1];
			$month_num = (int)($month_num);

			$formatstring.=$months[$month_num]." ".$temp[0][0];

			return $formatstring;
		}

	function createSteamFormat($steamid,$date_column,$num_column,$split){

		$steamid = htmlspecialchars($steamid);
		if(strlen($steamid)!=17){
			return "SteamId64 is 17 digits long. Make sure it is entered correctly.";
		}

		$achievement_page = file_get_contents("http://astats.astats.nl/astats/User_Games.php?Limit=0&PerfectOnly=1&Hidden=1&SteamID64=$steamid&DisplayType=1");

		if(preg_match('/No profile found/',$achievement_page)||empty($achievement_page)){
			return "Profile with that number couldn't be found.\nEnter a SteamId64: Should be 17 digits long\nMake sure the account has an astats profile generated.";
		}

		if(preg_match('/No results/',$achievement_page))
			return "Didn't find any 100% completed games.";
			

		$max_len=750;
		$date_len=85;

		preg_match("/<tbody>[\s\S]*<\/tbody>/",$achievement_page,$temp);
		$slimpage = $temp[0];

		preg_match_all('/<a href="Steam_Game_Info.+?<\/a>/', $slimpage,$temp1,PREG_PATTERN_ORDER);
		$names = $temp1[0];

		//delete garbage from name strings. 
		foreach ($names as &$element){
			$element=preg_replace("/<a href=.*AEE\'>/",'',$element);
			$element=preg_replace("/<\/a>/",'',$element);
		}

		//3 different matches trying to extract num achievements..
		preg_match_all("/<\/a>.{46}\d+/", $slimpage,$temp2,PREG_PATTERN_ORDER);
		$tempStr=implode(",",$temp2[0]);
		preg_match_all("/AEE'>\d+/", $tempStr,$temp2,PREG_PATTERN_ORDER);
		$tempStr=implode(",",$temp2[0]);
		preg_match_all("/\d+/", $tempStr,$temp2,PREG_PATTERN_ORDER);
		$total = $temp2[0];

		preg_match_all('/\d*-\d*-\d*/', $slimpage,$temp3,PREG_PATTERN_ORDER);
		$dates = $temp3[0];

		foreach($names as &$line){
			if(lengthOfChars($line)>=300){
				$diff = lengthOfChars($line)-300;
				$diff = $diff/8;
				$line = substr($line,0,strlen($line)-$diff);
				$line = $line . "...";
			}
		}

		$dates=addSurroundingChars($dates);
		$total=addSurroundingChars($total);
		$names=addSurroundingChars($names);

		$least = count($names);

		if(count($dates)<$least)
			$least=count($dates);
		
		if(count($total)<$least)
			$least=count($total);
		
		for($i=0;$i<$least;$i++){
			$len = $least - $i;
			if(($len)<10)
				$names[$i] = "#0$len - " . $names[$i];
			else
				$names[$i] = "#$len - "  . $names[$i];
		}

		$greatest=0;

		foreach ($names as $item){
			$len = lengthOfChars($item);
			if($len>$greatest)
				$greatest=$len;
		}

		#Add 10 special chars
		$greatest = $greatest+100;

		if($num_column=='true'||$date_column=='true'){
			foreach ($names as &$line){
				$difference = $greatest - lengthOfChars($line);
				$numspace = $difference/7;
				while ($numspace>0){
					$line.='*';
					$numspace = $numspace - 1;
				}
			}
		}

		if($date_column=='true'&&$num_column=='true'){
			for($i=0;$i<$least;$i++){
				$numspace = ($max_len - lengthOfChars($names[$i])-lengthOfChars($total[$i])-$date_len)/7;
				//$difference = $greatest - lengthOfChars($line);
				//$numspace = $difference/7;
				while ($numspace>0){
					$total[$i].='*';
					$numspace = $numspace - 1;
				}
			}
		}

		if($split=="year")
			$dateHash=createYearArray($dates);
		else
			$dateHash=createMonthArray($dates);

		$newFile = "";

		for ($i=0; $i<$least;$i++){
			$theline = $names[$i];
			$numline = $total[$i];
			$dateline = $dates[$i];
			if($split=="year"&&$dateHash[getYear($dates[$i])]>0){
				$newFile .= "[h1]" . getYear($dates[$i]) . " - ";
				$newFile .= $dateHash[getYear($dates[$i])] . " Games Completed[/h1] \n";	
				$dateHash[getYear($dates[$i])]=-1;
			}else if($split=="month"&&$dateHash[getMonthYearNum($dates[$i])]>0){
				$newFile .= "[h1]" . getMonthYearString($dates[$i]) . " - ";
				if($dateHash[getMonthYearNum($dates[$i])]>1)
					$newFile .= $dateHash[getMonthYearNum($dates[$i])] . " Games Completed[/h1] \n";
				else
					$newFile .= $dateHash[getMonthYearNum($dates[$i])] . " Game Completed[/h1] \n";
				$dateHash[getMonthYearNum($dates[$i])]=-1;
			}

			if($num_column=='true')
				$theline.=$numline;
			if($date_column=='true')
				$theline.=$dateline;
			$theline.="\n";
			$newFile.=$theline;
		}

			return $newFile;
	}

	if(isset($_POST["steamid"]) && isset($_POST["date_column"]) && isset($_POST["num_column"]) && isset($_POST["split"]))
	{
		echo createSteamFormat($_POST["steamid"], $_POST['date_column'], $_POST["num_column"],$_POST["split"]);
	}else{
		echo "Enter a SteamId64: Should be 17 digits long";
	}

?> 