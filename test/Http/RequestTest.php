<?php

use PelFramework\Http\Request;
use PelFramework\Http\RequestMapping\RequestMapping;
use PelFramework\IoC\EntityManager;

require_once "../../vendor/autoload.php";



class FirstController{

      public function sayHello(Request $request){
            echo "hi";
      }
}

$entityManager = EntityManager::getEntityManager();

$entityManager->create("firstController","FirstController",[]);

$requestMapping = new RequestMapping();

$requestMapping->getMapping("/myFreamwork/pel-framework/test/Http/RequestTest.php",["classId" => "firstController", "methodName" => "sayHello"]);

$requestMapping->run();