<?php

namespace testNameSpace;

use Exception;
use PelFramework\IoC\EntityManager;
use PelFramework\IoC\Exceptions\OnlyOneOfClassIdOrValueMustBeExist;
use PHPUnit\Framework\TestCase;


class testClass1{

}

class testClass2{
      private testClass1 $firstDependency;
        /**
       * Get the value of firstDependency
       */ 
      public function getFirstDependency()
      {
            return $this->firstDependency;
      }

      /**
       * Set the value of firstDependency
       *
       * 
       */ 
      public function setFirstDependency($firstDependency)
      {
            $this->firstDependency = $firstDependency;
      }
}

class testClass3{
     
      private $valueOne;
      private $valueTwo;


      public function getValueOne()
      {
            return $this->valueOne;
      }

      public function setValueOne($valueOne)
      {
            $this->valueOne = $valueOne;
      }

      public function getValueTwo()
      {
            return $this->valueTwo;
      }

      public function setValueTwo($valueTwo)
      {
            $this->valueTwo = $valueTwo;
      }
}


final class IoCTest extends TestCase
{
 
    public function test_create_one_class_and_is_get_class_equals()
    {
            $entityManager = EntityManager::getEntityManager();

            $entityManager->create("class1","testNameSpace\\TestClass1",[]);

            $getClass1First = $entityManager->get("class1");
            $getClass1Second = $entityManager->get("class1");

            $this->assertEquals($getClass1First,$getClass1Second);

    }

    public function test_is_create_depended_class(){
            $entityManager = EntityManager::getEntityManager();

            $entityManager->create("testClass1","testNameSpace\\TestClass1",[]);

            $entityManager->create("testClass2","testNameSpace\\TestClass2",[
                  ["classId" => "testClass1","attributeName" =>"firstDependency" ]
            ]);

            $this->assertNotEmpty($entityManager->get("testClass1"));
            $this->assertNotEmpty($entityManager->get("testClass2"));

      }


      public function test_for_just_attribute_class(){
            $entityManager = EntityManager::getEntityManager();

            $entityManager->create("testClass3","testNameSpace\\TestClass3",[
                  ["value" => "test","attributeName" =>"valueOne" ],
                  ["value" => "test2","attributeName" =>"valueTwo" ],
            ]);

            $class = $entityManager->get("testClass3");
            $this->assertEquals($class->getValueOne(),"test");
            $this->assertEquals($class->getValueTwo(),"test2");
      }

      public function test_for_dependency_attribute_value_and_classId(){
            $entityManager = EntityManager::getEntityManager();
            try{
                  $entityManager->create("testClass4","testNameSpace\\TestClass3",[
                        ["value" => "test","classId"=>"testClass1","attributeName" =>"valueOne" ],
                  ]);

            }catch(Exception $e){
                  $this->assertEquals(get_class($e),"PelFramework\IoC\Exceptions\OnlyOneOfClassIdOrValueMustBeExist");

            }

      }
      
 

    
}