<?php
/*
 * This file is part of Comedian - a PHP finite state machine.
 *
 * (c) Alexandr Polyakov <alvlapo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Rotoscoping\Comedian\State;

/**
 * Class BaseState
 *
 * @package Rotoscoping\Comedian\State
 */
abstract class BaseState implements StateInterface
{
    /**
     * A state name
     *
     * @var string
     */
    private $name;

    /**
     * A state type
     *
     * @var string
     */
    private $type;

    /**
     * Return value by event name
     *
     * @var mixed[]
     */
    private $events = [];

    /**
     * List of triggers
     *
     * @var callable[]
     */
    private $triggers = [];

    /**
     * Class constructor
     *
     * @param $name string
     * @param $type mixed
     */
    public function __construct($name, $type = StateInterface::NORMAL_STATE)
    {
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (key_exists($name, $this->events)) {

            if (is_callable($this->events[$name])) {

                return call_user_func_array($this->events[$name], $arguments);
            }

            return $this->events[$name];
        }

        if (key_exists($name, $this->triggers)) {

            return call_user_func_array($this->triggers[$name], $arguments);
        }

        return;
    }

    /**
     * Get state name
     *
     * @param 
     * @return
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get state type
     *
     * @param 
     * @return
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add event to state
     *
     * @param $name
     * @param $returnValue
     * @return self
     */
    public function event($name, $returnValue)
    {
        $this->events[$name] = $returnValue;

        return $this;
    }

    /**
     * trigger
     *
     * @param $name
     * @param callable $callback
     * @return self
     */
    public function trigger($name, callable $callback)
    {
        $this->triggers[$name] = $callback;

        return $this;
    }
}