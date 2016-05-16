<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_global_core extends MY_Model{

    public function __construct(){
        parent::__construct();
    }

    /**
     * Created by Supat(Pat)
     * Date : 2015/05/07
     * Description : Core function to select a records
     * from database MYSQL.
     * function _get
     * @param $config
     * @return mixed
     */
    public function _get($config){

        if(!isset($config['transaction'])){
            $this->db = $this->load->database($config['database'], true);
        }

        if(isset($config['begin_transaction']) AND $config['begin_transaction'] == true){
            $this->begin_transaction();
        }

        if(isset($config['plus_count']) AND $config['plus_count'] == TRUE){
            $this->db->start_cache();
        }

        if(isset($config['select']) AND $config['select'] != ''){
            $this->db->select($config['select']);
        }else{
            $this->db->select('*');
        }

        $this->db->from($config['from']);

        if(isset($config['like'])) {
            $this->db->like($config['like']);
        }

        if(isset($config['like_none'])) {
            foreach($config['like_none'] AS $k => $d){
                $this->db->like($k,$d,'none');
            }
        }

        if(isset($config['like_before'])) {
            foreach($config['like_before'] AS $k => $d){
                $this->db->like($k,$d,'before');
            }
        }

        if(isset($config['or_like'])) {
            $this->db->or_like($config['or_like']);
        }

        if(isset($config['where'])){
            $this->db->where($config['where']);
        }

        if(isset($config['where_static'])){
            $this->db->where($config['where_static']);
        }

        if(isset($config['where_in'])){
            if(is_array($config['where_in'])){
                foreach($config['where_in'] AS $key => $value){
                    $this->db->where_in($key,$value);
                }
            }
        }

        if(isset($config['where_not_in'])){
            if(is_array($config['where_not_in'])){
                foreach($config['where_not_in'] AS $key => $value){
                    $this->db->where_not_in($key,$value);
                }
            }
        }

        if(isset($config['join'])){
            if(is_array($config['join'])){
                foreach($config['join'] AS $key => $value){
                    $this->db->join($key,$value);
                }
            }
        }

        if(isset($config['group'])){
            $this->db->group_by($config['group']);
        }

        if(isset($config['having'])){
            $this->db->having($config['having']);
        }

        if(isset($config['plus_count']) AND $config['plus_count'] == TRUE){
            $this->db->stop_cache();
            $result_return['total'] = $this->db->get()->num_rows();
        }else if(isset($config['count_only'])){
            $result_return['total'] = $this->db->get()->num_rows();
        }

        if(isset($config['order'])){
            if(is_array($config['order'])){
                foreach($config['order'] AS $key => $val){
                    $this->db->order_by($key,$val);
                }
            }else{
                $this->db->order_by($config['order']);
            }
        }

        if(isset($config['limit'])){
            if(isset($config['offset'])){
                $this->db->limit($config['limit'],$config['offset']);
            }else{
                $this->db->limit($config['limit']);
            }
        }

        if(!isset($config['count_only'])){
            $query = $this->db->get();

            if ($query->num_rows() > 0){
                if (!isset($config['count_only']) OR isset($config['count_only']) AND $config['count_only'] == FALSE) {
                    $result_return['result'] = $query->result_array();
                }
            }else{
                $result_return['result'] = false;
            }
        }

        if(isset($config['show_query'])){
            $this->_showquery($config['show_query'],$result_return);
        }

        if(isset($config['plus_count']) AND $config['plus_count'] == TRUE){
            $this->db->flush_cache();
        }

        if((!isset($config['transaction']) AND (isset($config['transaction']) AND $config['transaction']!=true)) OR (!isset($config['begin_transaction']) AND (isset($config['begin_transaction']) AND $config['begin_transaction']!=true))){
            $this->db->close();
        }
        return $result_return;

    }

    /**
     * Created by Supat(Pat)
     * Date : 2015/05/07
     * Description : Core function to update a record
     * from database MYSQL.
     * function _edit
     * @param $config
     * @return mixed
     */
    public function _edit($config){

        if(!isset($config['transaction'])){
            $this->db = $this->load->database($config['database'], true);
        }

        if(isset($config['begin_transaction']) AND $config['begin_transaction'] == true){
            $this->begin_transaction();
        }

        if(isset($config['where_in'])){
            if(is_array($config['where_in'])){
                foreach($config['where_in'] AS $key => $value){
                    $this->db->where_in($key,$value);
                }
            }
        }

        if(isset($config['where_not_in'])){
            if(is_array($config['where_not_in'])){
                foreach($config['where_not_in'] AS $key => $value){
                    $this->db->where_not_in($key,$value);
                }
            }
        }

        $this->db->where($config['where']);

        $result_return['result'] = $this->db->update($config['from'],$config['data']);

        if(isset($config['show_query'])){
            $this->_showquery($config['show_query'],$result_return);
        }

        if((!isset($config['transaction']) AND (isset($config['transaction']) AND $config['transaction']!=true)) OR (!isset($config['begin_transaction']) AND (isset($config['begin_transaction']) AND $config['begin_transaction']!=true))){
            $this->db->close();
        }

        return $result_return;

    }

    /**
     * Created by Supat(Pat)
     * Date : 2015/05/07
     * Description : Core function to delete a record
     * from database MYSQL.
     * function _erase
     * @param $config
     * @return mixed
     */
    public function _erase($config){

        if(!isset($config['transaction'])){
            $this->db = $this->load->database($config['database'], true);
        }
        if(isset($config['begin_transaction']) AND $config['begin_transaction'] == true){
            $this->begin_transaction();
        }

        $result_return['result'] = $this->db->where($config['where'])->delete($config['from']);
        if(isset($config['show_query'])){
            $this->_showquery($config['show_query'],$result_return);
        }
        if((!isset($config['transaction']) AND (isset($config['transaction']) AND $config['transaction']!=true)) OR (!isset($config['begin_transaction']) AND (isset($config['begin_transaction']) AND $config['begin_transaction']!=true))){
            $this->db->close();
        }
        return $result_return;

    }

    /**
     * Created by Supat(Pat)
     * Date : 2015/05/07
     * Description : Core function to insert a record
     * to database MYSQL.
     * function _set
     * @param $config
     * @return mixed
     */
    public function _set($config){

        if(!isset($config['transaction'])){
            $this->db = $this->load->database($config['database'], true);
        }

        if(isset($config['begin_transaction']) AND $config['begin_transaction'] == true){
            $this->begin_transaction();
        }

        if(isset($config['on_duplicate'])){
//            ON DUPLICATE KEY UPDATE ci_view = ci_view + 1
            $sql = $this->db->insert_string($config['from'],$config['data']).' ON DUPLICATE KEY UPDATE '.$config['on_duplicate'];
        }else{
            $sql = $this->db->insert_string($config['from'],$config['data']);
        }

        $result_return['result'] = $this->db->query($sql);

        if(isset($config['need_id']) AND $config['need_id']==TRUE){
            $result_return['id'] = $this->db->insert_id();
        }

        if(isset($config['show_error']) AND $config['show_error']==TRUE){
            $result_return['error'] = $this->db->_error_message();
        }

        if(isset($config['show_query'])){
            $this->_showquery($config['show_query'],$result_return);
        }

        if((!isset($config['transaction']) AND (isset($config['transaction']) AND $config['transaction']!=true)) OR (!isset($config['begin_transaction']) AND (isset($config['begin_transaction']) AND $config['begin_transaction']!=true))){
            $this->db->close();
        }

        return $result_return;

    }

    /**
     * Created by Supat(Pat)
     * Date : 2015/05/07
     * Description : Core function to show sql last query, data,and error message
     * of SQL query statement.
     * function _showquery
     * @param bool $config
     * @param array $data
     */
    public function _showquery($config=FALSE,$data=array()){

        if($config==TRUE){
            echo "<p>".$this->db->last_query()."</br>".print_r($data)."</p>".$this->db->_error_message();
        }

    }

    public function begin_transaction(){
        $this->db->trans_start();
    }

    public function commit_or_rollback(){

        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $this->db->close();
            $result_return = false;
        }else{
            $this->db->trans_commit();
            $this->db->close();
            $result_return = true;
        }
        return $result_return;
    }
}