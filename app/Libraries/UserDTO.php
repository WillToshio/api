<?php

namespace App\Libraries;


class UserDTO 
{
    private string $id;
    private string $name;
    private int $age;
    private int $score;
    private bool $active;
    private string $country;
    private object $team;
    private array $logs;

    public function __construct($data){
        foreach($data as $key => $value){
            $this->set($key, $value);
        }
    }

    public function get($key){
        return $this->$key ?? null;
    }

    public function set(string $key, $value): void
    {
        if (property_exists($this, $key)) {
            $this->$key = $value;
        }
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}

