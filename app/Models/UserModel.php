<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    public function __construct(){
        ini_set('memory_limit', '1024M'); // ou mais
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
        
        $teams = [];
       // $projectTracker = []; 
        $count = 0;
        $active = [];
        foreach($users as $user){
            $teamName = $user['team']['name'];
            $count++;
            if(!isset($teams[$teamName])){
                $teams[$teamName] = [
                    'team' => $teamName,
                    'total_members' => 0,
                    'leaders' => 0,
                    'completed_projects' => 0,
                ];
                $active[$teamName] = 0;
           //     $projectTracker[$teamName] = [];
            }
            // sempre incrementa
            $teams[$teamName]['total_members']++;
            // confere se é leader
            if($user['team']['leader'])
                $teams[$teamName]['leaders']++;
            // incrementa pessoas ativas
            if($user['active'])
                $active[$teamName]++;

            // confere se projeto é um array
            if(!empty($user['team']['projects']) && is_array($user['team']['projects'])){
                foreach($user['team']['projects'] as $project){
                    if($project['completed']){
                        // $projectName = $project['name'];
                        // conefere se não tem duplicatas, se não tiver, adiciona no array e incrementa o $teams
                        // if(!in_array($projectName, $projectTracker[$teamName], true)){
                            $teams[$teamName]['completed_projects']++;
                        //       $projectTracker[$teamName][] = $projectName;
                        //  }
                    }
                }
            }
            $teams[$teamName]['active_percentage'] = round(100 * ($active[$teamName]/ $teams[$teamName]['total_members']), 1, PHP_ROUND_HALF_DOWN);

        }

        $data = array_values($teams);
        $response['status'] = 200;
        $response['body']['user_count'] = $count;
        $response['body']['data'] = $data;

        return $response;
    }

    public function getUserPerDay(){
        $users = $this->loadUsers();
        $per_day = [];

        foreach($users as $user){
            foreach($user['logs'] as $logs){
                $date = $logs['date'];
                if(!isset($per_day[$date])){
                    $per_day[$date] = [
                        'date' => $date,
                        'total' => (strcmp(strtoupper($logs['action']), 'LOGIN') === 0) ? 1 : 0,
                    ];
                }else{
                    if(strcmp(strtoupper($logs['action']), 'LOGIN') === 0) 
                        $per_day[$date]['total']++;
                }
            }
        }
        
        // ksort — Sort an array by key in ascending order
        ksort($per_day, SORT_STRING); 

        $data = array_values($per_day);
        $response['status'] = 200;
        $response['body']['login'] = $data;

        return $response;
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

