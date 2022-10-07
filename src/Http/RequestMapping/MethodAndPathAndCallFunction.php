<?php

namespace PelFramework\Http\RequestMapping;

class MethodAndPathAndCallFunction{

      private $method;
      private $path;
      private $callFunction;

      public function __construct($method,$path,$callFunction)
      {
            $this->setCallFunction($callFunction);
            $this->setPath($path);
            $this->setMethod($method);
      }

      private function setCallFunction($callFunction){
            $this->callFunction = $callFunction;
      }

      public  function getCallFunction()
      {
            return $this->callFunction;
      }

      private function setMethod($method){
            $this->method = $method;
      }

      public  function getMethod()
      {
            return $this->method;
      }

      private function setPath($path){
            $this->path = $path;
      }

      public  function getPath()
      {
            return $this->path;
      }
      

}