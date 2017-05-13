<?php
    require ('steamauth/steamauth.php');
	# You would uncomment the line beneath to make it refresh the data every time the page is loaded
	// unset($_SESSION['steam_uptodate']);
?>
<!DOCTYPE html>

<html>

	<head>
		<title>Steam Achievement Formatter</title>
		<link href="achievement.css?ver=1.1" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="achievement.js?ver=1.1"></script>
		<script type="text/javascript" src="prototype.js"></script>
	</head>

	<body>
		<h1>Steam Achievement Formatter</h1>

			<div id='center'>
				<textarea id="content" rows="40" readonly>Copy/Paste from here</textarea>
				<p>Copy and paste the text that is output above into your steam custom info box.<br/>
				NOTICE: Text will look very misaligned on this page, but looks better once placed in steam.  
				</p>
				<button id="copyButton" disabled="disabled">Nothing to Copy</button><br/><br/>
			</div>

			<div id='left'>
				<dl>
					<dt>Purpose:</dt>
					<dd>Take all your perfect games (100% Achievements Completed) 
					and put them into a format that looks decent in a steam info box. </dd>
					<dt>Requirements:</dt>
					<dd>You must have an <a href='http://astats.astats.nl/astats/index.php'>astats</a> profile, 
					this is where the necessary info will be grabbed. </dd>
					<dd>You need to know the steamid64. Don't know what yours is? 
					Go <a href='help.html'>here</a> for help or you can login through steam below.</dd>
					<dt>Info:</dt>
					<dd>Unfortunately because of steam info box char limits you will only be able to fit about 75 of your 100% games.
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
				<div id="options">
					<h2>Options</h2>
					<ul>
						<li><input type="checkbox" id="num_column" name="num_column" value="num_column" checked="checked"/>
						Number of Achievements Column</li>
						<li><input type="checkbox" id="date_column" name="date_column" value="date_column" checked="checked"/>
						Date of Achievements Column</li>
		  				<li><input type="radio" name="split" id="year" value="year" checked="checked"/>Split by Year</li>
		  				<li><input type="radio" name="split" id="month" value="month"/>Split by Month</li>
		  				<li>Seperating Character 
		  				<select id='charOption'>
							<option value="*">Asterisk *</option>
							<option value=":">Colon :</option>
							<option value="`">Accent `</option>
							<option value=".">Period .</option>
							<option value="-">Dash -</option>
							<!--<option value="blank">Blank Space</option>-->
						</select>
						</li>
						
	  				</ul>
  				</div>
			</div>

			<div id="right">
					<button id="mover">Hide Examples</button>
					<div id='hide'>
						<br/><br/>Examples of what output looks like in the steam info box.<br/><br/>
						With options of every column selected and split by year.<br/>
						<img src='astatsexample.png' alt='Example output split by year'/>
						With options of date column only and split by month<br/>
						<img src='astatsmonthexample.png' alt='Example output split by month'/>
						<p>Created By David Santana --- Questions/Issues/Suggestions: dsantanaprof@gmail.com</p>
					</div>
			</div>
	</body>
</html>