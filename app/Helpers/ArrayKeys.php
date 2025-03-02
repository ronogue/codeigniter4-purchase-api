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
}
