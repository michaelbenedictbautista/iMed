<?php

namespace imed;

class Session
{
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // if (!isset($_SESSION)) {
        //     session_start();
        // }
    }

    // Getters, setters and unset
    public static function set($name, $value)
    {
        self::init();
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        self::init();
        // // if ? else : ---------
        // return $_SESSION[$name] ? $_SESSION[$name] : null;

        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = $_SESSION[$name];
        } else {
            $_SESSION[$name] = null;
        }
        return $_SESSION[$name];
    }

    public static function unset($name)
    {
        self::init();
        unset($_SESSION[$name]);
    }
}
