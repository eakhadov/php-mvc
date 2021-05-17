<?php

namespace Engine\Core\Database;

use Engine\Core\Config\Config;

class Database
{
    /**
     * @var array All databse connections
     */
    protected static array $connections = [];

    /**
     * Get the current connection.
     *
     * @return null|PDO
     */
    public static function connection(string $db): mixed
    {
        return (static::$connections[$db]) ?? null;
    }

    /**
     * Initializes the database connection.
     *
     * @param string $db Db name
     * @return void
     */
    public static function initialize(string $db = 'engine'): void
    {
        if (!isset(static::$connections[$db])) {
            static::$connections[$db] = static::connect($db);
        }
    }

    /**
     * Finalize the database connection.
     *
     * @param string $db Db name
     * @return void
     */
    public static function finalize(string $db = ''): void
    {
        switch ($db) {
            case '':
                static::$connections = [];
                break;

            default:
                static::$connections[$db] = null;
                break;
        }
    }

    /**
     * Connect to the database.
     *
     * @return null|PDO
     * @throws Exception
     */
    private static function connect(string $db)
    {
        extract(Config::item($db, 'database'));

        $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', $driver, $host, $database, $charset);

        if ('' === $driver || '' === $username || '' === $database || '' === $host) {
            return null;
        }

        try {
            $connection = new \PDO($dsn, $username, $password, $options);

        } catch (\PDOException $error) {
            throw new \Exception($error->getMessage());
        }

        return ($connection) ?: null;
    }
}
