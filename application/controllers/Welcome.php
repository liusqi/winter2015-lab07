<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct()
    {
	parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index()
    {
	// Build a list of orders
	$this->load->helper('directory');
        $files = directory_map('./data/');
        $xmlFiles = [];
        
        foreach ($files as $file)
        {
            $ext = pathinfo($file);
            $fileName = $ext['filename'];
            
            if ($ext['extension'] == "xml" && strcasecmp(substr($ext['filename'], 0, 5), "order") == 0)
            {
                $customer = $this->order->getOrderInfo($fileName)['customer'];
                $xmlFiles[] = array('filename' => $fileName, 'order' => $fileName . " ($customer)");
            }
        }
        
        $this->data['orders'] = $xmlFiles;
        
        
	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();
    }
    
    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename)
    {
	// Build a receipt for the chosen order
	$orderInfo = $this->order->getOrderInfo($filename);
        
        $this->data['order'] = ucfirst($orderInfo['order']);
        $this->data['order-type'] = $orderInfo['order-type'];
        $this->data['customer'] = $orderInfo['customer'];
        $this->data['special'] = $orderInfo['special'];
        
        $total = 0.00;
        
        $burgers = $this->order->getOrder($filename);
        
        for ($i = 0; $i < count($burgers); $i++)
        {
            $burgers[$i]['count'] = $i + 1;
            $burgers[$i]['pattyBurger'] = $this->getPatty($burgers[$i]['patty']);
            $burgers[$i]['cheeseList'] = $this->getCheeseList($burgers[$i]['top-cheese'], $burgers[$i]['bottom-cheese']);
            $burgers[$i]['toppingList'] = $this->getToppingList($burgers[$i]['topping']);
            $burgers[$i]['sauceList'] = $this->getSauceList($burgers[$i]['sauce']);
            
            if (empty($burgers[$i]['instructions']))
            {
                $burgers[$i]['instructions'] = "";
            }
            else
            {
                $burgers[$i]['instructions'] = "<br/>Instructions: <i>" . $burgers[$i]['instructions'] . "</i>";
            }
            
            if (empty($burgers[$i]['name']))
            {
                $burgers[$i]['name'] = "";
            }
            else
            {
                $burgers[$i]['name'] = " - \"" . $burgers[$i]['name'] . "\"";
            }
            
            $burgers[$i]['total'] = number_format($this->order->getBurgerTotal($burgers[$i]), 2);
            $total += $burgers[$i]['total'];
        }
        
        $this->data['burgers'] = $burgers;
        $this->data['total'] = number_format($total, 2);
        
	// Present the list to choose from
	$this->data['pagebody'] = 'justone';
	$this->render();
    }
    
    function getPatty($patty)
    {
        $patty = $this->menu->getPattyName($patty);
       return $patty;
    }
    
    function getCheeseList($topCheese, $bottomCheese)
    {
        $cheeseList = "<li>Cheese: ";
        
        $topCheese = $this->menu->getCheeseName($topCheese);
        $bottomCheese = $this->menu->getCheeseName($bottomCheese);
        
        if (!empty($topCheese) && !empty($bottomCheese))
        {
            $cheeseList .= $topCheese . " (top), " . $bottomCheese . " (bottom)</li>";
        }
        else if (!empty($topCheese))
        {
            $cheeseList .= $topCheese . " (top)</li>";
        }
        else if (!empty($bottomCheese))
        {
            $cheeseList .= $bottomCheese . " (bottom)</li>";
        }
        else
        {
            $cheeseList = "";
        }
        
       return $cheeseList;
    }
    
    function getSauceList($sauces)
    {
        $sauceList = "";
        foreach($sauces as $sauce)
        {
            $sauceList .= ", " . $this->menu->getSauceName($sauce);
        }
        
        if (empty($sauceList))
        {
            $sauceList = "None";
        }
        else
        {
            $sauceList = substr($sauceList, 2);
        }
        
       return $sauceList;
    }
    
    function getToppingList($toppings)
    {
        $toppingList = "";
        foreach($toppings as $topping)
        {
            $toppingList .= ", " . $this->menu->getToppingName($topping);
        }
        
        if (empty($toppingList))
        {
            $toppingList = "None";
        }
        else
        {
            $toppingList = substr($toppingList, 2);
        }
        
       return $toppingList;
    }

}
