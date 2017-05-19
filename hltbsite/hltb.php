<?php

    session_start();

    if(isset($_SESSION['games'])){
        $unplayed = $_SESSION['games'];
    }else{
        $unplayed = (getUnplayedGames(getOwnedGames("76561198025425430")));
        $_SESSION['games'] = $unplayed;
    }
    
    if(isset($_SESSION['stats'])){
        $allstats = $_SESSION['stats'];
    }else{
        $allstats = (getGlobalAchievementStats($unplayed));
        $_SESSION['stats'] = $allstats;
    }

    $names = getArrayofNames($unplayed);

    $percentages = array();
    
    foreach($allstats as $game){
        $percentages []= (getAveragePercentage($game));
    }

    print_r($percentages);
    print_r($names);

    function getArrayofNames($gamesArray){
        
        return array_column($gamesArray,1);
        
    }

    function getAveragePercentage($game){
                
        $sum = 0;
                    
        foreach($game['achievementpercentages']['achievements'] as $achievement){
            $sum += $achievement['percent'];
        }
        
        return $sum / count($game['achievementpercentages']['achievements']);
    }

    function getOwnedGames($steamid){

        $url = "http://api.steampowered.com/IPlayerService/GetOwnedGames/v0001/?key=9B72D30B21EBDC4B8299D41D8691706D&steamid=$steamid&include_appinfo=1&format=json";

        $ownedgames = @file_get_contents($url);
                      
        if(!$ownedgames||preg_match('/Internal Server Error/',$ownedgames)){
            echo $ownedgames;
            echo "Couldn't find that steam account";
            exit;
        }

		$ownedgames = json_decode($ownedgames,true);
                    
        if(isset($ownedgames['response']['game_count'])){
            if($ownedgames['response']['game_count']==0){
                echo "No games found under that steamid";
                exit;
            }
        }

		return ($ownedgames['response']['games']);
    }

    function getGlobalAchievementStats($gamesArray){
        
        $percentagesArray = array();
        
        foreach($gamesArray as $gameid){
            
            $url = "http://api.steampowered.com/ISteamUserStats/GetGlobalAchievementPercentagesForApp/v0002/?gameid=$gameid[0]&format=json";
            $result = json_decode(@file_get_contents($url),true);  
            if(count($result['achievementpercentages']['achievements'])>0)
               $percentagesArray[]= $result;
        
        }
        
        return $percentagesArray;
    }

	function getUnplayedGames($gamesArray){

        $playedGames = array();

		foreach ($gamesArray as $game){

			if($game['playtime_forever']==0)
				$playedGames[]=array($game['appid'],$game['name']);

		}

        if(count($playedGames)==0){
            echo "No completed games found for this account.";
            exit;
        }

		return $playedGames;
	}
        

?>