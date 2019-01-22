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


interface ContextInterface
{
    function getState();

    function setState($state);

    function getProperty($name);

    function addProperty($name, $value);

    function deleteProperty($name);

    function getProperties();
}