<?php

class Session
{
    /**
     * Добавить переменную $value в сессию с именем $name
     *
     * @param string $name
     * @param string|array $value
     *
     * @return string|array
     */
    public static function put(string $name, $value)
    {
        return $_SESSION[$name] = $value;
    }

    /**
     * Проверка наличия в сессии переменной $name
     *
     * @param $name
     * @return bool
     */
    public static function exists($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Удаление переменной с именем $name из сессии
     *
     * @param string $name
     */
    public static function delete(string $name):void
    {
        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Получить перменную $name из сессии
     *
     * @param string $name
     * @return mixed
     */
    public static function get(string $name)
    {
        return $_SESSION[$name];
    }

    /**
     * Вернуть при наличии или записать flash сообщение ключ = $name, значние = $string в сессию
     *
     * @param string $name
     * @param string $string
     *
     * @return mixed
     */
    public static function flash(string $name, string $string = '')
    {
        if (self::exists($name) && self::get($name) !== '') {
            $session = self::get($name);
            self::delete($name);
            return $session;
        }
        self::put($name, $string);
    }
}
