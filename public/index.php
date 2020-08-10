<!DOCTYPE html>
<?php
include("db/theDatabase.php");
$mydb = new theDatabase;
$title = null;
$media_type = null;
$correct = false;
$newMovie = false;
if($_POST['password']=="hotdog"){
	$correct = true;
}
if(!empty($_POST)){
	$title = $_POST['movieTitle'];
	$media_type = $_POST['media'];
	$newMovie = true;
	}
?>
<html>
<head>
<title>Movie Database</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" media="only screen and (max-device-width:480px)" href="css/mobile.css" />
<meta charset="UTF-8">
</head>
<body>

<div id="header">
<!-- header information here -->
</div><!--header-->

<div id="mainpage">
<?php
if($newMovie == true){
	echo $title . " on ";
	echo $media_type;
	echo " was successfully added!<br />";
}
$sql = "SELECT m.name, m.dvd, m.bluray FROM movies m ORDER BY m.name";
$rows = $mydb->getResults($sql);
echo "<table id='movieTable'><tr><th>Movie Name</th><th>DVD</th><th>Blu-Ray</th></tr>";
$dvdTotal = 0;
$blurayTotal = 0;
foreach($rows as $row){
	$name = $row['name'];
	$dvd = $row['dvd'];
	$bluray = $row['bluray'];
	
	echo "<tr><td>" . $name . "</td><td id='dvd'>";
		if($dvd){
			echo "X";
			$dvdTotal++;
		}else{
			echo " ";
		}
	echo "</td><td id='bluray'>";
		if($bluray){
			echo "X";
			$blurayTotal++;
		}else{
			echo " ";
		}
	echo "</td></tr>\n";
}
echo "<tr><td></td><td id='dvd'>" . $dvdTotal . "</td><td id='bluray'>" . $blurayTotal . "</td></tr>";
echo "</table>";
$mydb->closeDatabase();
?>
<div id="addMovie">
	<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method="post">
		<fieldset>
		<legend>Enter a new movie for the database</legend>
			Movie Title:<br />
			<input type="text" name="movieTitle"><br />
			<input type="radio" name="media" value="isBluRay" checked>Blu-Ray<br />
			<input type="radio" name="media" value="isDvd">DVD<br />
			Password:<br />
			<input type="password" name="password"><br />
			<input type="submit" value="Submit">
		</fieldset>
	</form>
</div><!--addMovie-->
</div><!--mainpage-->
</body>
</html>