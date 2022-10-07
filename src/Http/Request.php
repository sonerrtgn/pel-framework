<?php

namespace PelFramework\Http;

class Request{

      private $path;

      private $header;

      private $body;

      private $method; 

      public function __construct($path,$header,$body,$method){
            $this->path    = $path;
            $this->header  = $header;
            $this->body    = $body;
            $this->method  = $method;

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
}
