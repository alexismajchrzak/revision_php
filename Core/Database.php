<?php

namespace App\Database;

use PDO;
use PDOException;

/**
 * connexion bdd phpMyadmin
 */
class Database extends PDO {

    /**
     * @var
     */
    private static $_instance;

    /**
     *connexion en local
     */
    private const DBHOST = 'localhost';
    /**
     *user = root
     */
    private const DBUSER = 'root';
    /**
     *mdp = root
     */
    private const DBPASS = 'root';
    /**
     *connexion a la database voulue
     */
    private const DBNAME = 'quiz_php'; // à changer

    /**
     *
     */
    private function __construct() {

        $pdo = 'mysql:dbname='. self::DBNAME . ';host=' . self::DBHOST;

        try {
            parent::__construct($pdo, self::DBUSER, self::DBPASS);

            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * @return static
     */
    public static function getInstance(): self {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}
