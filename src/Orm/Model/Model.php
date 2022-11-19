<?php

class Model{

      private $tableName = "users";
      
      private $primaryKey = ["userName","user_name"];

      private $attributes = [
            "age" => ["age",""],
            "cars" =>     ["userName<->owner","Cars oneToMany"],
            "apartment" => ["userName<->partmentId user_depertmant[user_name,apartment_id]","Apartment manyToMany"],
      ];

      public function convert($result){
            foreach ($this->attributes as $key => $value) {
                  $this->$key = $result[$value[0]];
            }

            $primaryKeyClassAttributeName = $this->primaryKey[0];
            $this->$primaryKeyClassAttributeName = $result[$this->primaryKey[1]];

      }

      public function findRelationsClass(){
            
      }
}