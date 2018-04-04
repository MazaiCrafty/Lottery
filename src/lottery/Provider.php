<?php

namespace lottery;

use pocketmine\utils\Config;
use lottery\Main;

class Provider{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
        @mkdir($this->getMain()->getDataFolder());
        $this->getMain()->saveResource("messages.yml");
        //$this->getMain()->saveResource("config.yml");
        $this->messages = new Config($this->getMain()->getDataFolder() . "messages.yml", Config::YAML);
        $this->entry = new Config($this->getMain()->getDataFolder() . "entry.yml", Config::YAML);
        $this->conf = new Config($this->getMain()->getDataFolder() . "config.yml", Config::YAML, [
            "money" => 100,
            "block" => 1,
        ]);
    }

    public function getMessage(string $message){
        return $this->messages->get($message);
    }
    
    public function getEntry(string $entry){
        return $this->entry->get($entry);
    }

    public function getSetting(string $setting){
        return $this->conf->get($setting);
    }

    public function getMain(): Main{
        return $this->main;
    }

}
