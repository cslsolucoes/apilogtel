<?php
class Core {

    private $config;

    private function __construct() {}

    public static function getInstance() {
        static $inst = null;
        if($inst === null) {
            $inst = new Core();
        }
        return $inst;
    }

    public function run($config) {
        $this->config = $config;
        $this->loadModule('router')->load()->match();
    }

    public function getConfig($name) {
        return $this->config[$name];
    }

    public function loadModule($moduleName) {
        try {
            $moduleName = ucfirst($moduleName);
            $module = $moduleName::getInstance();
            return $module;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

}