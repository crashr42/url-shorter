<?php

/**
 * Created by PhpStorm.
 * User: nikita.kem
 * Date: 2/18/17
 * Time: 7:46 PM
 */

namespace UrlShorter\Libs;

use RuntimeException;

class Template
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $variables;

    /**
     * Template constructor.
     * @param string $path
     * @param array $variables
     */
    public function __construct($path, array $variables = [])
    {
        $this->path      = $path;
        $this->variables = $variables;
    }

    /**
     * Render template.
     *
     * @return string
     * @throws RuntimeException
     */
    public function render()
    {
        if (!file_exists($this->path) || !is_file($this->path)) {
            throw new RuntimeException("Template {$this->path} not found.");
        }

        ob_start();

        /** @noinspection PhpIncludeInspection */
        include $this->path;

        return ob_get_clean();
    }

    /**
     * Get template variable.
     *
     * @param string $name
     * @return mixed
     * @throws RuntimeException
     */
    public function __get($name)
    {
        return array_get($this->variables, $name, function () use ($name) {
            throw new RuntimeException("Variable {$name} not exists in view {$this->path}.");
        });
    }
}
