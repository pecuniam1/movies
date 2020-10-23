<!DOCTYPE html>
<html>

<head>
	<link rel="apple-touch-icon" sizes="57x57" href="images/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="images/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="images/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="images/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="images/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="images/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="images/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192" href="images/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="images/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<title>Movie Database</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/script.js"></script>
	<meta charset="UTF-8">
</head>
<?php
include("db/theDatabase.php");
$mydb = new \theDatabase;

// global vars
$required_password = "hotdog";
$message = '';

$password = $_POST['password'] ?? null;
if ($password != null) {
	if (strcmp($required_password, $password) == 0) {
		// TODO add some type of sql injection check here
		$movie_title = $_POST['movieTitle'];
		$media_type = $_POST['media'];
		// addMovie($movie_title, $media_type);
		$title = $movie_title ?? null;
		$type = $media_type ?? null;
		if ($title == null || $type == null) {
			// $sql = "INSERT INTO movies ($title, $type)
			// 		VALUES ($title, 1);";
			// $mydb->operation($sql);
			// $message = "$movie_title was successfully added for $media_type";
			$message = $sql;
		} else {
			$message += $title == null ? "Title is not valid<br>" : '';
			$message += $type == null ? "Media type is not valid<br>" : '';
		}
	} else {
		$message = "Password does not match";
	}
}
?>

<body>

	<div id="header">
		<!-- header information here -->
		<?php
		if (!empty($message)) {
			echo "<h1>$message</h1>";
		}
		?>
		<button onclick="toggleAddMovie()">Add Movie</button>
	</div>
	<!--header-->

	<div id="mainpage">
		<?php
		$sql = "SELECT m.name, m.dvd, m.bluray, m.movie, m.tv_series
				FROM movies m
				ORDER BY
					CASE
						WHEN m.name REGEXP '^(A|An|The)[[:space:]]' = 1 THEN
							TRIM(SUBSTR(m.name, INSTR(m.name, ' ')))
						ELSE m.name
					END;";

		$rows = $mydb->getResults($sql);
		echo "<table id='movietable'>";
		echo "<tr><th>Movie Name</th><th>DVD</th><th>Blu-Ray</th><th>Movie</th><th>TV Series</th></tr>";
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
		echo "<tr><td>Totals</td>";
		echo "<td id='dvd'>" . $dvdTotal . "</td>";
		echo "<td id='bluray'>" . $blurayTotal . "</td>";
		echo "<td id='movies'>" . $moviesTotal . "</td>";
		echo "<td id='tv_series'>" . $tvSeriesTotal . "</td>";
		echo "</tr>";
		echo "</table>";
		$mydb->closeDatabase();
		?>
		<div id="modal_backdrop" class="hide">
			<div id="modal">
				<div id="modal_header">
					<a onclick="toggleAddMovie()" href="javascript:void(0);">
						<p style="margin:0;padding:0 10px;">X</p>
					</a>
				</div>
				<div id="addMovie">
					<form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>' method="post">
						<fieldset>
							<legend>Enter a new movie for the database</legend>
							<label for="movieTitle">Movie Title</label>
							<input type="text" name="movieTitle">
							<br>
							<label for="password">Password</label>
							<input type="password" name="password"><br>
							<div class='radio_group'>
								<input type="radio" name="media" value="bluray" checked>Blu-Ray<br>
								<input type="radio" name="media" value="dvd">DVD<br>
							</div>
							<input type="submit" value="Submit">
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>