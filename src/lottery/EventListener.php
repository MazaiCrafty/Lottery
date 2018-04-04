<?php

namespace lottery;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use lottery\Main;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\level\sound\PopSound;

class EventListener implements Listener{

    private $main;

    public function __construct(Main $main){
        $this->main = $main;
        $this->getMain()->getServer()->getPluginManager()->registerEvents($this, $main);
    }

    public function onInteract(PlayerInteractEvent $event): void{
        $player = $event->getPlayer();
        $level = $player->getLevel();
        $x = $player->getX();
        $y = $player->getY();
        $z = $player->getZ();
        $pos = new Vector3($x, $y, $z);
        $pop = new PopSound($pos);

        if ($event->getBlock()->getId() == $this->getMain()->getProvider()->getSetting("block")){
            $set_money = $this->getMain()->getProvider()->getSetting("money");
            if ($set_money <= $this->getMain()->getEconomy()->myMoney($player)){
                $player->sendMessage("～待機させる演出～");
                sleep(2);
                $this->getMain()->getEconomy()->reduceMoney($player, $set_money);
                //$entries = $this->getMain()->getProvider()->getSetting("entry");
                // $result_key = $entries[$this->lottery($entries)]["name"];
                $entries = [
                    "1等" => 10, //確率
                    "2等" => 20,
                    "3等" => 30,
                    "ハズレ" => 40,
                ];
                $result_key = $this->array_rand_weighted($entries);
                switch ($result_key){
                    // Entryを増やしたら、caseを増やすこと
                    // 増やさなければdefaultで分岐される
                    case "1等":
                    $level->addSound($pop);
                    $player->sendMessage("一等おめ");
                    $this->getMain()->getEconomy()->addMoney($player, 114514); // (Player, 追加するお金の量)
                    break;

                    case "2等":
                    $level->addSound($pop);
                    $player->sendMessage("二等おめ");
                    break;

                    case "3等":
                    $level->addSound($pop);
                    $player->sendMessage("三等おめ");
                    break;

                    case "ハズレ":
                    $level->addSound($pop);
                    $player->sendMessage("はずれ");
                    break;

                    default:
                    $player->sendMessage("エラー");
                    break;
                }
                //var_dump($result_key); //デバッグ用の関数
            }
            else{
                $player->sendMessage("金がない！");
            }
        }
    }

    function array_rand_weighted($entries){
        $sum  = array_sum($entries);
        $rand = rand(1, $sum);
        foreach($entries as $key => $weight){
            if (($sum -= $weight) < $rand) return $key;
        }
    }

/*
    public function lottery($entries = []){
        $max = 0;
        foreach ((array)$entries as $result) $max += $result["rate"];
        $hit = mt_rand(1, ($max - 1));
        foreach ($entries as $key => $result){
            $max -= $result["rate"];
            if ($max <= $hit) return $key;
        }
    }
*/

    public function getMain(): Main{
        return $this->main;
    }

}