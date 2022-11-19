<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class IoCSetterMethodNotFoundException extends Exception{

      public function __construct($attributeName) {
            $code = 2000002;
            $message = "Ioc Container: setter method not found for this attribute: " . $attributeName;
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}