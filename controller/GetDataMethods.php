<?php
require_once(dirname(__FILE__) . "/connectDB.php");
class GetDataMethods {
    static function getUserInformation($userID) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT username, firstName, lastName, email, password, role FROM User WHERE id = ?");
        $stmt->bind_param("i", $userID);
        $stmt->bind_result($username, $firstname, $lastname, $email, $password, $role);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        $arr = Array();
        $arr[0] = $username;
        $arr[1] = $password;
        $arr[2] = $firstname;
        $arr[3] = $lastname;
        $arr[4] = $password;
        $arr[5] = $role;
        return $arr;
        
    }
    static function verifyEmailPassword($email, $password) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM User WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->bind_result($count);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        if ($count > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    static function checkBlockedIPAddress($ip) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM blockedips WHERE ip = ?");
        $stmt->bind_param("s", $ip);
        $stmt->bind_result($matched);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        if ($matched > 0) {
            return true;
        }
        return false;
    }
    
    static function getUserId($email) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->bind_result($id);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        return $id;
    }
    static function getDailyMessage() {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT message FROM dailymessage WHERE id = 1");
        $stmt->bind_result($message);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        return $message;
    }
    static function loadTopics($userID) {
        if ($userID == 2) {
            $tableArray = array();
            $db = connectDB::getConnection();
            $stmt = $db->prepare("SELECT * FROM discussion_board_topics");
            $stmt->bind_result($id, $status, $title, $desc, $date, $user_id);
            $stmt->execute();
            while ($stmt->fetch()) {
                $obj = new TopicObject($id, $status, $title, $desc, $date, $user_id);
                $tableArray[] = $obj->toArray();
            }
            $stmt->close();
            $db->close();
            return $tableArray;
        }
        else {
            $tableArray = array();
            $db = connectDB::getConnection();
            $stmt = $db->prepare("SELECT * FROM discussion_board_topics WHERE status = 1 OR status = 0");
            $stmt->bind_result($id, $status, $title, $desc, $date, $user_id);
            $stmt->execute();
            while ($stmt->fetch()) {
                $obj = new TopicObject($id, $status, $title, $desc, $date, $user_id);
                $tableArray[] = $obj->toArray();
            }
            $stmt->close();
            $db->close();
            return $tableArray;
        }
    }
    static function buttonOptionGenerator($buttonID, $status) {
        //delete button is always available to admins
        /*
         * 0 = Closed (Delete, Hide, Re-Open)
         * 1 = Open, Active (Delete, Hide, Close)
         * 2 = Hidden, Closed, Active to Admins (Delete, Un-Hide/Closed, Un-Hide/Open)
         */
        $html = "";
        if ($status === 0) {
            /*
             * echo "<td><button class='btn btn-sm btn-danger' id='delete_".$arr[$i]['id']."'>Delete</button> <button class='btn btn-sm btn-warning' id='hide_".$arr[$i]['id']."'>Hide</button> <button class='btn btn-sm btn-info' id='close_".$arr[$i]['id']."'>Close</button>";
             */
            $html = "<td><button class='btn btn-sm btn-danger' id='delete_".$buttonID."'>Delete</button> <button class='btn btn-sm btn-warning' id='hide_".$buttonID."'>Hide</button> <button class='btn btn-sm btn-info' id='open_".$buttonID."'>Re-Open</button> <button class='btn btn-sm btn-warning' id='truncate_".$buttonID."'>Truncate</button></td>";
        } else if ($status == 1) {
            $html = "<td><button class='btn btn-sm btn-danger' id='delete_".$buttonID."'>Delete</button> <button class='btn btn-sm btn-warning' id='hide_".$buttonID."'>Hide</button> <button class='btn btn-sm btn-info' id='close_".$buttonID."'>Close</button> <button class='btn btn-sm btn-warning' id='truncate_".$buttonID."'>Truncate</button></td>";
        } else {
            $html = "<td><button class='btn btn-sm btn-danger' id='delete_".$buttonID."'>Delete</button> <button class='btn btn-sm btn-warning' id='unhideClose_".$buttonID."'>Un-Hide/Keep Closed</button> <button class='btn btn-sm btn-info' id='unhideOpen_".$buttonID."'>Un-Hide/Re-Open</button> <button class='btn btn-sm btn-warning' id='truncate_".$buttonID."'>Truncate</button></td>";
        }
        return $html;
    }
    static function getTopic($dicussionID) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT * FROM discussion_board_topics WHERE id = ?");
        $stmt->bind_param("i", $dicussionID);
        $stmt->bind_result($id, $status, $title, $desc, $date, $user_id);
        $stmt->execute();
        $stmt->fetch();
        $obj = new TopicObject($id, $status, $title, $desc, $date, $user_id);
        $stmt->close();
        $db->close();
        return $obj;
    }

    static function getRepliesForPost($id, $type) {
        if ($id == -1) {
            return array();
        } else {
            $sql = "";
            if ($type == "reply") {
                $sql = "SELECT * FROM replies WHERE reply_id = ?";
            }
            else {
                $sql = "SELECT * FROM replies WHERE discussion_id = ?";
            }
            $db = connectDB::getConnection();
            $mainReplies = array();
            $stmt = $db->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->bind_result($id, $reply_text, $discussion_id, $text, $user_id, $date_posted, $status, $points);
            $stmt->execute();
            while ($stmt->fetch()) {
                $mainReplies[] = new ReplyObject($id, $reply_text, $discussion_id, null, $user_id, $date_posted, $status, $points, $text);
            }
            $stmt->close();
            $db->close();
            return $mainReplies;
        }
    }
    static function getPointsForReply($id) {
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT points FROM replies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->bind_result($points);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        $db->close();
        return $points;
    }
    static function hasUserVotedForComment($commentID) {
        //return 0 if no action
        //return 1 if upvote
        //return 2 if downvote
        //show both if 0, show upvote if 2, show downvote if 1
        $userID = $_SESSION['USER']->getID();
        $action = array();
        $db = connectDB::getConnection();
        $stmt = $db->prepare("SELECT action FROM user_vote_conjunction WHERE reply_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $commentID, $userID);
        $stmt->bind_result($actionDone);
        $stmt->execute();
        while ($stmt->fetch()) {
            $action[] = $actionDone;
        }
        $stmt->close();
        $db->close();
        return $action;
    }
}
