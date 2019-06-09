<?php

/*
*  _   _____             _        ______
* (_)/ ____|           | |      |___  /
*  _| (___  _ __   ___ | | _____   / /
* | |\___ \| '_ \ / _ \| |/ / _ \ / /
* | |____) | |_) | (_) |   <  __// /__
* |_|_____/| .__/ \___/|_|\_\___/_____|
*          | |
*          |_|
*
*@author iSpokeZ (Umut Yıldırım)
*
*@RainzGG Tüm Hakları Saklıdır!
*
*@Eklenti Umut Yıldırım Tarafından Özel Olarak Kodlanmıştır. Dağıtılması Kesinlikle Yasaktır!
*
*@YouTube - iSpokeZ
*
*/

namespace iSpokeZ;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\BubbleParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\HeartParticle;
use pocketmine\math\Vector3;
use pocketmine\Server;

class Panel extends PluginBase {

    public function onEnable(){
        $this->getLogger()->info("§7> §aAktif");
    }

    public function onDisable(){
        $this->getLogger()->info("§7> §cDe-Aktif");
    }

    public function onCommand(CommandSender $sender, Command $kmt, string $label, array $args): bool {
        switch($kmt->getName()){
            case "panel":
                $this->panelForm($sender);
        }
        return true;
    }

    public function panelForm(Player $o){
        $form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createSimpleForm(function (Player $o, array $data){
            $re = $data[0];
            if($re === null){
                return true;
            }
            switch($re){
                case 0:
                    if($o->hasPermission("feed.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new HappyVillagerParticle($o));
                        $o->setFood(20);
                        $o->sendPopup("§aAçlığın Giderildi");
                        break;
                    }
                case 1:
                    if($o->hasPermission("heal.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new HeartParticle($o));
                        $o->setHealth(20);
                        $o->sendPopup("§aCanın Dolduruldu");
                        break;
                    }
                case 2:
                    if($o->hasPermission("flyac.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->setAllowFlight(true);
                        $o->addTitle("§eUçuş Modu\n§aEtkin");
                        break;
                    }
                case 3:
                    if($o->hasPermission("flykapa.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new HappyVillagerParticle($o));
                        $o->setAllowFlight(false);
                        $o->addTitle("§eUçuş Modu\n§cDevre Dışı");
                        break;
                    }
                case 4:
                    if($o->hasPermission("envt.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new FlameParticle($o));
                        $o->getInventory()->clearAll();
                        $o->sendPopup("§aEnvanterin Temizlendi");
                        break;
                    }
                case 5:
                    if($o->hasPermission("repair.kmt")){
                        $o->getLevel()->addSound(new AnvilUseSound($o));
                        $o->getLevel()->addParticle(new BubbleParticle($o));
                        $esya = $o->getInventory()->getItemInHand();
                            $esya->setDamage(0);
                            $o->getInventory()->setItemInHand($esya);
                            $o->sendPopup("§aEşya Onarıldı");
                            break;
                        }
                        case 6:
                            break;
                    }
        });
        $form->setTitle("§3Panel Sistemi");
        $form->setContent("§eAşağıdaki Butonlara Basarak Işlem Yapabilirsin!");
        $form->addButton("§cAçlığını Doldur\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cCanını Doldur\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cUçuş Modunu Aç\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cUçuş Modunu Kapat\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cEnvanterini Temizle\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§cElindeki Eşyayı Onar\n§7Tıkla", 0,"textures/items/paper");
        $form->addButton("§4Ayrıl");
        $form->sendToPlayer($o);
    }
}