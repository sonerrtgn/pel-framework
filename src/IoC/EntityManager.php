<?php

namespace PelFramework\IoC;

use PelFramework\IoC\Exceptions\ClassIdOrValueNotFoundException;
use ReflectionClass;
use PelFramework\IoC\Exceptions\IoCRepeatClassIdException;
use PelFramework\IoC\Exceptions\IoCClassNotFoundException;
use PelFramework\IoC\Exceptions\IoCConstructorParametersException;
use PelFramework\IoC\Exceptions\IoCSetterMethodNotFoundException;
use PelFramework\IoC\Exceptions\IoCUnkownClassId;
use PelFramework\IoC\Exceptions\OnlyOneOfClassIdOrValueMustBeExist;

class EntityManager{

      private static ?EntityManager $entityManager = null;

      private array $classInformation =[];

      public static function getEntityManager(){
            if(self::$entityManager == null){
                  self::$entityManager = new EntityManager();
            }
            return self::$entityManager;
      }

      private function __construct(){}
      /**
       * @param string $classId this uniq id to use to access the generated class
       * @param string $classAddres your class namespace and class name. Example : PelFreamwork/src/IoC/EntityManager
       * @param array  $dependencys your class dependencys example [["classId" => "USER_REPOSİTORY","attributeName" => "userRepo"]]
       * 
       * @return void
       */
      public function create(string $classId,string $classAddres,array $dependencys){
            if(isset($this->classInformation[$classId])){
                  throw new IoCRepeatClassIdException();
            }
            $this->validateClass($classAddres);

            $createdClass = new $classAddres();

            $this->setClassDependencys($createdClass,$dependencys);

            $classInformation = new ClassInformation($classAddres,$dependencys,$createdClass);

            $this->addClassInformation($classId,$classInformation);

      }

      public function get(string $classId){
            if(!isset($this->classInformation[$classId])){
                  throw new IoCUnkownClassId($classId);
            }
            return $this->classInformation[$classId]->getClass();
      }

      private function setClassDependencys($class,array $dependencys){
            if(count($dependencys) != 0){

                  foreach ($dependencys as $dependency) {

                        $this->validateDependencyValue($class,$dependency);
                        
                        if(isset($dependency["classId"])){
                              $this->setClassDependencyForClass($class,$dependency);
                              return ;
                        }
                        $this->setValueDependencyForClass($class,$dependency);
                  }
            }
            return $class;
      }

      private function validateDependencyValue($class,$dependency){
            if(!isset($dependency["classId"]) && !isset($dependency["value"]) ){
                  throw new ClassIdOrValueNotFoundException(get_class($class));
            }

            if(isset($dependency["classId"]) && isset($dependency["value"]) ){
                  throw new OnlyOneOfClassIdOrValueMustBeExist(get_class($class));
            }
      }

      private function setClassDependencyForClass($class,$dependency){
            $classMethods = get_class_methods($class);
            $classSetterMethodName = "set". strtolower($dependency["attributeName"]);
            $isClassMethodFound = false;

            // search setter method for dependencys
            foreach($classMethods as $classMethod){
                  if(strtolower($classMethod) == $classSetterMethodName){
                        $dependedClass = $this->classInformation[$dependency["classId"]]->getClass();
                        $class->$classMethod($dependedClass);
                        $isClassMethodFound = true;
                        continue ;
                  }
            }
            if(!$isClassMethodFound){
                  throw new IoCSetterMethodNotFoundException($dependency["attributeName"]);
            } 
      }

      private function setValueDependencyForClass($class,$dependency){
            $classMethods = get_class_methods($class);

            $classSetterMethodName = "set". strtolower($dependency["attributeName"]);
            $isClassMethodFound = false;

            // search setter method for dependencys
            foreach($classMethods as $classMethod){
                  if(strtolower($classMethod) == $classSetterMethodName){
                        $class->{$classMethod}($dependency["value"]);
                        $isClassMethodFound = true;
                        continue ;
                  }
            }
            if(!$isClassMethodFound){
                  throw new IoCSetterMethodNotFoundException($dependency["attributeName"]);
            } 
      }

      private function validateClass($classAddres){
            if (!class_exists($classAddres)) {
                  throw new IoCClassNotFoundException($classAddres);
            }

            $reflectionClass = new ReflectionClass($classAddres);
            if( $reflectionClass->getConstructor() != null ){
                  $consturctorParametersCount = count($reflectionClass->getConstructor()->getParameters());
                  if($consturctorParametersCount != 0 ){
                        throw new IoCConstructorParametersException($classAddres);
                  }
            }

            
           
      }

      private function addClassInformation($classId,$classInformationClass){
            $this->classInformation[$classId] = $classInformationClass;
      }
}