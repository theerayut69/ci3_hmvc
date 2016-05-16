<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Api extends MX_Controller {


	public function __construct(){
	   	parent::__construct();

//        $this->load->model('model_global_core','core');
	}

    public function get_company($test = ''){

        $config = array(
            'database' => 'default',
            'from' => 'company',
            'select' => 'id',
            'where' => array(
                'created_at >' => '2016-01-01 00:00:00',
                'is_flags' => '0',
                'is_status' => '1'
            ),
            'count_only' => true
        );

//        $result = $this->core->_get($config);
        return json_encode($config);


    }

    public function test_api($test = ''){
        return "test_api";
    }

}