<?php

namespace PelFramework\Http\Converter;

use PelFramework\Http\Request;

class CreateRequest{

      private Request $request;

      public function __construct()
      {
            $path   = $this->uriToPath($_SERVER["REQUEST_URI"]);
            $header = getallheaders();
            $body   = $this->getRequestBody();
            $method = $_SERVER["REQUEST_METHOD"];
            $this->request = new Request($path,$header,$body,$method);
      }

      public function getRequestClass(){
            return $this->request;
      }


      /**
       * @param string $uri  request uri.
       * @return array $path path to uri.
       */
      private function uriToPath($uri){
            $path =  explode("/",$uri);
            $path = array_splice($path,1,count($path));
            
            return $path;
      }

      private function getRequestBody(){
            return file_get_contents('php://input');

      }
}