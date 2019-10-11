<?php

namespace WC;

use Envms\FluentPDO\Query;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once dirname(dirname(__DIR__)) .'/vendor/autoload.php';

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
    * prevent create new class object
    */
    private function __clone() {}
    /**
    * prevent create new class object
    */
    private function __construct() {}
    /**
     * check for an instance of the class, get db connectrion
     * @return Query 
     */
    public static function getInstance(): \Envms\FluentPDO\Query
    { 
        if(!isset(self::$instance)){
            try {
                $config = include 'config/config.php';
                $pdo = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8", "{$config['login']}", "{$config['password']}");
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


