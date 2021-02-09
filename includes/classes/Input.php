<?php

class Input
{
    /**
     * Возвращает true|false наличия запроса GET или POST
     * по умолчанию POST
     *
     * @param string $type
     * @return bool
     *
     */
    public static function exist($type = "post")
    {
        switch ($type) {
            case 'post':
                return (!empty($_POST)) ? true : false;
            case 'get':
                return (!empty($_GET)) ? true : false;
            default:
                return false;
        }
    }

    /**
     * Возвращает элемент по имени $item из массива $_GET или $_POST
     * или пустую строку, если элемент не найден
     *
     * @param $item
     * @return mixed|string
     */
    public static function get($item)
    {
        if (isset($_POST[$item])) {
            return $_POST[$item];
        } else if (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}
