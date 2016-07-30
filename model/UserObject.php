<?php
require_once("GetDataMethods.php");
require_once("SetDataMethods.php");
class UserObject {
    private $userID;
    private $username;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $role; //0 = general user, 1 = logged-in user, 2 = admin
    
    public function __construct($userID) {
        if ($userID > 0) {
            $userData = GetDataMethods::getUserInformation($userID);
            $this->userID = $userID;
            $this->username = $userData[0];
            $this->password = $userData[1];
            $this->firstName = $userData[2];
            $this->lastName = $userData[3];
            $this->email = $userData[4];
            $this->role = $userData[5];
        }
        else {
            $this->userID = -1;
            $this->username = "Guest";
            $this->password = "";
            $this->firstName = "Guest";
            $this->lastName = "";
            $this->email = "";
            $this->role = 0;
        }
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function getName() {
        $arr = array();
        $arr[0] = $this->firstName;
        $arr[1] = $this->lastName;
        return $arr;
    }
    
    public function getEmail() {
        return $this->email;
    }
    
    protected function getPassword() {
        return $this->password;
    }
    public function getID() {
        return $this->userID;
    }
    public function getRole() {
        return $this->role;
    }
    public function toArray() {
        $arr = array();
        $arr["userID"] = $this->userID;
        $arr["fName"] = $this->firstName;
        $arr["lName"] = $this->lastName;
        $arr["email"] = $this->email;
        $arr["role"] = $this->role;
        //DO NOT ADD PASSWORD HERE
        return $arr;
    }
    private function postReply() {
        return SetDataMethods::postReplyForUser($this->userID, $_POST['discussion_id'], $_POST['reply_id'], $_POST['reply_text']);
    }
    private function postReplyForComment() {
        SetDataMethods::postReplyToCommentForUser($this->userID, $_POST['reply_id'], $_POST['text']);
        return true;
    }
        
    private function downvoteComment($id) {
        SetDataMethods::downvoteComment($this->userID, $id);
    }
    private function upvoteComment($id) {
        SetDataMethods::upvoteComment($this->userID, $id);
    }
    public function executeAction() {
        
        if ($_POST['action'] == "reply") {
            if ($this->userID >= 1) {
                echo $this->postReply();
            }   
        } 
        else if ($_POST['action'] == "downvote") {
            $previousActions = GetDataMethods::hasUserVotedForComment($_POST['comment_id']);
            if (in_array(1, $previousActions)) {
                echo "Error Code 2";
            }
            else {
                $this->downvoteComment($_POST['comment_id']);
                echo "success";
            }
        }
        else if ($_POST['action'] == "upvote") {
            $previousActions = GetDataMethods::hasUserVotedForComment($_POST['comment_id']);
            if (in_array(0, $previousActions)) {
                echo "Error Code 1";
            }
            else {
                $this->upvoteComment($_POST['comment_id']);
                
                echo "success";
            }
        }
    }
}
