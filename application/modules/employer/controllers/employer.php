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

//        $resume_online = Modules::run('api/api_resume/resume_online_member',$this->member_id);
//        $resume_online = json_decode($resume_online,true);

        $company = Modules::run('api/api_member/get_company', 'test');

        $company = json_decode($company);

//        $company = array(1,2,3,4,5);

        print_r($company);

//        echo $company;
    }
}