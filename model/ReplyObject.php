<?php
class ReplyObject {
    
    private $id;
    private $text;
    private $referenceID;
    private $mainReferenceID;
    private $userID;
    private $timestamp;
    private $status;
    private $points;
    private $children;
    
    public function __construct($id, $reply_text, $mainReferenceID, $replyReferenceID, $user_id, $date_posted, $status, $points, $text) {
        $this->id = $id;
        $this->text = $reply_text;
        $this->mainReferenceID = $mainReferenceID;
        $this->referenceID = $replyReferenceID;
        $this->userID = $user_id;
        $this->timestamp = $date_posted;
        $this->status = $status;
        $this->points = $points;
        $this->text = $text;
        $this->constructReplyChain(); //the real magic starts now
    }
    
    public function getID() {
        return $this->id;
    }
    public function getText() {
        return $this->text;
    }
    public function getReferenceID() {
        return $this->referenceID;
    }
    public function getUserID() {
        return $this->userID;
    }
    public function getDatePosted() {
        return $this->timestamp;
    }
    public function getStatus() {
        return $this->status;
    }
    public function getPoints() {
        return GetDataMethods::getPointsForReply($this->id);
    }
    /**
     * $children points to the reply objects that are in response to the current object
     */
    private function constructReplyChain() {
        $array = GetDataMethods::getRepliesForPost($this->id, "");
        if (sizeof($array) == 0) {
            $this->children = null;
        } else {
            $this->children = $array;
        }
        //if there are no children, children points to null
    }
    public function getChildren() {
        return $this->children;
    }
    public function reconstructReplies() {
        $this->constructReplyChain();
    }
    
    public function hasChildren() {
        return $this->children != null;
    }
    /**
     * Delete all children
     * set $this->children = null
     */
    private function truncateChildren() {
        if ($this->children) {
            foreach ($this->children as $child) {
                $child->deleteSelf();
            }
            $this->reconstructReplies();
        }
    }
    /**
     * Goodbye world
     * Destroy self --> destroy with self ID from database
     */
    public function deleteSelf() {
        $this->truncateChildren();
        SetDataMethods::deleteReply($this->id);
    }
    
}
?>