<?php
/**
 * Created by PhpStorm.
 * User: BATMAN
 * Date: 15/8/2558
 * Time: 10:06
 */
class Hmvc extends MX_Controller{

    public function index(){

        echo "HMVC IS OK.";
        echo "<br/>";

        echo base_url();
        echo "<br/>";

        echo $_SERVER['SERVER_NAME'];
    }

    public function test_hmvc($name = '')
    {
    	return "Hmvc module run " . $name;
    }
}