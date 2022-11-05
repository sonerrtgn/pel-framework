<?php
namespace PelFramework\Http\Response;

class Response{

      public static int $HTTP_STATUS_OK = 200;

      public static int $HTTP_STATUS_BAD_REQUEST = 400;

      public static int $HTTP_STATUS_UNAUTHORIZED = 401;

      public static int $HTTP_STATUS_FORBIDDEN = 403;

      public static int $HTTP_STATUS_NOT_FOUND = 404;

      public static int $HTTP_STATUS_METHOD_NOT_ALLOWED = 405;

      public static int $HTTP_STATUS_REQUEST_TIME_OUT = 408;

      public static int $HTTP_STATUS_BAD_GATEWAY = 500;




      private array $headers;
      private string $body;
      private int $responseCode;

      
      public function __construct(array $headers, string $body,int $responseCode)
      {
            $this->setheaders($headers);
            $this->setBody($body);
            $this->setResponseCode($responseCode);
      }



      public function sendResponse(){
            foreach ($this->headers as $header) {
                  header($header);
            }
            http_response_code($this->responseCode);
            echo $this->body;
      }

      public function setheaders(array $headers):void{ $this->headers = $headers; }

      public function getheaders(): array{ return $this->headers; }

      public function addHeader(string $newHeader){
            $this->headers[] = $newHeader;
      }

      public function setBody(string $body):void{ $this->body = $body; }

      public function getBody():string { return $this->body; }
      
      public function setResponseCode(int $responseCode):void{ $this->responseCode = $responseCode; }

      public function getResponseCode():int { return $this->responseCode; }
}