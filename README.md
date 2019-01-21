# COMEDIAN 

[![Build Status](https://travis-ci.org/alvlapo/comedian.svg?branch=master)](https://travis-ci.org/alvlapo/comedian)

A finite state machine for php

## Requirements and installation

- PHP 7.0+

## Usage

### State definition

#### Simple state definition
```php
$state = new NormalState('state');

$state
  ->event('publish', 'published')
  ->trigger('beforePublish', function() { /* exec before $state->publish() run */ })
  ->trigger('onExit', function() { return /* will be executed when leaving this state */; });
  
$state->publish(); // return 'published'
```

#### Class based state definition

```php
// file SimpleState.php
class SimpleState implements StateInterface {
  
  // public method it is event
  public function publish()
  {
    return 'published';
  }
  
  // before<*> or after<*> it is triggers
  // runs before and after event execute
  public function beforePublish()
  {
    return true;
  }
  
  // This is trigger like an 'onExit', 'onReset'
  public function onExit()
  {
    return true;
  }
}

$state = new SimpleState();
$state->publish(); // return 'published'
```

## Inspired by

* [workflux](https://github.com/shrink0r/workflux) - Finite state machine for php.
* [UnderStated](https://github.com/Daveawb/UnderStated) - A PHP Finite State Machine
* [S-Flow](https://github.com/pwm/s-flow) - A lightweight library for defining state machines that supports conditional transitions 