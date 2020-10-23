<?php
class DatabaseConnection
{
	private $connection;
	private $numrows;
	private $numcols;

	public function __construct()
	{
		$dsn = "mysql:host=db585961136.db.1and1.com;dbname=db585961136;charset=UTF8";
		$username = "dbo585961136";
		$password = "W*gphx8HD2V^*^1M";

		try {
			$this->connection = new PDO($dsn, $username, $password);
		} catch (PDOException $e) {
			echo "Database error! ".$e->getMessage();
		}
	}

	public function getResults($sql_string)
	{
		try {
			$rows = $this->connection->query($sql_string);
			return $rows;
		} catch (PDOException $e) {
			echo "Database error! ".$e->getMessage();
			return -1;
		}
	}

	public function operation($sql_string)
	{
		try {
			$result = $this->connection->exec($sql_string);
			return $result;
		} catch (PDOException $e) {
			echo "Database error! ".$e->getMessage();
			return null;
		}
	}

	public function closeDatabase()
	{
		try {
			$this->connection = null;
		} catch (PDOException $e) {
			echo "Database error! ".$e->getMessage();
		}
	}
}
