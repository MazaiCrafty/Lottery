<?php

namespace lottery;

use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use onebone\economyapi\EconomyAPI;
use lottery\EventListener;
use lottery\Provider;

class Main extends PluginBase{

    private $listener;
    private $provider;
    private $economyAPI;

    public function onEnable(): void{
        self::loadAPI();
        self::loadClass();
    }

    public function loadClass(): void{
        $this->listener = new EventListener($this);
        $this->provider = new Provider($this);
    }

    public function loadAPI(): void{
        $this->economyAPI = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function getListener(): EventListener{
        return $this->listener;
    }

    public function getEconomy(): EconomyAPI{
        return $this->economyAPI;
    }

    public function getProvider(): Provider{
        return $this->provider;
    }

}
