<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class IoCConstructorParametersException extends Exception{

      public function __construct($className) {
            $code = 2000003;
            $message = "Ioc Container: your " . $className . " class constructor not without parameters.";
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}