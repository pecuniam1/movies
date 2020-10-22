<!DOCTYPE html>
<?php
include("db/theDatabase.php");
$mydb = new \theDatabase;


$required_password = "hotdog";
$password = $_POST['password'] ?? null;
if ($password != null) {
	if (strcmp($required_password, $password) == 0) {
		// passwords match
		$movie_title = $_POST['movieTitle'];
		$media_type = $_POST['media'];
		addMovie($movie_title, $media_type);
	} else {
		// passwords don't match
	}
}

/**
 * addMove will do a null check and add the movie to the database.
 *
 * @param string $title
 * @param string $type
 * @return void
 */
function addMovie($title, $type)
{
	$title = $title ?? null;
	$type = $type ?? null;
	$sql = "INSERT INTO movies (name, type)
			VALUES ($title, $type);";
	// $mydb->operation($sql);
}

// $title = null;
// $media_type = null;
// $correct = false;
// $newMovie = false;
// if($_POST['password']=="hotdog") {
// 	$message = addMovie();
// 	$correct = true;
// 	if(!empty($_POST)) {
// 		$title = $_POST['movieTitle'];
// 		$media_type = $_POST['media'];
// 		$newMovie = true;
// 	}
// }

// function addMovie() : string {
// 	return "You have not entered the correct password.";
// }
?>
<html>

<head>
	<title>Movie Database</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<!-- <script src="js/script.js"></script> -->
	<meta charset="UTF-8">
</head>

<body>

	<div id="header">
		<!-- header information here -->
	</div>
	<!--header-->

	<div id="mainpage">
		<!-- <button onclick="toggleAddMovie()">Add Movie</button> -->
		<?php

		// if($newMovie == true){
		// 	echo $title . " on ";
		// 	echo $media_type;
		// 	echo " was successfully added!<br />";
		// }
		$sql = "SELECT m.name, m.dvd, m.bluray, m.movie, m.tv_series
				FROM movies m
				ORDER BY
					CASE
						WHEN m.name REGEXP '^(A|An|The)[[:space:]]' = 1 THEN
							TRIM(SUBSTR(m.name, INSTR(m.name, ' ')))
						ELSE m.name
					END;";

		$rows = $mydb->getResults($sql);
		echo "<table id='movietable'><tr><th>Movie Name</th><th>DVD</th><th>Blu-Ray</th><th>Move</th><th>TV Series</th></tr>";
		$dvdTotal = 0;
		$blurayTotal = 0;
		$moviesTotal = 0;
		$tvSeriesTotal = 0;
		foreach ($rows as $row) {
			$name = $row['name'];
			$dvd = $row['dvd'];
			$bluray = $row['bluray'];
			$movie = $row['movie'];
			$tv_series = $row['tv_series'];

			echo "<tr><td>" . $name . "</td><td id='dvd'>";
			if ($dvd) {
				echo "X";
				$dvdTotal++;
			} else {
				echo " ";
			}
			echo "</td><td id='bluray'>";
			if ($bluray) {
				echo "X";
				$blurayTotal++;
			} else {
				echo " ";
			}
			echo "</td><td id='movie'>";
			if ($movie) {
				echo "X";
				$moviesTotal++;
			} else {
				echo " ";
			}
			echo "</td><td id='tv_series'>";
			if ($tv_series) {
				echo "X";
				$tvSeriesTotal++;
			} else {
				echo " ";
			}
			echo "</td></tr>\n";
		}
		echo "<tr><td>Totals;</td>";
		echo "<td id='dvd'>" . $dvdTotal . "</td>";
		echo "<td id='bluray'>" . $blurayTotal . "</td>";
		echo "<td id='movies'>" . $moviesTotal . "</td>";
		echo "<td id='tv_series'>" . $tvSeriesTotal . "</td>";
		echo "</tr>";
		echo "</table>";
		$mydb->closeDatabase();
		?>
		<!-- <div id="modal_backdrop" class="hide">
			<div id="modal">
				<div id="modal_header">
					<a onclick="toggleAddMovie()" href="javascript:void(0);"><p style="margin:0;padding:0 10px;">X</p></a>
				</div>
				<div id="addMovie">
					<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
						<fieldset>
							<legend>Enter a new movie for the database</legend>
							Movie Title:<br />
							<input type="text" name="movieTitle"><br />
							<input type="radio" name="media" value="bluray" checked>Blu-Ray<br />
							<input type="radio" name="media" value="dvd">DVD<br />
							Password:<br />
							<input type="password" name="password"><br />
							<input type="submit" value="Submit">
						</fieldset>
					</form>
				</div>
			</div>
		</div> -->
	</div>
	<!--mainpage-->
</body>

</html>