<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 4:52 PM
 */

namespace UrlShorter;

use UrlShorter\libs\Database\DbDriverInterface;

class LongUrlRepository
{
    /**
     * @var DbDriverInterface
     */
    private $db;

    /**
     * LongUrlRepository constructor.
     * @param DbDriverInterface $db
     */
    public function __construct(DbDriverInterface $db)
    {
        $this->db = $db;
    }

    /**
     * Save long url and hash to persistent store.
     *
     * @param string $longUrl
     * @param string $hash
     */
    public function save($longUrl, $hash)
    {
        $this->db->insert('urls', [
            'long_url'   => $longUrl,
            'hash'       => $hash,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Find long url by hash.
     *
     * @param string $hash
     * @return array|null
     */
    public function find($hash)
    {
        $row = $this->db->selectRow('SELECT * FROM urls WHERE hash = :hash', [
            'hash' => $hash,
        ]);

        return \UrlShorter\Libs\array_get($row, 'long_url');
    }
}
