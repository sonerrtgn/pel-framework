<?php

include("../../../src/Http/Converter/CreateRequest.php");
include("../../../src/Http/Request.php");
include("../../../src/Http/RequestMapping/RequsetMapping.php");
include("../../../src/Http/RequestMapping/MethodAndPathAndCallFunction.php");

use PelFramework\Http\Converter\CreateRequest;
use PelFramework\Http\Request;
use PelFramework\Http\RequestMapping\RequestMapping;

$_SERVER["REQUEST_URI"] = "/soner/123";

$requestMapping = new RequestMapping();

class ControllerOne{
      function test(Request $request){
            echo "hi bro";
      }
}


function bulunmadi(Request $request){
      $uri = implode($request->getPath());
      echo "url : $uri not founded";
      http_response_code(404);
}
$requestMapping->getMapping("/soner/1232","ControllerOne::test");

$requestMapping->setNotFoundPageFunction("bulunmadi");
$requestMapping->run();
?>