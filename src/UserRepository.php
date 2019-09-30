<?php

namespace Tudublin;

use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;
use Mattsmithdev\PdoCrudRepo\DatabaseManager;

class UserRepository extends DatabaseTableRepository
{
    public function __construct()
    {
        parent::__construct(__NAMESPACE__, 'User', 'users');
    }

    public function existsUser($username, $password)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();



        $sql = "SELECT * FROM users WHERE userName = '$username' AND password = '$password' LIMIT 1";
//        $user = $connection->query($sql)->fetch();

        $stmt = $connection->query($sql);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, '\Tudublin\User');
        $user = $stmt->fetch();


        if($user){
            return true;
        } else {
            return false;
        }
    }


}