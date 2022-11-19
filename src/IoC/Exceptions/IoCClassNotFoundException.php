<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class IoCClassNotFoundException extends Exception{

      public function __construct($className) {
            $code = 2000002;
            $message = "Ioc Container: class is not found, please control your class name. Added class name: " . $className;
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}