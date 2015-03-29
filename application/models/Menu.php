<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patties = array();
    protected $cheeses = array();
    protected $toppings = array();
    protected $sauces = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');


        // build a full list of patties - approach 2
        foreach ($this->xml->patties->patty as $patty) {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $this->patties[$record->code] = $record;
        }
        
        foreach ($this->xml->cheeses->cheese as $cheese)
        {
            $record = new stdClass();
            $record->code = (string) $cheese['code'];
            $record->name = (string) $cheese;
            $record->price = (float) $cheese['price'];
            $this->cheeses[$record->code] = $record;
        }
        
        foreach ($this->xml->toppings->topping as $topping)
        {
            $record = new stdClass();
            $record->code = (string) $topping['code'];
            $record->name = (string) $topping;
            $record->price = (float) $topping['price'];
            $this->toppings[$record->code] = $record;
        }
        
        foreach ($this->xml->sauces->sauce as $sauce)
        {
            $record = new stdClass();
            $record->code = (string) $sauce['code'];
            $record->name = (string) $sauce;
            $record->price = (float) $sauce['price'];
            $this->sauces[$record->code] = $record;
        }
    }


    // retrieve a patty record, perhaps for pricing
    function getPatty($code) {
        if (isset($this->patties[$code]))
            return $this->patties[$code];
        else
            return null;
    }
    
    function getPattyName($code){
        if (isset($this->patties[(string) $code]))
            return $this->patties[(string) $code]->name;
        else
            return null;
    }
    
    function getPattyPrice($code)
    {
        if (isset($this->patties[(string) $code]))
            return $this->patties[(string) $code]->price;
        else
            return null;
    }
    
    function getCheese($code){
        if (isset($this->cheeses[$code]))
            return $this->cheeses[$code];
        else
            return null;
    }
    

    function getCheesePrice($code){
        if (isset($this->cheeses[(string) $code]))
            return $this->cheeses[(string) $code]->price;
        else
            return null;
    }
    

    function getCheeseName($code){
        if (isset($this->cheeses[(string) $code]))
            return $this->cheeses[(string) $code]->name;
        else
            return null;
    }

    function getTopping($code){
        if (isset($this->toppings[$code]))
            return $this->toppings[$code];
        else
            return null;
    }
    
    function getToppingPrice($code){
        if (isset($this->toppings[(string) $code]))
            return $this->toppings[(string) $code]->price;
        else
            return null;
    }
    
    function getToppingName($code){
        if (isset($this->toppings[(string) $code]))
            return $this->toppings[(string) $code]->name;
        else
            return null;
    }
    
    function getSauce($code){
        if (isset($this->sauces[$code]))
            return $this->sauces[$code];
        else
            return null;
    }
    
    function getSaucePrice($code){
        if (isset($this->sauces[(string) $code]))
            return $this->sauces[(string) $code]->price;
        else
            return null;
    }
    
    function getSauceName($code){
        if (isset($this->sauces[(string) $code]))
            return $this->sauces[(string) $code]->name;
        else
            return null;
    }

}
