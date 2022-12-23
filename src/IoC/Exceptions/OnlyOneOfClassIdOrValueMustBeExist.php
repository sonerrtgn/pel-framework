<?php

namespace PelFramework\IoC\Exceptions;

use Exception;

class OnlyOneOfClassIdOrValueMustBeExist extends Exception{

      public function __construct($className) {
            $code = 2000004;
            $message = "Only One Of ClassId Or Value Must Be Exist for : " . $className;
            parent::__construct($message, $code, null);
        }

      public function __toString() {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
      }

}