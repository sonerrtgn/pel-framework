<?php

namespace PelFramework\Http;

class Request{

	private static Request $request;
	private static $isDefined = false;

      private $path;

	private $url;

      private $header;

      private $body;

      private $method; 

      private function __construct($url,$path,$header,$body,$method){
		$this->setUrl($url);
            $this->setPath($path);
		$this->setHeader($header);
		$this->setBody($body);
		$this->setMethod($method);
      }

	public static function getRequestClass(){
            if(self::$isDefined == 0){
			self::$isDefined = 1;
			$url = $_SERVER["REQUEST_URI"];
			$path   = Request::uriToPath($_SERVER["REQUEST_URI"]);
			$header = getallheaders();
			$body   = Request::getRequestBody();
			$method = $_SERVER["REQUEST_METHOD"];
			
			self::$request = new Request($url,$path,$header,$body,$method);
			return self::$request;

		}else{
			return self::$request;
		}
      }

	/**
       * @param string $uri  request uri.
       * @return array $path path to uri.
       */
      private static function uriToPath($uri):array{
            $path =  explode("/",$uri);
            $path = array_splice($path,1,count($path));
            
            return $path;
      }

      private static function getRequestBody(){
		if(!isset(getallheaders()["Content-Type"])){
			return file_get_contents('php://input');
		}
		$contentType = getallheaders()["Content-Type"];

		if($contentType == "application/x-www-form-urlencoded"){
			return $_POST;
		}

		if(strpos($contentType, "multipart/form-data;")){
			return $_FILES ;
		}
		if($contentType =="application/json" ){
			return json_decode(file_get_contents('php://input'));
		}
		if($contentType =="application/xml"){
			return simplexml_load_string(file_get_contents('php://input'));
		}
            return file_get_contents('php://input');
      }
	
      public function getPath(){
		return $this->path;
	}

	public function setPath($path){
		$this->path = $path;
	}

	public function getHeader(){
		return $this->header;
	}

	public function setHeader($header){
		$this->header = $header;
	}

	public function getBody(){
		return $this->body;
	}

	public function setBody($body){
		$this->body = $body;
	}

      
	public function getMethod(){
		return $this->method;
	}

	public function setMethod($method){
		$this->method = $method;
	}

	public function getUrl(){
		return $this->url;
	}

	public function setUrl($url){
		$this->url = $url;
	}
}
