<?php

namespace imed;

class Session
{
    public static function init()
    {
        // Verify if there is an existing session if none, implement session start()
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }       
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