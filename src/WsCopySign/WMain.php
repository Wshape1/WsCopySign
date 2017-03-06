<?php

namespace WsCopySign;

use pocketmine\plugin\Plugin;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\command;

class WMain extends PluginBase implements Listener{

public $WCopy=[];
public $WInfo=[];

public function onEnable(){
		$this->getLogger()->info("§bWsCopySign复制木牌插件. by Wshape1");
		$this->getServer()->getPluginManager()->registerEvents($this,$this);
		$this->p="§8[§6WsCopySign§8]";
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
	$name=$sender->getName();
	if(!$sender instanceof Player) return $sender->sendMessage($this->p." §c请在游戏内使用");
	if($command->getName() == "wcs"){
	if(!$sender->isOP()) return $sender->sendMessage($this->p."§e聪明的作者不会让普通玩家这样用哦.");
	if(!isset($args[0])){
	 $sender->sendMessage($this->p."§b请点击要复制的木牌,木牌不能为空.");
	$this->WCopy[$name]="all";
	return true;
	}
	}
	}
	public function Touch(PlayerInteractEvent $event) {
		$block=$event->getBlock();
		$b_id=$block->getID();
		$player=$event->getPlayer();
		$name=$player->getName();

        if(in_array($b_id,[323,63,68])){
            $sign=$player->getLevel()->getTile($block);
            if(!$sign instanceof Sign) return;
            $sign=$sign->getText();
            if(empty($this->WCopy[$name])) return;
            /*---Copy---*/
      if($this->WCopy[$name] == "all"){
      $this->WInfo[$name][0]=$sign[0];
      $this->WInfo[$name][1]=$sign[1];
      $this->WInfo[$name][2]=$sign[2];
      $this->WInfo[$name][3]=$sign[3];
      $this->WCopy[$name]="pall";
      $player->sendMessage($this->p."§b请点击要粘贴的木牌,木牌会被覆盖..");
      return true;
      }
	/*---Paste---*/
	if($this->WCopy[$name] == "pall"){
	$wi=$this->WInfo[$name];
	$player->getLevel()->getTile($block)->setText($wi[0],$wi[1],$wi[2],$wi[3]);
	$player->sendMessage($this->p."§7粘贴成功");
	$this->WCopy[$name]=null;
	return true;
	}
	}
	
	
	
	}
	}