<?php
class Database {

    private $pdo;

    private function __construct() {
        try {
            $core = Core::getInstance();
            $db = $core->getConfig('db');
            $this->pdo = new PDO('pgsql:host='.$db['host'].';port='.$db['port'].';dbname='.$db['dbname'].';user='.$db['user'].';password='.$db['pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Database();
        }
        return $inst;
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function prepare($sql) {
        return $this->pdo->prepare($sql);
    }
}