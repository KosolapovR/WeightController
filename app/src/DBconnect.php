<?php
namespace WC;
require_once dirname(dirname(__DIR__)) .'/vendor/autoload.php';
use Envms\FluentPDO\Query;
/**
 * databese connect, singleton used
 */
class DBconnect
{
    /** 
     * @var \Envms\FluentPDO\Query 
     */
    private static $instance;
    
    private function __clone() {}
    private function __construct() {}
    /**
     * check for an instance of the class
     * @return \Envms\FluentPDO\Query 
     */
        public static function getInstance(): \Envms\FluentPDO\Query
        { 
            if(!isset(self::$instance)){
                $pdo = new \PDO('mysql:host=localhost;dbname=wc;charset=utf8', 'root', '');
                self::$instance = new Query($pdo);     
            }
            return self::$instance;
        }
}

