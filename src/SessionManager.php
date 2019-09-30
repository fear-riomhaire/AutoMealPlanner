<?php

namespace Tudublin;


class SessionManager
{
    public function isLoggedIn()
    {
        if(isset($_SESSION['username'])){
            return true;
        } else {
            return false;
        }
    }

    public function storeUsername($username)
    {
        $_SESSION['username'] = $username;
    }

    /**
     * return string - username if in session
     * else return FALSE
     */
    public function usernameFromSession()
    {
        if(isset($_SESSION['username'])){
            return $_SESSION['username'];

        } else {
            return false;
        }
    }

}