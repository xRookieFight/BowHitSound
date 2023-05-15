<?php

namespace xRookieFight;

use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\player\Player;

class EventListener implements Listener{

    public function onArrowTouch(ProjectileHitEntityEvent $event){
        if ($event->getEntity() instanceof Arrow){
            if ($event->getEntityHit() instanceof Player){
                if ($event->getEntity()->getOwningEntity() instanceof Player){
                    $packet = new PlaySoundPacket();
                    $packet->soundName = "random.orb";
                    $packet->x = $event->getEntity()->getOwningEntity()->getPosition()->getX();
                    $packet->y = $event->getEntity()->getOwningEntity()->getPosition()->getY();
                    $packet->z = $event->getEntity()->getOwningEntity()->getPosition()->getZ();
                    $packet->volume = 1;
                    $packet->pitch = 1;
                    $event->getEntity()->getOwningEntity()->getNetworkSession()->sendDataPacket($packet);
                    if (Main::getInstance()->getConfig()->get("popup") === false){
                        $event->getEntity()->getOwningEntity()->sendMessage("§8» §d" . $event->getEntityHit()->getNameTag() . " §7's health: §c" . $event->getEntityHit()->getHealth() . " HP");
                    } elseif (Main::getInstance()->getConfig()->get("popup") === true) {
                        $event->getEntity()->getOwningEntity()->sendTip("§8» §d" . $event->getEntityHit()->getNameTag() . " §7's health: §c" . $event->getEntityHit()->getHealth() . " HP");
                    } else return;
                }
            }
        }
    }
}