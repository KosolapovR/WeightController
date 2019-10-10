<?php

namespace WC;
require_once dirname(dirname(__DIR__)) .'/vendor/autoload.php';
/**
 * This class as entity for table users in database
 */
class User 
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    
    /**
     * define class properties
     * @param int $id
     */
    public function __construct(int $id) 
    {
        $conn = DBconnect::getInstance();
        $query = $conn->from('users')
                     ->select('users.id, users.name')
                     ->where('users.id = ?', $id);
        $current_user = $query->fetch();
        
        $this->name = $current_user[name];
        $this->id = $current_user[id];
    }
    /**
     * 
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
