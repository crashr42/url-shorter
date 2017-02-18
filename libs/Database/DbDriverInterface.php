<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 6:33 PM
 */

namespace UrlShorter\Libs\Database;

interface DbDriverInterface
{
    /**
     * Insert one row to table. Return inserted rows count.
     *
     * @param string $table
     * @param array $row
     * @return int
     */
    public function insert($table, $row);

    /**
     * Select one row from database.
     *
     * @param string $query
     * @param array $params
     * @return array
     */
    public function selectRow($query, $params);
}
