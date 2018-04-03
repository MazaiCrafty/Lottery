<?php

namespace lottery;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use lottery\Main;

class EventListener implements Listener{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
        $this->getMain()->getServer()->getPluginManager()->registerEvents($this, $main);
    }

    public function onInteract(PlayerInteractEvent $event): void{
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if ($block->getId(); === $this->getMain()->getProvider()->getSetting("block")){
            $set_money = $this->getMain()->getProvider()->getSetting("money");
            if ($set_money <= $this->getMain()->getEconomy()->myMoney($player)){
                // 処理
                $entries = $this->getMain()->getProvider()->getSetting("entry");
                $result_key = array_rand($entries);
                var_dump($result_key);
            }
            else{
                $player->sendMessage($this->getMain()->getProvider()->getMessage("error.no-money"));
                return;
            }
        }
    }

    public function array_rand($entries){
        $sum = array_sum($entries);
        $rand = ranf(1, $sum);

        foreach ($entries as $key => $value){
            if (($sum -= $value) < $rand) return $key;
        }
    }

    public function getMain(): Main{
        return $this->main;
    }

}