<?php

class Utils
{
    public static function buttonCTA($orderID, $select) : string
    {
        if($select){
        $data = Db::queryOne('SELECT * FROM `contacts` WHERE order_id = ?', array($orderID));
        $cta = Db::queryOne('SELECT * FROM `cta` WHERE order_id = ?', array($orderID));
        if($select == 1)
        {
            $button = '<a href="tel:' . $data['c_phone']. '" class="hero__btn btn btn-primary"><i class="fas fa-phone pe-2"></i>Zavolat</a>';
        }
        elseif($select == 2)
        {
            $button = '<a href="mailto:' . $data['c_email']. '" class="hero__btn btn btn-primary"><i class="fas fa-envelope pe-2"></i>Napsat</a>';
        }
        elseif($select == 3)
        {
            $button = '<a href="#contact-us" class="hero__btn btn btn-primary"><i class="fa-solid fa-map-location pe-2"></i>Navštívit</a>';
        }
        elseif($select == 4)
        {
            $button = '<a href="#contact-us" class="hero__btn btn btn-primary"><i class="fa-solid fa-share-nodes pe-2"></i>Sociální sítě</a>';            
        }
        else
        {
            $button = '<a href="'. $cta['cta_url'] .'" class="hero__btn btn btn-primary"><i class="fa-solid fa-arrow-up-right-dots pe-2"></i>Více informací</a>';
        }

            return $button;
        }
        else
            return $button = '';
    }

    public static function getActualDayOfWeek() {
        // Get the current timestamp
        $timestamp = time();
        
        // Get the day of the week from the timestamp
        $dayOfWeek = date("l", $timestamp);
        
        // Return the day of the week
        return $dayOfWeek;
      }
}
