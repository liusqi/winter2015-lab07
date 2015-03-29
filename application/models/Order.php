<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Order extends CI_Model {
    
    protected $xml = null;
    
    public function __construct(){
        parent::__construct();
    }
    
    function getOrder($file)
    {
        $this->xml = simplexml_load_file(DATAPATH . $file . ".xml");
        
        $order = [];
        $burgers = $this->xml->burger;
        
        foreach($burgers as $burger)
        {
            $burgerDetail = [];
            
            $burgerDetail['patty'] = $burger->patty["type"];
            
            $burgerDetail['top-cheese'] = $burger->cheeses['top'];
            $burgerDetail['bottom-cheese'] = $burger->cheeses['bottom'];
            
            $burgerDetail['topping'] = [];
            
            foreach ($burger->topping as $topping)
            {
                $burgerDetail['topping'][] = $topping['type'];
            }
            
            $burgerDetail['sauce'] = [];
            
            foreach ($burger->sauce as $sauce)
            {
                $burgerDetail['sauce'][] = $sauce['type'];
            }
            
            $burgerDetail['instructions'] = $burger->instructions;
            $burgerDetail['name'] = $burger->name;
            $order[] = $burgerDetail;
        }
        
        return $order;
    }
    
    function getOrderInfo($file)
    {
        $order = [];
        $this->xml = simplexml_load_file(DATAPATH . $file . ".xml");
        
        $order['customer'] = $this->xml->customer;
        $order['order'] = $file;
        $order['order-type'] = $this->xml['type'];
        $order['special'] = $this->xml->special;
        if (empty($order['special']))
        {
            $order['special'] = "None";
        }
        
        return $order;
    }
    
    function getBurgerTotal($burger)
    {
        $total = 0;
        $total += $this->menu->getPattyPrice($burger['patty']);
        
        if (isset($burger['top-cheese']))
        {
            $total += $this->menu->getCheesePrice($burger['top-cheese']);
        }
        if (isset($burger['bottom-cheese']))
        {
            $total += $this->menu->getCheesePrice($burger['bottom-cheese']);
        }
        
        foreach ($burger['topping'] as $topping)
        {
            $total += $this->menu->getToppingPrice($topping);
        }
        
        foreach ($burger['sauce'] as $sauce)
        {
            $total += $this->menu->getSaucePrice($sauce);
        }
        
        return $total;
    }
}