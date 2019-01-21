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


interface StateInterface
{
    const INITIAL_STATE = 'initial';
    const NORMAL_STATE = 'normal';
    const FINAL_STATE = 'final';

    public function getName();

    public function getType();
}