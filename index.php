<?php
	//sign in through steam. 
    require ('steamauth/steamauth.php');
	//You would uncomment the line beneath to make it refresh the data every time the page is loaded
	// unset($_SESSION['steam_uptodate']);
?>
<!DOCTYPE html>

<html>

	<head>
		<title>Steam Achievement Formatter</title>
		<link href="achievement.css?ver=1.6" rel="stylesheet" type="text/css" /> 
		<script type="text/javascript" src="achievement.js?ver=1.6"></script>
		<script type="text/javascript" src="prototype.js"></script>
	</head>

	<body>
		<h1>Steam Achievement Formatter</h1>

			<div id='center'>
				<textarea id="content" rows="35" readonly>Copy/Paste from here</textarea>
				<p>Copy and paste the text that is output above into your steam custom info box.<br/>
				NOTICE: Text may look very misaligned on this page, but looks better once placed in steam.  
				</p>
				<button id="copyButton" disabled="disabled">Nothing to Copy</button><br/><br/>
			</div>

			<div id='left'>
				<dl>
					<dt>Purpose:</dt>
					<dd>Take all your perfect games (100% Achievements Completed) 
					and put them into a format that looks decent in a steam info box. </dd>
					<dt>Requirements:</dt>
					<dd>- Need an <a href='http://astats.astats.nl/astats/index.php'>astats</a> profile.</dd>
					<dd>- You need to know the steamid64. Don't know what yours is? 
					Go <a href='help.html'>here</a> for help or you can login through steam below.</dd>
				</dl>

					Your steamid64: <input name="userid" id="steamid" type='text' autocomplete="on">
					<input id='button' type='submit' value='Update Text'><br/><br/>

					<?php
						if(!isset($_SESSION['steamid'])) {

						    loginbutton(); //login button
						    
						}  else {
						    include ('steamauth/userInfo.php');

						    echo "Welcome " . $steamprofile['personaname'] . "<br/>";
						    echo "Your steamid64 is ". $steamprofile['steamid'];
						    
						    logoutbutton();
						}    
					?>  
				<div id="options">
					<h2>Options</h2>
					<ul id="optionsul">
                        Click update text to apply options<br/><br/>
						<li><label><input type="checkbox" id="num_column" name="num_column" value="num_column" checked="checked"/>
                            Number of Achievements Column</label></li>
						<li><label><input type="checkbox" id="date_column" name="date_column" value="date_column" checked="checked"/>
                            Date of Achievements Column</label></li>
                        <li><label><input type="radio" name="split" id="year" value="year" checked="checked"/>Split by Year</label>
                            <label><input type="radio" name="split" id="month" value="month"/>Split by Month</label></li>
		  				<li>Seperation Options
		  				<select id='charOption'>
							<option value="*">Asterisk *</option>
							<option value=":">Colon :</option>
							<option value="`">Accent `</option>
							<option value=".">Period .</option>
							<option value="-">Dash -</option>
							<option value="blank">Blank Spaces</option>
							<option value="single">Single Space</option>
							<option value="">No Spacing</option>
						</select>
						</li>
						<li>Sorting Options
						<select id='sortOption'>
							<option value="dateD">Date Descending</option>
							<option value="dateA">Date Ascending</option>
						</select>
						</li>
                        <li>Enclosing Options
						<select id="closeOption">
                            <option value="[]">Square Brackets []</option>
							<option value="()">Parenthesis ()</option>
                            <option value="{}">Brackets {}</option>
                            <option value="none">None</option>
						</select>
						</li>
                        <button id="mover">Output Examples</button>
	  				</ul>
  				</div>
  				<dl>
  					<dt>Notes:</dt>
                    <dd>- Once you've loaded the games the first time they will load faster afterwards, feel free to try lots of different settings!</dd>
                    <dd>- Unfortunately because of steam info box char limits you will only be able to fit a limited amount of your 100% games.</dd>
                    <dd>- Questions/Issues/Suggestions: dsantanaprof@gmail.com</dd>

                </dl>
			</div>

			<div id="right">
					<div id='hide'>
						Examples<br/><br/>
						With options of every column selected and split by year.<br/>
						<img src='astatsexample.png' alt='Example output split by year'/>
						With options of date column only and split by month<br/>
						<img src='astatsmonthexample.png' alt='Example output split by month'/>
					</div>
			</div>
	</body>
</html>