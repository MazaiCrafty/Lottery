<?php

namespace lottery;

use pocketmine\utils\Config;
use lottery\Main;

class Provider{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
        @mkdir($this->getMain()->getDataFolder());
        //$this->getMain()->saveResource("messages.yml");
        //$this->getMain()->saveResource("config.yml");
        $this->messages = new Config($this->getMain()->getDataFolder() . "messages.yml", Config::YAML, [
            "entry" => [
                "1等" => "10:100",
                "2等" => "20:90",
                "ハズレ" => "70:20"
            ]
        ]);       
        $this->conf = new Config($this->getMain()->getDataFolder() . "config.yml", Config::YAML);
    }

    public function getMessage(string $message){
        return $this->messages->get($message);
    }

    public function getSetting(string $setting){
        return $this->conf->get($setting);
    }

    public function getMain(): Main{
        return $this->main;
    }

}
