<?php

//      |  __ \           | |  (_)    |  ____(_)     | |   | |
// __  _| |__) |___   ___ | | ___  ___| |__   _  __ _| |__ | |_
// \ \/ /  _  // _ \ / _ \| |/ / |/ _ \  __| | |/ _` | '_ \| __|
//      | | \ \ (_) | (_) |   <| |  __/ |    | | (_| | | | | |_
// /_/\_\_|  \_\___/ \___/|_|\_\_|\___|_|    |_|\__, |_| |_|\__|
//                                               __/ |
//                                              |___/
//
//  Be yourself; everyone else is already taken.
//          github.com/xRookieFight
//

namespace xRookieFight\BowHitSound;

use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    /* @return void */
    protected function onEnable(): void { $this->getServer()->getPluginManager()->registerEvents($this, $this); }

    /**
     * @noinspection PhpUnused
     *
     * @param ProjectileHitEntityEvent $event
     *
     * @return void
     */
    public function onArrowTouch(ProjectileHitEntityEvent $event) : void{
        if ($event->getEntity() instanceof Arrow){
            if ($event->getEntityHit() instanceof Player){
                if ($event->getEntity()->getOwningEntity() instanceof Player){
                    $event->getEntity()->getOwningEntity()->getNetworkSession()->sendDataPacket(PlaySoundPacket::create(
                        soundName: $this->getConfig()->getNested("sound.name") ?? "random.orb",
                        x: $event->getEntity()->getOwningEntity()->getPosition()->getX(),
                        y: $event->getEntity()->getOwningEntity()->getPosition()->getY(),
                        z: $event->getEntity()->getOwningEntity()->getPosition()->getZ(),
                        volume: $this->getConfig()->getNested("sound.volume"),
                        pitch: $this->getConfig()->getNested("sound.pitch")
                    ));
                    switch ($this->getConfig()->getNested("message.type")) {
                        case "popup":
                        default:
                            $event->getEntity()->getOwningEntity()->sendPopup(str_replace(array("{player}", "{health}"), array($event->getEntityHit()->getNameTag(), $event->getEntityHit()->getHealth()), $this->getConfig()->getNested("message.format")));
                            break;
                        case "message":
                            $event->getEntity()->getOwningEntity()->sendMessage(str_replace(array("{player}", "{health}"), array($event->getEntityHit()->getNameTag(), $event->getEntityHit()->getHealth()), $this->getConfig()->getNested("message.format")));
                            break;
                    }
                }
            }
        }
    }

}