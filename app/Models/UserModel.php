<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function __construct(){
        $this->users = [];
    }

    public function saveUser($data)
    {
        $user = new \App\Libraries\UserDTO($data);

        // Verifica duplicidade
        foreach ($this->users as $existingUser) {
            if (strcmp($existingUser->get("id"), $user->get("id")) === 0) {
                return [
                    "error"   => true,
                    "message" => "Esse usuário já está cadastrado.",
                    "user_count" => count($this->users),
                    "id"      => $data['id']
                ];
            }
        }

        // Se passou pela verificação, adiciona o novo usuário
        $this->users[] = $user;

        return [
            "error"  => false,
            "message" => "Arquivo recebido com sucesso",
            "user_count" => count($this->users),
        ];
    }

    public function getSuperUser(){
        
        $data = [];
        
        
        foreach ($this->users as $user){
            if(($user->get('score')  >= 900) && $user->get('ativo')){
                $data[] = $user;
            }
        } 
        $response['status'] = 200;
        $response['body']['data'] = $data;

        return $response;
    }

}

