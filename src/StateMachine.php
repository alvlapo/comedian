<?php
/*
 * This file is part of Comedian - a PHP finite state machine.
 *
 * (c) Alexandr Polyakov <alvlapo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Rotoscoping\Comedian;

use Rotoscoping\Comedian\State\StateSet;
use Rotoscoping\Comedian\State\StateInterface;
use Rotoscoping\Comedian\Context\SimpleContext;
use Rotoscoping\Comedian\Context\ContextInterface;

/**
 * Class StateMachine
 *
 * @package Rotoscoping\Comedian
 */
class StateMachine
{
    private $machineName;

    /**
     * @var ContextInterface
     */
    private $stateContext;

    /**
     * @var StateSet
     */
    private $stateSet;

    /**
     * Class constructor
     *
     * @param $name string
     * @param $stateSet StateSet
     * @param $context ContextInterface
     */
    public function __construct(string $name, ContextInterface $context = null, StateSet $stateSet = null)
    {
        $this->machineName = $name;
        $this->stateSet = $stateSet ?: new StateSet();
        $this->stateContext = $context ?: new SimpleContext();
    }

    /**
     * Get state machine name
     *
     * @return string
     */
    public function getMachineName(): string
    {
        return $this->machineName;
    }

    /**
     * Get state machine context
     *
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->stateContext;
    }

    /**
     * Set state context to machine
     *
     * @param $context ContextInterface
     * @return self
     */
    public function setContext(ContextInterface $context): self
    {
        $this->stateContext = $context;

        return $this;
    }

    /**
     * Add state to machine
     *
     * @param $state StateInterface
     * @return self
     */
    public function addState(StateInterface $state): self
    {
        $this->stateSet->add($state);

        return $this;
    }

    /**
     * getState
     *
     * @param 
     * @return
     */
    public function getState()
    {
        $stateName = $this->stateContext->getState();

        return $this->stateSet->get($stateName);
    }

    public function __get($attribute)
    {
        $property = $this->stateContext->getProperty($attribute);

        if ($property != null) {
            
            return $property;
        }
    }

    public function __set($attribute, $value)
    {
        $property = $this->stateContext->getProperty($attribute);

        $this->stateContext->addProperty($attribute, $value);
    }
}