<?php
require_once "api/Repository/AdminRepository.php";
class ServiceLogic{


        public function checkGetMethod($entity,$message){
            if($entity){
            return $entity;
            }
            throw new Exception($message);
        }
        public function checkExistence($param,$repo,$method,$message){
        $entity = $repo->$method($param);
        //this validation is identifier that the request is POST or insert these strings belongs to the function that the insert/POST only contains
        $validation = (stripos($method, "Filter") !== false);
        //if the entity returns result
        if($entity){
            //if the function requires to return true if the entity is not null and throw exception if not
            //example check if id exist, if the entity is not null it will return true and continue for update and delete
            //but if it check username and the entity is not null it will throw exception and terminate the process for insert
            if (!$validation) {return true;}
            throw new Exception($message);
        }else{
            if ($validation) {return true;}
            throw new Exception($message);
        }
    }
}
?>