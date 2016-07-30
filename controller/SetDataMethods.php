<?php
require_once("connectDB.php");
class SetDataMethods {
    static function createUser($username, $password, $firstName, $lastName, $email) {
        $db = connectDB::getConnection();
        self::stripText($username);
        self::stripText($password);
        self::stripText($firstName);
        self::stripText($lastName);
        self::stripText($email, FILTER_SANITIZE_EMAIL);
        $stmt = $db->prepare("INSERT INTO User VALUES (DEFAULT, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $password, $firstName, $lastName, $email);
        $stmt->execute();
        $stmt->close();
        $db->close();
        return $stmt->insertid;
    }
    
    static function setBlockedIPAddress($ip) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("INSERT INTO blockedips VALUES (DEFAULT, ?)");
        $stmt->bind_param("s", $ip);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function addNewTopic($title, $description, $userID) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("INSERT INTO discussion_board_topics VALUES (DEFAULT, DEFAULT, ?, ?, DEFAULT, ?)");
        self::stripText($title);
        self::stripText($description);
        $stmt->bind_param("ssi", $title, $description, $userID);
        $stmt->execute();
        $id = mysqli_stmt_insert_id($stmt);
        if ($id == null || $id == "") {
            $id = -1;
        }
        $stmt->close();
        $db->close();
        return $id;
    }
    
    static function deleteTopic($id) {
        self::truncateTable($id);
        $db = connectDB::getConnection();
        $stmt = $db->prepare("DELETE FROM discussion_board_topics WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function truncateTable($id) {
        $topic = GetDataMethods::getTopic($id);
        $replies = $topic->getReplies();
        foreach ($replies as $reply) {
            $reply->deleteSelf();
        }
    }
    
    static function hideTopic($id) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE discussion_board_topics SET status = 2 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function closeTopic($id) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE discussion_board_topics SET status = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function openTopic($id) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE discussion_board_topics SET status = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function postReplyForUser($userID, $discussion_id, $reply_id, $text) {
        $sql = "";
        
        if ($discussion_id == "") {
            $sql = "INSERT INTO replies VALUES(DEFAULT, -1, ?, ?, ?, DEFAULT, DEFAULT, 0)";
        } else {
            $sql = "INSERT INTO replies VALUES(DEFAULT, ?, -1, ?, ?, DEFAULT, DEFAULT, 0)";
        }
        $db = connectDB::getConnection();
        $stmt = $db->prepare($sql);
        $bindingValue = $discussion_id == "" ? $reply_id : $discussion_id;
        self::stripText($text);
        $stmt->bind_param("isi", $bindingValue, $text, $userID);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        $db->close();
        return $id;
    }
    
    static function upvoteComment($userID, $commentID) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE replies SET points = points + 1 WHERE id = ?");
        $stmt->bind_param("i", $commentID);
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        self::recordUserAction($userID, $commentID, "upvote");
        self::deletePreviousAction($userID, $commentID, "downvote");
    }
    
    static function downvoteComment($userID, $commentID) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE replies SET points = points - 1 WHERE id = ?");
        $stmt->bind_param("i", $commentID);
        $stmt->execute();
        $stmt->close();
        $db->close();
        
        self::recordUserAction($userID, $commentID, "downvote");
        self::deletePreviousAction($userID, $commentID, "downvote");
    }
    
    static function recordUserAction($userID, $commentID, $action) {
        $actionNum = 0;
        if ($action === "downvote") {
            $actionNum = 1;
        }
        $db = connectDB::getConnection();
        $stmt = $db->prepare("INSERT INTO user_vote_conjunction VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userID, $commentID, $actionNum);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function deletePreviousAction($userID, $commentID, $action) {
        $db = connectDB::getConnection();
        if ($action == "downvote") {
            $deleteAction = 0;
            $stmt = $db->prepare("DELETE FROM user_vote_conjunction WHERE user_id = ? AND action = ?");
            $stmt->bind_param("ii", $userID, $deleteAction);
            $stmt->execute();
            $stmt->close();
            $db->close();
        }
        else {
            $deleteAction = 1;
            $stmt = $db->prepare("DELETE FROM user_vote_conjunction WHERE user_id = ? AND action = ?");
            $stmt->bind_param("ii", $userID, $deleteAction);
            $stmt->execute();
            $stmt->close();
            $db->close();
        }
    }
    
    static function deleteReply($id) {
        var_dump($id);
        $db = connectDB::getConnection();
        $stmt = $db->prepare("DELETE FROM replies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
    
    static function setDailyMessage($message) {
        self::stripText($message);
        $db = connectDB::getConnection();
        $stmt = $db->prepare("UPDATE dailymessage SET message= ? WHERE id= 1");
        $stmt->bind_param("s", $message);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
    }
    
    /**
     * Strip all tags and special chars from strings
     * @param type $text to strip from; set as reference to original var
     * @param type $filter optional to function, default is FILTER_SANITIZE_STRING
     */
    static function stripText(&$text, $filter = FILTER_SANITIZE_STRING) {
        $text = strip_tags($text);
        if ($filter !== FILTER_SANITIZE_STRING) {
            $text = filter_var($text, $filter);
        }
        else {
            $text = filter_var($text, $filter, FILTER_FLAG_STRIP_HIGH);
        }
    }
}

