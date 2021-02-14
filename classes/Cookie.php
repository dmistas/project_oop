<?php

class Cookie
{
    /**
     * Проверить наличие куки по имени $name
     *
     * @param string $name
     * @return bool
     */
    public static function exists(string $name)
    {
        return isset($_COOKIE[$name]);
    }

    /**
     * Получить значние куки с именем $name
     *
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return $_COOKIE[$name];
    }

    /**
     * Записывает в куки имя $name значение $value время жизни $expiry
     * @param string $name
     * @param string $value
     * @param int $expiry
     *
     * @return boolean
     */
    public static function put(string $name, string $value, int $expiry)
    {
        if (setcookie($name, $value, time() + $expiry, '/')) {
            return true;
        }
        return false;
    }

    /**
     * Удаляет куки по имени $name
     *
     * @param string $name
     * @return bool
     */
    public static function delete(string $name): bool
    {
        return self::put($name, '', time() - 1);
    }

}