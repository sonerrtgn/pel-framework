<?php

namespace PelFramework\Http\RequestMapping;

use PelFramework\Http\Request;

class RequestMapping{

      private array $methodAndPathAndCallFunctions = [];

      private $notFoundPageFunction = "";
     
      public function setNotFoundPageFunction($functionName){
            $this->notFoundPageFunction = $functionName;
      }

      public function postMapping($url,$callFunction){
            $this->addMapping("POST",$url,$callFunction);
      }

      public function getMapping($url,$callFunction){
            $this->addMapping("GET",$url,$callFunction);
      }

      public function putMapping($url,$callFunction){
            $this->addMapping("PUT",$url,$callFunction);
      }

      public function deleteMapping($url,$callFunction){
            $this->addMapping("DELETE",$url,$callFunction);
      }

      public function customMapping($method,$url,$callFunction){
            $this->addMapping($method,$url,$callFunction);
      }

      private function addMapping($method,$url,$callFunction){
            $path = $this->uriToPath($url);
            $this->methodAndPathAndCallFunctions[] = new MethodAndPathAndCallFunction($method,$path,$callFunction);
      }
      /**
       * @param string $uri  request uri.
       * @return array $path uri to path.
       */
      private function uriToPath($uri){
            $path =  explode("/",$uri);
            $path = array_splice($path,1,count($path));
            
            return $path;
      }

      public function run(){ 
            $request = Request::getRequestClass();
            foreach ($this->methodAndPathAndCallFunctions as $methodAndPathAndCallFunction) {
                  if($request->getMethod() != $methodAndPathAndCallFunction->getMethod()){
                        continue;
                  }

                  $requestPath = $request->getPath();
                  $methodAndPathAndCallFunctionPath = $methodAndPathAndCallFunction->getPath();
                  
                  if(count($requestPath) != count($methodAndPathAndCallFunctionPath)){
                        continue;
                  }

                  $isFind = true; 
                  $count = 0;
                  $requestPathCount = count($requestPath);
                  while($count < $requestPathCount){
                        /**
                         * if path is start ':' it dont should control beacuse is dynamic path.
                         */
                        if($methodAndPathAndCallFunctionPath[$count][0] == ":"){
                              continue;
                        }

                        if($methodAndPathAndCallFunctionPath[$count] != $requestPath[$count]){
                              $isFind = false;
                              break;
                        }
                        $count++;
                  }
                  
                  if($isFind){
                        $this->runCallFunction($methodAndPathAndCallFunction->getCallFunction(),$request);
                        return;
                  }
            }

            if($this->notFoundPageFunction != ""){
                  $this->runCallFunction($this->notFoundPageFunction,$request);
                  return;                  
            }

            


      }

      private function runCallFunction($functionName,Request $request){
            $isClassAndMethod = strpos($functionName, "::");

            if ($isClassAndMethod === false) { // just function
                  $functionName($request);
                  return;
            }
            $classAndFunction = explode("::",$functionName);
            $className = $classAndFunction[0];
            $functionName  = $classAndFunction[1];

            $class = new $className();

            $class->$functionName($request);
      } 
}