<?php

class Session
{
    public function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setUser($user)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    public function destroy()
    {
        session_unset();
        session_destroy();
    }
}
