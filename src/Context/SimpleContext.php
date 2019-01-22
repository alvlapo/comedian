<?php
/*
 * This file is part of Comedian - a PHP finite state machine.
 *
 * (c) Alexandr Polyakov <alvlapo@gmail.com> 2019
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Rotoscoping\Comedian\Context;

/**
 * Class SimpleContext
 *
 * @package Rotoscoping\Comedian\Context
 */
class SimpleContext implements ContextInterface
{
    /**
     * Current state of context
     *
     * @var null|string
     */
    private $currentState = null;

    /**
     * Collection of properties
     *
     * @var mixed[]
     */
    private $properties = [];

    /**
     * Class constructor
     *
     * @param $state
     */
    public function __construct(string $state = null)
    {
        $this->currentState = $state;
    }

    /**
     * Get current state from context
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->currentState;
    }

    /**
     * Set current state to context
     *
     * @param $state string
     *
     * @return bool
     */
    public function setState($state)
    {
        $this->currentState = $state;

        return true;
    }

    /**
     * Get property by name
     *
     * @param $name
     * @return mixed
     */
    public function getProperty($name)
    {
        if (!key_exists($name, $this->properties)) {

            return null;
        }

        return $this->properties[$name];
    }

    /**
     * Add or replace property
     *
     * @param $name
     * @param $value
     *
     * @return bool
     */
    public function addProperty($name, $value)
    {
        $this->properties[$name] = $value;

        return true;
    }

    /**
     * Get all properties
     *
     * @return mixed[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Delete property from context
     *
     * @param $name
     *
     * @return bool
     */
    public function deleteProperty($name)
    {
        if (!key_exists($name, $this->properties)) {

            return false;
        }

        unset($this->properties[$name]);

        return true;
    }
}