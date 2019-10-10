<?php
namespace WC;
require_once dirname(dirname(__DIR__)) .'/vendor/autoload.php';
use Envms\FluentPDO\Query;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


/**
 * databese connect, singleton used
 */
class DBconnect
{
    /** 
     * @var \Envms\FluentPDO\Query 
     */
    private static $instance;
    /**
     * $var \Logger
     */
    
    private function __clone() {}
    private function __construct() {}
    /**
     * check for an instance of the class
     * @return Query 
     */
        public static function getInstance(): \Envms\FluentPDO\Query
        { 
            if(!isset(self::$instance)){
                try {
                    $pdo = new \PDO('mysql:host=localhost;dbname=wc;charset=utf8', 'root', '');
                    self::$instance = new Query($pdo);    
                } catch (\PDOException $exc) {
                    $logger = new Logger('Logger');
                    $logger->pushHandler(new StreamHandler(dirname(__DIR__).'/config/logs/errors.log', Logger::WARNING));
                    $logger->error('Connection DB error');
                    echo $exc->getTraceAsString();
                    die();
                }

                 
            }
            return self::$instance;
        }
}

