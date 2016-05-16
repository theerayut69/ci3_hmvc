<?php
/**
 * Created by PhpStorm.
 * User: BATMAN
 * Date: 15/8/2558
 * Time: 10:06
 */
class Employer extends MX_Controller{

    public function index(){

        echo "Employer IS OK.";
        echo "<br/>";

        echo base_url();
        echo "<br/>";

        echo $_SERVER['SERVER_NAME'];

        $test = Modules::run('hmvc/test_hmvc', 'test');


        echo "<br/>" . $test;
    }
}