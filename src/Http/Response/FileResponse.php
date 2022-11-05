<?php
namespace PelFramework\Http\Response;

use PelFramework\Http\Response\Response;

class FileResponse extends Response{
      
      private string $fileAddress;

      public function __construct(string $fileAddress)
      {
            $this->setFileAddress($fileAddress);
            $this->fileResponseConvertDataToResponse();
      }

      private function fileResponseConvertDataToResponse(){
            $file = fopen($this->getFileAddress(), "r",);
            $body = fread($file,filesize($this->getFileAddress()));
            $this->setBody($body);
            fclose($file);
            $this->findApplicationTypeFromFileAddress();
            
            $this->setResponseCode(Response::$HTTP_STATUS_OK);
      }

      private function findApplicationTypeFromFileAddress(){
            $pathFileAddress = explode(".",$this->getFileAddress());
            $fileType = $pathFileAddress[count($pathFileAddress)-1];
            $fileType = strtolower($fileType);

            if($fileType == "jpg" || $fileType == "jpeg" ){
                  $this->addHeader("Content-Type:image/jpeg");
                  return ;
            }

            if($fileType == "png"){
                  $this->addHeader("Content-Type:image/png");
                  return ;
            }

            if($fileType == "gif"){
                  $this->addHeader("Content-Type:image/gif");
                  return ;
            }

            if($fileType == "svg"){
                  $this->addHeader("Content-Type:image/svg+xml");
                  return ;
            }

            if($fileType == "webp"){
                  $this->addHeader("Content-Type:image/webp");
                  return ;
            }

            if($fileType == "txt" || $fileType == "html"){
                  $this->addHeader("Content-Type:text/html");
                  return ;
            }
            if($fileType == "mpeg"){
                  $this->addHeader("Content-Type:audio/mpeg");
                  return ;
            }
            if($fileType == "mp4"){
                  $this->addHeader("Content-Type:video/mp4");
                  return ;
            }
      }


      public function getFileAddress(){ return $this->fileAddress; }
      public function setFileAddress(string $fileAddress){$this->fileAddress = $fileAddress;}
}