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
 * Class NormalState
 *
 * @package Rotoscoping\Comedian\State
 */
class NormalState extends BaseState
{
    public function __construct(string $name)
    {
        parent::__construct($name, StateInterface::NORMAL_STATE);
    }
}