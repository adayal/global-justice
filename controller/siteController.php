<?php

include_once '../global.php';
$action = $_GET['action'];
$sc = new SiteController();
$sc->route($action);

class SiteController {
    public function route($action) {
        switch($action) {
            case 'index';
                $this->index();
                break;
            case 'login':
                $this->login();
                break;
            case 'signup':
				$this->signup();
            case 'dashboard':
                $this->dashboard();
                break;
            case 'profile':
                $this->myProfile();
                break;
            case 'adminActions':
                $this->adminAction();
                break;
            case 'error':
                $this->error();
                break;
            case 'logout':
                $this->logout();
                break;
            case 'view':
                $this->view();
                break;
            case 'userActions':
                $this->userActions();
                break;
        }
    }
    public function index() {
        include_once SYSTEM_PATH.'/view/index.php';
    }
    public function login() {
        include_once SYSTEM_PATH.'/model/login.php';
    }
    public function dashboard() {
        include_once SYSTEM_PATH.'/view/dashboard.php';
    }
    public function signup() {
		include_once SYSTEM_PATH.'/model/signup.php';
	}
    public function myProfile() {
        include_once SYSTEM_PATH.'/view/myProfile.php';
    }
    public function adminAction() {
        include_once SYSTEM_PATH.'/controller/adminController.php';
    }
    public function logout() {
        session_unset();
        $this->index();
    }
    public function view() {
        include_once SYSTEM_PATH.'/view/discussion.php';
    }
    public function userActions() {
        $_SESSION['USER']->executeAction();
    }
}
