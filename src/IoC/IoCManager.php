<?php

namespace PelFramework\Ioc;

use PelFramework\IoC\Exceptions\ClassIdWasUsedException;
use PelFramework\IoC\Exceptions\CouldNotFindTheClassIdToBeIntegratedIntoTheObject;
use PelFramework\IoC\Exceptions\ObjectDefinitionCanOnlyContainClassIdOrValue;
use PelFramework\IoC\Exceptions\OneOfTheClassIdOrValueMustBeMandatoryInTheObjectDefinition;

class IoCManager{

      private array $classManager = [];

      private static ?IoCManager $ioCManager = null;

      private function __construct(){}

      public static function getIoCManagerObject(){
            if(self::$ioCManager == null)
                  self::$ioCManager = new IoCManager(); 
            return self::$ioCManager;
      }

      /**
       * Does something interesting
       *
       * @param string $objectId objectId for your new object uniq id.
       * @param string $fullClassName namespace + your class name, example: PelFramework\IoC\Exceptions\ClassIdWasUsedException
       * @param mixed $dependencys your object dependencys example: [
       *    ["attributeName" => "age", "value" => "21"],
       *    ["attributeName" => "friend", "classId" => "personSoner"]
       *    ... 
       * ]
       * @author Soner Tugan <github.com/sonerrtgn>
       * @return void
      */ 
      public function create(string $objectId, string $fullClassName ,mixed $dependencys): void{
            $this->newDefinationClassIdValidator($objectId);

            $classAttributesAndValues = [];
            foreach ($dependencys as $dependency) {
                  $this->dependencyValidator($objectId,$dependency);
                  $classAttributesAndValues[] = new classAttributeAndValue($dependency["attributeName"],$this->getDependencyValue($dependency));
            }

            $this->classManager[$objectId] = new ClassManager($fullClassName,$classAttributesAndValues);
      }

      private function newDefinationClassIdValidator(string $objectId){
            if(isset($this->classManager[$objectId]))
                  throw new ClassIdWasUsedException($objectId);
      }

      private function dependencyValidator($objectId,$dependency){
            if(isset($dependency["objectId"]) && isset($dependency["value"]))
                  throw new ObjectDefinitionCanOnlyContainClassIdOrValue($objectId);
            
            if(!isset($dependency["objectId"]) && !isset($dependency["value"]))
                  throw new OneOfTheClassIdOrValueMustBeMandatoryInTheObjectDefinition($objectId);

            if(isset($dependency["objectId"]) && !isset($this->classManager[$dependency["objectId"]]))
                  throw new CouldNotFindTheClassIdToBeIntegratedIntoTheObject($objectId,$dependency["objectId"]);
      }

      private function getDependencyValue($dependency){
            if(isset($dependency["objectId"])){
                  return $this->classManager[$dependency["objectId"]]->getObject();
            }
            return $dependency["value"];
      }
}