<?php

class Config
{
    /**
     * Получает значение поля конфигурации по пути через "."
     * @param string $path
     *
     * @return string|false
     */
    public static function getConfigItem($path=null)
    {
        $config = $GLOBALS['config'];
        if (!$path){
            return false;
        }
        $path = explode('.', $path);
        foreach ($path as $item){
            if (isset($config[$item])){
                $config = $config[$item];
            }
        }
        return $config;

    }
}

