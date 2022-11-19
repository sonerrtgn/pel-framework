<?php

namespace PelFramework\IoC;

class ClassInformation{

      private string $classNamespace;

      private array $dependencys;

      private $class = false;

      /**
       * @param string $classNamespaceAndName your class namespace and class name. Example : PelFreamwork/src/IoC/EntityManager
       * @param array  $dependencys your class dependencys example [["classId" => "USER_REPOSİTORY","attributeName" => "userRepo"]]
       * @param object $class this information class.
       */
      public function __construct(string $classNamespaceAndName,array $dependencys,object $class){
            $this->classNamespace = $classNamespaceAndName;
            $this->dependencys = $dependencys;
            $this->class = $class;
      }
      /**
       * Get the value of classNamespace
       */ 
      public function getClassNamespace(){ return $this->classNamespace; }

      /**
       * Set the value of classNamespace
       *
       * 
       */ 
      public function setClassNamespace($classNamespace){ $this->classNamespace = $classNamespace; }

      /**
       * Get the value of dependencys
       */ 
      public function getDependencys(){ return $this->dependencys; }

      /**
       * Set the value of dependencys
       *
       * 
       */ 
      public function setDependencys($dependencys) { $this->dependencys = $dependencys; }

      public function addDependencys($newDependencys){
            $this->dependencys[] = $newDependencys;
      }

      

      /**
       * Get the value of class
       */ 
      public function getClass(){ return $this->class; }

      /**
       * Set the value of class
       *
       * 
       */ 
      public function setClass($class){ $this->class = $class; }

}