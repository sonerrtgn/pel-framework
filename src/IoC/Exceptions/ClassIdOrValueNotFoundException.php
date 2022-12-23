<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class ClassIdOrValueNotFoundException extends Exception{

      public function __construct($className) {
            $code = 2000003;
            $message = "Ioc Container: classId or value is required for : " . $className;
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}