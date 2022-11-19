<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class IoCUnkownClassId extends Exception{

      public function __construct($classId) {
            $code = 2000004;
            $message = "Ioc Container: classId is not find, class id:  " . $classId;
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}