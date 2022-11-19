<?php

namespace testNameSpace;

use PelFramework\IoC\EntityManager;
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
 

    
}