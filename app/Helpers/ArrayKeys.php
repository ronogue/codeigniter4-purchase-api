<?php

namespace App\Helpers;

class ArrayKeys
{
    public static function toSnakeCase(array $data): array
    {
        $snakeCasedArray = [];

        foreach ($data as $key => $value) {

            $snakeCasedKey = trim(strtolower(preg_replace('/[A-Z]/', '_$0', $key)), '_');

            if (is_array($value)) {
                $value = self::toSnakeCase($value);
            }

            $snakeCasedArray[$snakeCasedKey] = $value;
        }

        return $snakeCasedArray;
    }

    public static function pickKeys(array $data, array $keys): array
    {
        return array_intersect_key($data, array_flip($keys));
    }
}
