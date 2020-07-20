<?php

namespace abhimanyu\config\components;

/**
 * @author Abhimanyu Saharan <abhimanyu@teamvulcans.com>
 */
interface IConfig
{
    /**
     * Get configuration variable
     *
     * @param $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     * Returns all parameters
     *
     * @return array
     */
    public function getAll();

    /**
     * Sets configuration variable
     *
     * @param $name
     * @param mixed $value
     * @return mixed
     */
    public function set($name, $value = null);

    /**
     * Delete parameter
     *
     * @param $name
     * @return mixed
     */
    public function delete($name);

    /**
     * Deletes everything
     *
     * @return mixed
     */
    public function deleteAll();
}