<?php
declare(strict_types=1);

namespace RealYXNG\DeathHead;

/*  
 *  
 *  _____            ___     ____   ___   _  _____ 
 *  |  __ \          | \ \   / /\ \ / / \ | |/ ____|
 *  | |__) |___  __ _| |\ \_/ /  \ V /|  \| | |  __ 
 *  |  _  // _ \/ _` | | \   /    > < | . ` | | |_ |
 *  | | \ \  __/ (_| | |  | |    / . \| |\  | |__| |
 *  |_|  \_\___|\__,_|_|  |_|   /_/ \_\_| \_|\_____|
 *    
 *     
 */







use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\item\ItemIds;
use pocketmine\item\ItemFactory;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\utils\Config;











class Main extends PluginBase implements Listener


{




    



    





    protected function onEnable(): void


    {


        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        
        if (!($config->exists("head"))){

            $config->set("head", (int)0);
            $config->save();

        }

        if (!($config->exists("type"))){

            $config->set("type", "steve");
            $config->save();

        }

        if (!($config->exists("number"))){

            $config->set("number", "true");
            $config->save();

        }

        if (!($config->exists("enabled"))){

            $config->set("enabled", "true");
            $config->save();

        }


    }

public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool 
 {

    $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);


    switch ($command->getName()) {



            case "dh":

                if (isset($args[0])){

                    


                    switch ($args[0]) {

                        

                        // HEAD TYPE CONFIG
                        case "type":
                            if (isset($args[1])){

                                


                                if ($args[1] == "steve" or $args[1] == "skull"){

                                    if($args[1] == "steve"){
                                        $config->set("type", "steve");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully set Head Type to \n" . TextFormat::LIGHT_PURPLE . "Steve");
                                    }else{
                                        $config->set("type", "skull");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully set Head Type to \n" . TextFormat::LIGHT_PURPLE . "Skull");
                                    }



                                }else{
                                    $sender->sendMessage(TextFormat::RED."Head Type Config can only be steve/skull \n Example: /dh type skull");
                                }
                            }

                            break;

                        // NUMBER ON/OFF CONFIG
                        case "number":

                            if (isset($args[1])){

                                


                                if ($args[1] == "true" or $args[1] == "false"){

                                    if($args[1] == "true"){
                                        $config->set("number", "true");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully set Head Lore Number to \n" . TextFormat::LIGHT_PURPLE . "True");
                                    }else{
                                        $config->set("number", "false");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully set Head Lore Number to \n" . TextFormat::LIGHT_PURPLE . "False");
                                    }



                                }else{
                                    $sender->sendMessage(TextFormat::RED."Number Config can only be set to true/false \n Example: /dh number true");
                                }
                            }

                            break;
                        
                        case "enabled":

                            if (isset($args[1])){

                                


                                if ($args[1] == "true" or $args[1] == "false"){

                                    if($args[1] == "true"){
                                        $config->set("enabled", "true");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully Enabled the head dropping. \n Enabled: " . TextFormat::LIGHT_PURPLE . "true");
                                    }else{
                                        $config->set("enabled", "false");
                                        $config->save();
                                        $sender->sendMessage(TextFormat::GREEN.TextFormat::BOLD."Successfully Disabled the head dropping. \n Enabled: " . TextFormat::LIGHT_PURPLE . "false");
                                    }



                                }else{
                                    $sender->sendMessage(TextFormat::RED."Enabled config can only be set to true/false \n Example: /dh enabled true");
                                }
                            }

                            break;
                        
                        case "help":
                             $sender->sendMessage(TextFormat::LIGHT_PURPLE."DeathHead Commands List: \n /dh enabled true/false -> Enables/Disables the head dropping on death. \n /dh number true/false -> Enables/Disables head number in the lore \n /dh type steve/skull -> Sets the Head type \n /dh help -> Shows the list of commands for DeathHead");
                            break;
                        
                            case "config":

                                $dhenabled = $config->get("enabled");
                                $dhnumber = $config->get("number");
                                $dhtype = $config->get("type");

                                $sender->sendMessage("===== \n" . TextFormat::GREEN . "Enabled: \n" . TextFormat::BOLD . TextFormat::LIGHT_PURPLE . $dhenabled . TextFormat::RESET . TextFormat::GREEN . "\n" . "Number: \n" . TextFormat::BOLD . TextFormat::LIGHT_PURPLE . $dhnumber . TextFormat::RESET . TextFormat::GREEN . "\n" . "Type: \n" . TextFormat::BOLD . TextFormat::LIGHT_PURPLE . $dhtype . TextFormat::RESET . "\n" . "=====");
                                
                                
                                break;




                    }
                
            }else{
                $sender->sendMessage(TextFormat::RED."Invalid DH Command, Run /dh help to see the list of commands");
            }

                break;

      

        

    }


 return true;

    }


   
    public function onDeath(PlayerDeathEvent $event)
    {

        $config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $player = $event->getPlayer();
        $pname = $player->getName();

        // CHECKERS FOR CONFIG


        if ($config->exists("enabled")){

            $dhenabled = $config->get("enabled");
            if($dhenabled == "false"){
                return;
            }

        }

        if ($config->exists("head")){

            $headno = (int)$config->get("head") + 1;
            $config->set("head", (int)$headno);
            $config->save();

        }else{
            $this->getLogger()->info("[DeathHead] TYPE does not exist in config or corrupted. (Set it to 0)");
            return;
        }

        if($config->exists("type")){

            $type = $config->get("type");
            //TYPE IS STEVE
            if($type == "steve"){

                $skull = VanillaItems::PLAYER_HEAD();

            }else{

                //TYPE IS SKULL
                if($type == "skull"){

                    $skull = VanillaItems::SKELETON_SKULL();


                //TYPE IS SOMETHING ELSE OTHER THAN SKULL/STEVE RETURN AND LOG ERROR
                }else{

                    $this->getLogger()->info("[DeathHead] TYPE is set to something else other than skull/steve. (Set it to steve)");
                    return;
            

                }

            }

        }else{
            $this->getLogger()->info("[DeathHead] TYPE does not exist in config or corrupted. (Set it to steve)");
            return;
        }

        if($config->exists("number")){

            $lorenumber = $config->get("number");
            //NUMBER IN LORE IS SET TO TRUE
            if($lorenumber == "true"){

                $headlore = array(TextFormat::YELLOW . "Head #".$headno, TextFormat::LIGHT_PURPLE."R.I.P " . $pname);

            }else{

                //NUMBER IN LORE IS SET TO FALSE
                if($lorenumber == "false"){

                    $headlore = array(TextFormat::LIGHT_PURPLE."R.I.P " . $pname);


                //NUMBER IN LORE IS TO SOMETHING ELSE
                }else{

                    $this->getLogger()->info("[DeathHead] NUMBER is set to something else other than true/false. (Set it to true)");
                    return;
            

                }

            }

        }else{
            $this->getLogger()->info("[DeathHead] NUMBER does not exist in config or corrupted. (Set it to true)");
            return;
        }


        
        $skull->setCustomName("§l§o§e".$pname."'s Head");
        $skull->setLore($headlore);
        $loot = $event->getDrops();
        array_push($loot, $skull);
        $event->setDrops($loot);
    }

    
    

    

 
    }


   
