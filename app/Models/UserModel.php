<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function __construct(){
        $this->users = [];
        $this->file = DATABASE_PATH . '/usuarios.json'; 
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
        
        $users = $this->loadUsers();
        $data = array();
        
        foreach ($users as $user){
            if(($user['score'] >= 900) && boolval($user['active'])){
                $data[] = $user;
            }
        } 

        $response['status'] = 200;
        $response['body']['user_count'] = count($data);
        $response['body']['data'] = $data;

        return $response;
    }

    public function getTopCountries(){
        $users = $this->loadUsers();
        $count = 0;
        $data = array();
        foreach ($users as $user){
            if(($user['score'] >= 900) && boolval($user['active'])){
                $count++;
                if(!isset($data[$user['country']])){
                    $data[$user['country']] = [
                        'country' => $user['country'],
                        'total'   => 1
                    ];
                }else{
                    $data[$user['country']]['total']++;
                }
            }  
        }

        $dataNumerico = array_values($data);
        
        usort($dataNumerico, function($a, $b) { return $b['total'] <=> $a['total'];});

        $top5 = array_slice($dataNumerico, 0, 5);

        $response['status'] = 200;
        $response['body']['user_count'] = $count;
        $response['body']['data'] = $top5;

        return $response;
    }


    public function getTeamInsights(){
        $users = $this->loadUsers();
        
    }

    private function loadUsers(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $content = file_get_contents($this->file);
        return json_decode($content, true) ?? [];
    }
}

