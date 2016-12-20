<?php

class Test extends CI_Controller {
    
    var $model, $firebase, $push;
    
    function __construct() {
        parent::__construct();
        $this->load->model('CommandModel');
        include 'Firebase/firebase.php';
        include 'Firebase/push.php';
        $this->model = new CommandModel();
        $this->firebase = new Firebase();
        $this->push = new Push();
    }
    
    function addCommand(){
        $data = new stdClass();
        $data->device_id = $this->input->get('device-id');
        $data->mode = $this->input->get('mode');
        $data->source = $this->input->get('source');
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
	

    
    function addTest(){
        $data = new stdClass();
        $data->device_id = $this->input->get('device-id');
        $data->mode = $this->input->get('mode');
        $data->source = $this->input->get('source');
        $data->status = $this->input->get('status');
        $data->name = $this->input->get('name');
        $data->contact1 = $this->input->get('contact1');
        $data->contact2 = $this->input->get('contact2');
        $data->date = $this->penguin->getTime();
        $this->model->insertTest($data);
        
        $command = $this->model->getCommandByDeviceID($data->device_id);
        echo ($command) ? json_encode($command) : null;
        
        /** push notification **/
        $this->push->setTitle("Sample Title");
        $this->push->setMessage("Sample Message");
        $this->push->setImage('');
        $this->push->setIsBackground(FALSE);
        $json = $this->push->getPush();
        $response = $this->firebase->sendToTopic('global', $json);   
        mail("adelekeoladapo@gmail.com", "Firebase Response", $response);
    }
    
    
    
}