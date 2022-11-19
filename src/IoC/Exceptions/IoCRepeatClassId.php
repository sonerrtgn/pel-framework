<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class IoCRepeatClassIdException extends Exception{

      public function __construct() {
            $code = 2000001;
            $message = "Ioc Container: Repeat class id, class id is not repeat.";
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}