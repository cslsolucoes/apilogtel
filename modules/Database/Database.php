<?php
class Database {

    private $pdoErp;
    private $pdoLocal;

    private function __construct() {
        try {
            $core = Core::getInstance();
            $db = $core->getConfig('dbErp');
            $this->pdoErp = new PDO('pgsql:host='.$db['host'].';port='.$db['port'].';dbname='.$db['dbname'].';user='.$db['user'].';password='.$db['pass']);
            $this->pdoErp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdoErp->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdoErp->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $db = $core->getConfig('dbLocal');
            $this->pdoLocal = new PDO('pgsql:host='.$db['host'].';port='.$db['port'].';dbname='.$db['dbname'].';user='.$db['user'].';password='.$db['pass']);
            $this->pdoLocal->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdoLocal->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdoLocal->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
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

    public function queryErp($sql) {
        return $this->pdoErp->query($sql);
    }

    public function prepareErp($sql) {
        return $this->pdoErp->prepare($sql);
    }

    public function queryLocal($sql) {
        return $this->pdoLocal->query($sql);
    }

    public function prepareLocal($sql) {
        return $this->pdoLocal->prepare($sql);
    }
}