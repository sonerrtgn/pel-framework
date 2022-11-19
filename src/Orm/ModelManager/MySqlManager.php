<?php

class MySqlManager{

      private $model;

      private $diffAttributes = [];

      private $whereCommands = [];

      public function init(){
            $attributes = $this->model->getAttributes();
            $sql = "SELECT ";

            foreach ($this->diffAttributes as $diffAttribute) {
                  $attributes[$diffAttribute] = false;
            }

            foreach ($attributes as $key => $attribute) {
                  if($attribute != false && $attribute[1] == 0){
                        $sql .= $attribute[0]." as ".$key." ";
                  }
            }
            $sql .= " FROM "+$this->model->getTableName();
      }

      public function initWhereCommands(){
            $attributes = $this->model->getAttributes();
            $sqlWhereCommands = [
                  "commands" => [],
                  "values"   => []
            ];


            foreach($this->whereCommands as $whereCommand){
                  if(strpos($whereCommand[0],"bigger than") !== false){
                        $columnName = $attributes[explode($whereCommand[0]," ")[0]];
                        $sqlWhereCommands["commands"][] = $columnName ." > ?";
                        $sqlWhereCommands["values"][] = $whereCommand[1];
                        continue; 
                  }
            }
      }

      public function setModel($model){
            $this->model = $model;

            return $this;
      }

      public function subtractAttribute(string $attributeName){
            $this->diffAttributes[] = $attributeName;
            
            return $this;
      }

      public function addWhereCommands(string $whereCommands,$whereAttribute){
            $this->whereCommands[] = [$whereCommands,$whereAttribute];
            
            return $this;
      }


}