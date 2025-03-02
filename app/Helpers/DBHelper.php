<?php

namespace App\Helpers;

use CodeIgniter\Database\Exceptions\DatabaseException;

class DBHelper
{
    /**
     * Execute a callback within a database transaction.
     *
     * @param callable(): mixed $callback
     * @return mixed
     * @throws DatabaseException
     */
    public static function transaction(callable $callback)
    {
        $db = \Config\Database::connect();
        $db->transException(true)->transStart();

        try {

            $result = $callback();
            $db->transComplete();

            return $result;
        } catch (DatabaseException $e) {

            $db->transRollback();
            throw $e;
        }
    }
}
