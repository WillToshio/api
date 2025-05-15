<?php

namespace App\Controllers;

class User extends BaseController
{

    public function __construct(){
        $this->user = new \App\Models\UserModel();
    }

    public function save(): string
    {
        $inicio = microtime(true);
        $data = $this->request->getJson();
        if(is_array($data)){
            foreach($data as $user){
                $result = $this->user->saveUser((array) $user);
                if($result["error"]){
                    $response["status"] = 402;
                    $response["body"]["message"]    = $result["message"];
                    $response["body"]["user_count"] = $result["user_count"];
                    $response["body"]["id"]         = $result["id"];
                    break;
                }  
            }
            if(!$result["error"]){
                $response["status"] = 200;
                $response["body"]["message"]    = $result["message"];
                $response["body"]["user_count"] = $result["user_count"];
            }
        }else if(is_object($data)){
            $result = $this->user->saveUser((array) $data);
            if($result["error"]){
                $response["status"] = 402;
                $response["body"]["message"] = $result["message"];
                $response["body"]["id"]      = $result["id"];
            }
            $response["status"] = 200;
            $response["body"]["message"]    = $result["message"];
            $response["body"]["user_count"] = $result["user_count"];
        }else {
            $response["status"] = 401;
            $response["body"]["message"] = "Erro ao receber o arquivo. Tipagem não esperado";
        }

        $response["body"]["timestamp"] = date(DATE_ISO8601);
        $fim = microtime(true);
        $response["body"]['execution_time_ms'] = round(($fim - $inicio) * 1000, 2);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function getSuperUser(){
        
        $inicio = microtime(true);
        $response = $this->user->getSuperUser();

        $response["body"]["timestamp"] = date(DATE_ISO8601);
        $fim = microtime(true);
        $response["body"]['execution_time_ms'] = round(($fim - $inicio) * 1000, 2);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
    public function getTopCountries(){
        
        $inicio = microtime(true);
        $response = $this->user->getTopCountries();

        $response["body"]["timestamp"] = date(DATE_ISO8601);
        $fim = microtime(true);
        $response["body"]['execution_time_ms'] = round(($fim - $inicio) * 1000, 2);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }

    public function getTeamInsights(){
        $inicio = microtime(true);
        $response = $this->user->getTeamInsights();

        $response["body"]["timestamp"] = date(DATE_ISO8601);
        $fim = microtime(true);
        $response["body"]['execution_time_ms'] = round(($fim - $inicio) * 1000, 2);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
