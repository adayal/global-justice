<?php
class TopicObject { //extend super object so that we can execute common methods
    private $id;
    private $status;
    private $title;
    private $description;
    private $replies; //array
    private $date;
    private $userID;
    
    public function __construct($id, $status, $title, $description, $date, $userID) {
        $this->id = $id;
        $this->status = $status;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->userID = $userID;
    }
    public function getID() {
        return $this->id;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getTitle() {
        return $this->title;
    }
    public function getDescription() {
        return $this->description;
    }
    public function getCreatedTimestamp() {
        return $this->date;
    }
    public function getUserId() {
        return $this->userID;
    }
    public function getReplies() {
        if ($this->replies != null)
            return $this->replies;
        else {
            $this->replies = GetDataMethods::getRepliesForPost($this->id, "reply");
            return $this->replies;
        }
    }
    public function toArray() {
        $arr = array();
        $arr["id"] = $this->id;
        $arr["status"] = $this->status;
        $arr["title"] = $this->title;
        $arr["description"] = $this->description;
        $arr["date"] = $this->date;
        $arr["userID"] = $this->userID;
        return $arr;
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

