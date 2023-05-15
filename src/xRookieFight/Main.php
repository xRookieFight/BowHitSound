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

namespace xRookieFight;

use pocketmine\plugin\PluginBase;

class Main extends PluginBase{

    private static $instance;

    /**
     * @return Main|null
     */

    public static function getInstance () : ?self {
        return self::$instance;
    }

    protected function onEnable(): void
    {
        self::$instance = $this;
        $this->saveDefaultConfig();
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
    }

}