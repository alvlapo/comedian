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
 * Class FinalState
 *
 * @package Rotoscoping\Comedian\State
 */
class FinalState extends BaseState
{
    /**
     * FinalState constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name, StateInterface::FINAL_STATE);
    }
}