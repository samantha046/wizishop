<?php
class DB
{

	//Déclaration des variables
	private $host = 'localhost';
	private $username = 'root';
	private $password = 'root';
	private $database = 'wiziShop';
	private $db;

	//Methode de connexion à la base de données
	public function __construct($host = null, $username = null, $password = null, $database = null)
	{
		if ($host != null) {
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
		}

		try {
			$this->db = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database, $this->username, $this->password, array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
				PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
			));
		} catch (PDOException $e) {
			die('<h1>Impossible de se connecter a la base de donnee</h1>');
		}
	}
	/**
	 * Démarre une requête.
	 *
	 * @param string $sql requête sql
	 * @param array $data paramètre de la requête préparée
	 *
	 * @return array en tant qu'objet
	 */
	public function query($sql, $data = array(), $all = false)
	{
		$req = $this->db->prepare($sql);
		$req->execute($data);
		if ($all) {
			return $req->fetch(PDO::FETCH_OBJ);
		}
		return $req->fetchAll(PDO::FETCH_OBJ);
	}
}
