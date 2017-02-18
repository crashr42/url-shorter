<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 6:33 PM
 */

namespace UrlShorter\Libs\Database;

use PDO;

class PdoMysqlDriver implements DbDriverInterface
{
    /**
     * @var
     */
    private $host;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $password;

    /**
     * @var
     */
    private $charset;

    /**
     * @var
     */
    private $strict;

    /**
     * @var
     */
    private $database;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * PdoMysqlDriver constructor.
     * @param string $database
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $charset
     * @param bool $strict
     */
    public function __construct($database, $host, $user, $password, $charset, $strict)
    {
        $this->database = $database;
        $this->host     = $host;
        $this->user     = $user;
        $this->password = $password;
        $this->charset  = $charset;
        $this->strict   = $strict;
    }

    /**
     * Initialize from array config.
     *
     * @param array $config
     * @return static
     */
    public static function fromArrayConfig($config)
    {
        return new static(
            $config['database'], $config['host'],
            $config['user'], $config['password'],
            $config['charset'], $config['strict']
        );
    }

    /**
     * Insert one row to table. Return inserted rows count.
     *
     * @param string $table
     * @param array $row
     * @return int
     * @throws DbException
     */
    public function insert($table, $row)
    {
        $columns = array_keys($row);

        $placeholders = array_map(function ($column) {
            return ":{$column}";
        }, $columns);

        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(', ', $columns), implode(', ', $placeholders));

        $statement = $this->connection()->prepare($query);
        foreach ($row as $column => $value) {
            $statement->bindValue(":{$column}", $value);
        }
        if (!$statement->execute()) {
            $errorInfo = $statement->errorInfo();

            throw new DbException(sprintf('%s: %s', $errorInfo[1], $errorInfo[2]), $errorInfo[0]);
        }

        return $statement->rowCount();
    }

    /**
     * Initialize mysql connection.
     *
     * @return PDO
     */
    protected function connection()
    {
        if ($this->connection === null) {
            $connection = new PDO(sprintf('mysql:host=%s;dbname=%s', $this->host, $this->database), $this->user, $this->password);

            $connection->prepare(sprintf('SET NAMES %s', $this->charset))->execute();

            if ($this->strict) {
                $connection->prepare("set session sql_mode='STRICT_ALL_TABLES'")->execute();
            } else {
                $connection->prepare("set session sql_mode=''")->execute();
            }

            $this->connection = $connection;
        }

        return $this->connection;
    }

    /**
     * Select one row from database.
     *
     * @param string $query
     * @param array $params
     * @return array
     */
    public function selectRow($query, $params)
    {
        // TODO: Implement selectRow() method.
    }
}
