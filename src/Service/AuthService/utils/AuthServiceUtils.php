<?php


namespace App\Service\AuthService\utils;


class AuthServiceUtils
{
    public function mapFieldsToEntity($entity, $data)
    {
        foreach($data as $key => $value){
            if (strpos($key, "_") !== false) {
                $arr = explode("_", $key);
                $newKey = "";
                foreach ($arr as $word) {
                    $newKey .= ucfirst($word);
                }
            } else {
                $newKey = ucfirst($key);
            }
            $method = "set" . $newKey;
            if (method_exists($entity, $method)) {
                $entity->$method($value);
            }
        }
        return $entity;
    }
}