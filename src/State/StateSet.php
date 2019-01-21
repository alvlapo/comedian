<?php
/*
 * This file is part of Comedian - a PHP finite state machine.
 *
 * (c) Alexandr Polyakov <alvlapo@gmail.com> 2019
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Rotoscoping\Comedian\State;

/**
 * Class StateSet
 *
 * @package Rotoscoping\Comedian\State
 */
class StateSet implements \Countable
{
    /**
     * List of initial states
     *
     * @var StateInterface[]
     */
    private $initialStates = [];

    /**
     * Set of normal states
     *
     * @var StateInterface[]
     */
    private $normalStates = [];

    /**
     * List of final states
     *
     * @var StateInterface[]
     */
    private $finalStates = [];

    /**
     * List of all states
     *
     * @var StateInterface[]
     */
    private $allStates = [];

    /**
     * Class construct
     *
     * @param $states
     */
    public function __construct(StateInterface ...$states)
    {
        array_map([$this, 'add'], $states);
    }

    /**
     * Add state to set
     *
     * @param StateInterface $state
     *
     * @return StateSet
     */
    public function add(StateInterface $state)
    {
        $name = $state->getName();
        $type = $state->getType();

        $list = $type . 'States';

        $this->{$list}[$name] = $state;
        $this->allStates[$name] = $state;

        return $this;
    }

    /**
     * Remove state from set
     *
     * @param $name
     * @return boolean
     */
    public function remove($name)
    {
        if (!$this->has($name)) {

            return false;
        }

        $type = $this->get($name)->getType();

        unset($this->allStates[$name]);
        unset($this->{$type}[$name]);

        return true;
    }

    /**
     * Check initial states exists
     *
     * @return boolean
     */
    public function hasInitial()
    {
        return !empty($this->initialStates);
    }

    /**
     * getInitial
     *
     * @return StateInterface[]|null
     */
    public function getInitial()
    {
        return $this->hasInitial() ? array_values($this->initialStates) : null;
    }

    /**
     * Check final states exists
     *
     * @return boolean
     */
    public function hasFinal()
    {
        return !empty($this->finalStates);
    }

    /**
     * Get all final states
     *
     * @return StateInterface[]|null
     */
    public function getFinal()
    {
        return $this->hasFinal() ? array_values($this->finalStates) : null;
    }

    /**
     * Check normal states exists
     *
     * @return bool
     */
    public function hasNormal()
    {
        return !empty($this->normalStates);
    }

    /**
     * Get all normal states
     *
     * @return StateInterface[]|null
     */
    public function getNormal()
    {
        return $this->hasNormal() ? array_values($this->normalStates) : null;
    }

    /**
     * Get all states
     *
     * @return StateInterface[]
     */
    public function getAll()
    {
        return array_values($this->allStates);
    }

    /**
     * Get state by name
     *
     * @param $name
     *
     * @return StateInterface
     */
    public function get($name)
    {
        return $this->has($name) ? $this->allStates[$name] : null;
    }

    /**
     * Check state exists
     *
     * @param $name
     *
     * @return boolean
     */
    public function has($name)
    {
        return key_exists($name, $this->allStates);
    }

    /**
     * Count elements of an object
     * @link https://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return sizeof($this->allStates);
    }
}