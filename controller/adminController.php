<?php
include_once '../global.php';
require_once("SetDataMethods.php");
require_once("GetDataMethods.php");
if (isset($_POST) && $_POST['action'] && isset($_SESSION) && isset($_SESSION['USER']) && $_SESSION['USER']->getRole() == 2) {
    $admin = new AdminController();
    $admin->route($_POST['action']);
}
else {
    echo "error";
}

class AdminController {
    public function route($action) {
        switch($action) {
            case 'setDaily':
                $this->setDaily();
                break;
            case 'addTopic':
                $this->addTopic();
                break;
            case 'loadTopics':
                $this->loadTopics();
                break;
            case 'userData':
                $this->getUserData();
                break;
            case 'deleteRow':
                $this->deleteRow();
                break;
            case 'hideRow':
                $this->hideRow();
                break;
            case 'closeRow':
                $this->closeRow();
                break;
            case 'openRow':
                $this->openRow();
                break;
            case 'getTopic':
                $this->getTopic();
                break;
            case 'truncateRow':
                $this->truncateRow();
                break;
        }
    }
    
    public function setDaily() {
        SetDataMethods::setDailyMessage($_POST['dailyMessage']);
    }
    
    public function addTopic() {
        $id = SetDataMethods::addNewTopic($_POST['title'], $_POST['question'], $_SESSION['USER']->getID());
        if ($id === -1) {
            echo "error";
        } else {
            echo $id;
        }
    }
    public function loadTopics() {
        echo json_encode(GetDataMethods::loadTopics($_SESSION['USER']->getRole()));
    }
    public function getUserData() {
        echo json_encode(GetDataMethods::getUserInformation($_POST['id']));
    }
    public function deleteRow() {
        SetDataMethods::deleteTopic(intVal($_POST['rowID']));
        //must delete all associated comments as well - recursive method
        
    }
    public function hideRow() {
        SetDataMethods::hideTopic(intVal($_POST['rowID']));
    }
    public function closeRow() {
        SetDataMethods::closeTopic(intVal($_POST['rowID']));
    }
    public function openRow() {
        SetDataMethods::openTopic(intVal($_POST['rowID']));
    }
    public function getTopic() {
        $obj = GetDataMethods::getTopic(intVal($_POST['id']));
        echo json_encode($obj->toArray());
    }
    public function truncateRow() {
        SetDataMethods::truncateTable($_POST['rowID']);
    }
}

