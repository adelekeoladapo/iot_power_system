<?php

class Test extends CI_Controller {
    
    var $model, $firebase, $push, $log_model;
    
    function __construct() {
        parent::__construct();
        $this->load->model('CommandModel');
        $this->load->model('LogModel');
        include 'Firebase/firebase.php';
        include 'Firebase/push.php';
        $this->model = new CommandModel();
        $this->log_model = new LogModel();
        $this->firebase = new Firebase();
        $this->push = new Push();
    }
    
    function index(){
        echo "IoT API";
    }
    
    function start(){
        $first_command = $this->model->getCommands('command_id', 'ASC', false, false, false, false)[0];
        echo json_encode($first_command);
        $this->model->setLastDeviceID($first_command->command_id);
    }
    
    function do_next(){
        $critical_device = ($this->model->getCommands('command_id', 'ASC', 'critical', 1, false, false)) ? $this->model->getCommands('command_id', 'ASC', 'critical', 1, false, false)[0] : false;
        if($critical_device){
            echo json_encode($critical_device);
        }else{
            $last_command_id = $this->model->getLastDeviceID();
            $next_command = $this->model->getNextCommand($last_command_id);
            if($next_command){
                $this->model->setLastDeviceID($next_command->command_id);
                echo json_encode($next_command);
            }else{
                $this->start();
            }
        }
    }
    
    function addCommand(){
        $data = new stdClass();
        $data->device_id = $this->input->get('device-id');
        $data->mode = $this->input->get('mode');
        $data->source = $this->input->get('source');
        $data->critical = $this->input->get('critical');
        $data->date = $this->penguin->getTime();
        echo $this->model->insertCommand($data);
    }
    
    function getTests(){
        $sort_field = $this->input->get('sort-field');
        $sort_order_mode = $this->input->get('sort-order-mode');
        $filter_field = $this->input->get('filter-field');
        $filter_value = $this->input->get('filter-value');
        $page = $this->input->get('page');
        $page_size = $this->input->get('page-size');
        echo json_encode($this->model->getTests($sort_field, $sort_order_mode, $filter_field, $filter_value, $page, $page_size));
    }
	
    function getCommands(){
        $sort_field = $this->input->get('sort-field');
        $sort_order_mode = $this->input->get('sort-order-mode');
        $filter_field = $this->input->get('filter-field');
        $filter_value = $this->input->get('filter-value');
        $page = $this->input->get('page');
        $page_size = $this->input->get('page-size');
        echo json_encode($this->model->getCommands($sort_field, $sort_order_mode, $filter_field, $filter_value, $page, $page_size));
    }
	

    
    function updateTest(){
        $data = new stdClass();
        $data->device_id = $this->input->get('device-id');
        $data->mode = $this->input->get('mode');
        $data->source = $this->input->get('source');
        $data->status = $this->input->get('status');
        //$data->name = $this->input->get('name');
        $data->contact1 = $this->input->get('contact1');
        $data->contact2 = $this->input->get('contact2');
        $data->date = $this->penguin->getTime();
        $this->model->updateTest($data->device_id, $data);
        
        $this->model->updateCommand($device_id, array('device_id'=> 0));
        
//        $command = $this->model->getCommandByDeviceID($data->device_id);
//        echo ($command) ? json_encode($command) : null;
        
        $this->do_next();
        
        /** push notification **/
        $this->push->setTitle("Sample Title");
        $this->push->setMessage("Sample Message");
        $this->push->setImage('');
        $this->push->setIsBackground(FALSE);
        $json = $this->push->getPush();
        $response = $this->firebase->sendToTopic('global', $json);   
        //mail("adelekeoladapo@gmail.com", "Firebase Response", $response);
    }
    
    
    /*
     * Device
     */
    function addDevice(){  //Wahala dey. make sure it gets updated if device exist
        $data = new stdClass();
        $data->device_id = $this->input->get('device-id');
        $data->name = $this->input->get('name');
        $data->date = $this->penguin->getTime(); 
        
        $device = $this->model->getTests(false, false, 'device_id', $data->device_id, false, false);
        
        if(!$device)
            echo $this->model->insertTest($data);
        else
            echo $this->model->updateTest ($data->device_id, $data);
    }
    
    function deleteDevice(){
        $device_id = $this->input->get('device-id');
        echo $this->model->deleteTest($device_id);
    }
    
    
    
}