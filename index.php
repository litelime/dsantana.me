<?php
    require ('steamauth/steamauth.php');
	# You would uncomment the line beneath to make it refresh the data every time the page is loaded
	// unset($_SESSION['steam_uptodate']);
?>
<!DOCTYPE html>

<html>

	<head>
		<title>Steam Achievement Formatter</title>
		<link href="achievement.css?ver=1.2" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="achievement.js?ver=1.2"></script>
		<script type="text/javascript" src="prototype.js"></script>
	</head>

	<body>
		<h1>Steam Achievement Formatter</h1>

			<div id='center'>
				<textarea id="content" rows="25" readonly>Copy/Paste from here</textarea>
				<p>Copy and paste the text that is output above into your steam custom info box.
				It will look jumbled and messy on this page but will look better once you have saved it 
				on your profile. 
				</p>
				<button id="copyButton" disabled="disabled">Nothing to Copy</button>
			</div>

			<div id='left'>
				<dl>
					<dt>Purpose:</dt>
					<dd>Take all your perfect games (100% Achievements Completed) 
					and put them into a format that looks decent in a steam info box. </dd>
					<dt>Format:</dt>
					<dd>Year - Number of Games Completed in that year<br/>
					[Game Name] *** [Number of Achievements] *** [Date Acquired]</dd>
					<dt>Requirements:</dt>
					<dd>You must have an <a href='http://astats.astats.nl/astats/index.php'>astats</a> profile, 
					this is where the necessary info will be grabbed. </dd>
					<dd>You need to know the steamid64. Don't know what yours is? Go <a href='help.html'>here</a> for help or you can login through steam below.</dd>
					<dt>Info:</dt>
					<dd>Unfortunately because of steam info box char limits you will only be able to fit about 75 games.
				</dl>

					Your steamid64: <input name="steamid" id="steamid" type='text'>
					<input id='button' type='submit' value='Create Text'><br/><br/>

					<?php
						if(!isset($_SESSION['steamid'])) {

						    loginbutton(); //login button
						    
						}  else {
						    include ('steamauth/userInfo.php');

						    //Protected content
						    echo "Welcome " . $steamprofile['personaname'] . "<br/>";
						    echo "Your steamid64 is ". $steamprofile['steamid'];
						    
						    logoutbutton();
						}    
					?>  

					<h2>Options</h2>
				<ul>
					<li><input type="checkbox" id="num_column" name="num_column" value="num_column" checked="checked"/>Number of Achievements Column</li>
					<li><input type="checkbox" id="date_column" name="date_column" value="date_column" checked="checked"/>Date of Achievements Column</li>
	  				<li><input type="radio" name="split" id="year" value="year" checked="checked"/>Split by Year</li>
	  				<li><input type="radio" name="split" id="month" value="month"/>Split by Month</li>
  				</ul>
			</div>

			<div id="right">
				Examples of what output looks like in the steam info box.<br/><br/>
				With options of every column selected and split by year.<br/>
				<img src='astatsexample.png' alt='Example output split by year'/>
				With options of date column only and split by month<br/>
				<img src='astatsmonthexample.png' alt='Example output split by month'/>
				<p>Created By David Santana --- Questions/Issues/Suggestions: dsantanaprof@gmail.com</p>
			</div>
	</body>
</html>