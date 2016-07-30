<html lang="en">

    <head>
        <?php
        /**
         * Developed by Amit Dayal (adayal@vt.edu)
         * Deleting a topic will destroy it from memory
         * Closing a topic will not allow users to comment on the topic, but they can still see previous replies
         * Hiding a topic hides the topic from public view and closes it. It is only available for comment if user is an admin (archiving topic)
         */
            require_once("GetDataMethods.php");
            require_once("../model/UserObject.php");
            include_once '../global.php';
            if (isset($_SESSION) && isset($_SESSION['IS_LOGIN_VALID']) && $_SESSION['IS_LOGIN_VALID']) {
                $user = $_SESSION['USER'];
            }
            else {
                $user = new UserObject(-1);
            }
            if ($user->getRole() == 2) {
                echo '<script src="'.PUBLIC_FILES.'js/adminFunctions.js"></script>';
            }
            
            $discussionID = $_GET['id']; //ID of discussion to view
            $topic =  GetDataMethods::getTopic($discussionID);
            
            //if dicussion is hidden and user is not admin, redirect. Ideally the user won't be able to view this in
            //  the dicussion board, but users are tricky and might go the url directly. 
            if ($user->getRole() != 2 && $topic->getStatus() === 2) {
                header("Location: dashboard");
            }
            
            function createComment($reply, $user) {
                /**
                 * EVALUATE IF VOTING ELIGIBLE WHEN VOTE BUTTON PRESSED. READ DATABASE CONJUNCTION TABLE TO SEE IF USER HAS ALREADY VOTED
                 * USER CANNOT VOTE FOR THEMSELVES
                 */
                $chain = "";
                $chain .= "<div class='well' id='divWell".$reply->getID()."'>";
                    $chain .= "<div class='row'>";
                    $chain .= "<div class='col-lg-1'>";
                    if ($user->getID() >= 1) {
                        $chain .= "<button id='upvote_".$reply->getID()."' class='btn btn-sm btn-success'>Upvote</button>";
                    }
                    $chain .= "</div>";
                    $chain .= "<div class='col-lg-3'>Posted By: <button class='btn btn-link' id='user_".$reply->getUserID()."'>".GetDataMethods::getUserInformation($reply->getUserID())[0]."</button></div>";
                    $chain .= "</div>";
                    $chain .= "<br />";
                    $chain .= "<div class='row'><div class='col-lg-1 text-center'><div class='panel panel-default'><div class='panel-body'>".$reply->getPoints()."</div></div></div>";
                    $chain .= "<div class='col-lg-11'>".$reply->getText()."</div></div>";
                    
                    $chain .= "<div class='row' id='rowWithDownVote_".$reply->getID()."'><div class='col-lg-1'>";
                    if ($user->getID() >= 1) {
                        $chain .= "<button id='downvote_".$reply->getID()."' class='btn btn-sm btn-danger'>Downvote</button>";
                    }
                    $chain .= "</div><div class='col-lg-1'>";
                    if ($user->getRole() >= 1) {
                        $chain .= "<button id='replyTo_".$reply->getID()."' class='btn btn-sm btn-default'>Reply</button>";
                    }
                    $chain .= "</div></div>";
                    return $chain;
            }
            
            function generateComments($reply, $user, $level = 0) {
                $chain = "";
                if (!$reply->hasChildren()) {
                    $chain .= createComment($reply, $user);
                    for ($i = 0; $i < $level; $i++) {
                        $chain .= "</div>";
                    }
                    return $chain;
                }
                else {
                    $chain .= createComment($reply, $user);
                    $children = $reply->getChildren();
                    for ($i = 0; $i < sizeof($children); $i++) {
                        $chain .= "<br />";
                        $chain .=generateComments($children[$i], new UserObject($children[$i]->getUserID()), $level + 1);
                    }
                    return $chain;
                }
            }
        ?>
        <!-- jQuery -->
        <script src="<?php echo PUBLIC_FILES."js/jquery.js" ?>"></script>
        <script src="<?php echo PUBLIC_FILES."notifIt/js/notifIt.js" ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_FILES."notifIt/css/notifIt.css" ?>">
        <!--<meta http-equiv="refresh" content="60" /> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Discussion Board</title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo PUBLIC_FILES."css/bootstrap.min.css" ?>" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?php echo PUBLIC_FILES."css/sb-admin.css" ?>" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="<?php echo PUBLIC_FILES."css/morris.css" ?>" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="<?php echo PUBLIC_FILES."css/font-awesome/css/font-awesome.min.css" ?>" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo BASE_URL ?>">Global Justice Forum</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                        <ul class="dropdown-menu message-dropdown">
                            
                            
                            <li class="message-preview">
                                <a href="#">
                                    <div class="media">
                                        <span class="pull-left">
                                            
                                        </span>
                                        <div class="media-body">
                                            <h5 class="media-heading"><strong></strong>
                                            </h5>
                                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="message-preview">
                                <a href="#">
                                    <div class="media">
                                        <span class="pull-left">
                                            <img class="media-object" src="http://placehold.it/50x50" alt="">
                                        </span>
                                        <div class="media-body">
                                            <h5 class="media-heading"><strong>John Smith</strong>
                                            </h5>
                                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="message-preview">
                                <a href="#">
                                    <div class="media">
                                        <span class="pull-left">
                                            <img class="media-object" src="http://placehold.it/50x50" alt="">
                                        </span>
                                        <div class="media-body">
                                            <h5 class="media-heading"><strong>John Smith</strong>
                                            </h5>
                                            <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="message-footer">
                                <a href="#">Read All New Messages</a>
                            </li>
                            
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                        <ul class="dropdown-menu alert-dropdown">
                            <li>
                                <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                            </li>
                            <li>
                                <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                            </li>
                            <li>
                                <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                            </li>
                            <li>
                                <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                            </li>
                            <li>
                                <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                            </li>
                            <li>
                                <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">View All</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i><?php echo " " .$user->getName()[0] ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php
                                    if ($user->getID() > 0)
                                        echo '<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>';
                                    else
                                        echo '<a href="#"><i class="fa fa-fw fa-user"></i> Login/Sign Up</a>';
                                ?>
                            </li>
                            <?php
                                if ($user->getID() > 0)
                                {
                                    echo '
                                        <li>
                                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                                        </li>
                                        <li>
                                            <a href="settings.php"><i class="fa fa-fw fa-gear"></i> Settings</a>
                                        </li>
                                        ';
                                }
                            ?>
                            <li class="divider"></li>
                            <li>
                                <?php
                                    if ($user->getID() > 0) {
                                        echo '<a href="logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>';
                                    }
                                    else {
                                        echo '<a href="../"><i class="fa fa-fw fa-power-off"></i> Home</a>';
                                    }
                                ?>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="<?php echo BASE_URL ?>"><i class="fa fa-fw fa-dashboard"></i>Home</a>
                        </li>
                        <li>
                            <a href="dashboard"><i class="fa fa-fw fa-table"></i>Dashboard</a>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>

            <div id="page-wrapper">

                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h2 class="page-header">
                                <?php
                                    echo "<div class='well'>";
                                    echo "<p>";
                                    echo "Topic: ".$topic->getDescription();
                                    echo "</p>";
                                    echo "</div>";
                                ?>
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>Previous Replies: </h2>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    
                                    <tbody id="discussion_table">
                                        <?php
                                            
                                            $replies = GetDataMethods::getRepliesForPost($_GET['id'], "reply");
                                            foreach ($replies as $reply) {
                                                echo generateComments($reply, $user) . "</div>";
                                                
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                            if ($user->getRole() >= 1) {
                                echo '<textarea id="yourReply" class="form-control" placeholder="Your Reply..."></textarea>';
                                echo '<br />';
                                echo '<button id="submitReply_" class="btn btn-lg btn-success">Submit Reply</button>';
                            }
                            else {
                                echo "<div id='notLoggedInMessage' class='alert alert-warning'>You are currently viewing replies, please login to comment or vote on replies</div>";
                            }
                            ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap Core JavaScript -->
        <script src="<?php echo PUBLIC_FILES."js/bootstrap.min.js" ?>"></script>

        <!-- Morris Charts JavaScript -->
        <script src="<?php echo PUBLIC_FILES."js/plugins/morris/raphael.min.js" ?>"></script>
        <script src="<?php echo PUBLIC_FILES."js/plugins/morris/morris.min.js" ?>"></script>
        <script src="<?php echo PUBLIC_FILES."js/plugins/morris//morris-data.js" ?>"></script>
        <script type="text/javascript">
            function logout() {
                window.location = "../logout";
            }
                $(document).on("click", "button", function() {
                    //FORMAT: Action_ID example: delete_14 ==> Delete topic with id = 14
                    var dash = this.id.indexOf('_');
                    var action = this.id.substring(0, dash);
                    var rowID = this.id.substring(dash + 1);
                    if (action === "submitReply"){
                        submitReply(-1);
                    } else if (action === "user") {
                        window.location = "../user/"+rowID;
                    } else if (action === "upvote") {
                        upvote(rowID);
                    } else if (action === "downvote") {
                        downvote(rowID);
                    } else if (action === "replyTo") {
                        replyTo(rowID);
                    } else if (action === "submitReplyFor") {
                        submitReply(rowID);
                    } else if (action === "cancelReplyFor") {
                        cancelReply(rowID);
                    }
                    else {
                        console.log(action);
                    }

                });
            function cancelReply(id) {
                $("#customWell_"+id).remove();
                var replyButton = document.createElement("button");
                replyButton.className = "btn btn-sm btn-default";
                replyButton.setAttribute("id", "replyTo_"+id);
                var div = document.createElement("div");
                div.className = "col-lg-1";
                
                replyButton.innerHTML = "Reply";
                div.appendChild(replyButton);
                $("#rowWithDownVote_"+id).append(div);
                
            }
            function replyTo(id) {
                var replyTextField = document.createElement("textarea");
                replyTextField.setAttribute("id", "replyToText_"+id);
                replyTextField.setAttribute("placeholder", "Your Reply Goes Here");
                replyTextField.className = "form-control";
                var submitButton = document.createElement("button");
                submitButton.innerHTML = "Submit";
                submitButton.setAttribute("id", "submitReplyFor_"+id);
                submitButton.className = "btn btn-sm btn-success";
                var cancelButton = document.createElement("button");
                cancelButton.innerHTML = "Cancel";
                cancelButton.setAttribute("id", "cancelReplyFor_"+id);
                cancelButton.className = "btn btn-sm btn-danger";
                
                var div = $("<div></div>");
                div.attr({"id": "customWell_"+id});
                div.append("<br />");
                div.append(replyTextField);
                div.append("<br />");
                div.append(submitButton);
                div.append(" ");
                div.append(cancelButton);
                var elementBefore = null;
                var defaultWell = $("#divWell"+id);
                
                for (var i = 0; i < defaultWell.children().length; i++) {
                    if (defaultWell.children()[i].id.includes("divWell")) {
                        elementBefore = defaultWell.children()[i];
                        break;
                    }
                }
                if (elementBefore) {
                    $("#rowWithDownVote_"+id).after(div);
                }
                else {
                    $(defaultWell).append(div);
                }
                $("#replyTo_"+id).parent().remove();
                
            }
            function submitReply(id) {
                var replyText;
                var discussionID = "";
                var replyID = id >= 0 ? id : "";
                if (replyID !== "") {
                    replyText = document.getElementById("replyToText_"+id).value;
                } else {
                    replyText = document.getElementById("yourReply").value;
                    discussionID = <?php echo $_GET['id'] ?>;
                }
                $.ajax({
                    type: "POST",
                    url: "userActions",
                    data: {action: "reply", discussion_id: discussionID, reply_id: replyID, reply_text: replyText},
                    success: function(data) {
                        //data contains sql row id for the newly inserted comment
                        if (data) {
                            console.log("comment posted");
                            
                            // Only in response to other comments (daisy-chained comments)
                            // else will take care of non-dasiy chained comments (level 0 comments)
                            cancelReply(id); //function does the same thing regardless of the name

                            /*
                             * Create comment well and append it to page
                             * DOM insanity below
                             */
                            var divWell = document.createElement("div");
                            divWell.className = "well";
                            divWell.setAttribute("id", "divWell"+data);
                            var divRow = document.createElement("div");
                            divRow.className = "row";
                            var divUpvote = document.createElement("div");
                            divUpvote.className = "col-lg-1";
                            var upvoteButton = document.createElement("button");
                            upvoteButton.className = "btn btn-sm btn-success";
                            upvoteButton.setAttribute("id","upvote_"+data);
                            upvoteButton.innerHTML = "Upvote";
                            var breakLineUpvote = document.createElement("br");
                            upvoteButton.appendChild(breakLineUpvote);
                            divWell.appendChild(divRow.appendChild(divUpvote.appendChild(upvoteButton)));

                            var divUser = document.createElement("div");
                            divUser.className = "col-lg-3";
                            var textNode = document.createTextNode("Posted By: ");
                            var username = document.createElement("button");
                            username.className = "btn btn-link";
                            username.setAttribute("id", "user_"+data);
                            divRow.appendChild(divUser.appendChild(textNode));
                            divUser.appendChild(username);

                            var divPtsRow = document.createElement("div");
                            divPtsRow.className = "row";
                            var colPanel = document.createElement("div");
                            colPanel.className = "col-lg-1 text-center";
                            var divPanel = document.createElement("div");
                            divPanel.className = "panel panel-default";
                            var divPanelBody = document.createElement("div");
                            divPanelBody.className = "panel-body";
                            divPanelBody.innerHTML = 0;
                            var divMessage = document.createElement("div");
                            divMessage.className = "col-lg-11";
                            divMessage.innerHTML = replyText;
                            divPanel.appendChild(divPanelBody);
                            colPanel.appendChild(divPanel);
                            divPtsRow.appendChild(colPanel);
                            divPtsRow.appendChild(divMessage);
                            divWell.appendChild(divPtsRow);

                            var divDownVoteRow = document.createElement("div");
                            divDownVoteRow.className = "row";
                            divDownVoteRow.setAttribute("id", "rowWithDownVote_"+data);
                            var divDownVoteCol = document.createElement("div");
                            divDownVoteCol.className = "col-lg-1";
                            var downVoteButton = document.createElement("button");
                            downVoteButton.className = "btn btn-sm btn-danger";
                            downVoteButton.setAttribute("id", "downvote_"+data);
                            downVoteButton.innerHTML = "Downvote";
                            //check if user is able to 'reply'
                            var divReplyCol = document.createElement("div");
                            divReplyCol.className = "col-lg-1";
                            var replyToButton = document.createElement("button");
                            replyToButton.className = "btn btn-sm btn-default";
                            replyToButton.setAttribute("id", "replyTo_"+data);
                            replyToButton.innerHTML = "Reply";
                            divDownVoteRow.appendChild(divDownVoteCol.appendChild(downVoteButton));
                            divDownVoteRow.appendChild(divReplyCol.appendChild(replyToButton));
                            divWell.appendChild(divDownVoteRow);

                            //append to parent's div well
                            var breakline = document.createElement("br");
                            if (id >= 0) {
                                document.getElementById("divWell"+id).appendChild(breakline);
                                document.getElementById("divWell"+id).appendChild(divWell);
                            } else {
                                document.getElementById("discussion_table").appendChild(divWell);
                                document.getElementById("yourReply").value = "";
                            }
                            notif({
                                msg: "Reply Posted",
                                type: "success",
                                position: "center",
                                timeout: 2000
                            });
                        }
                    }
                });
            }
            function downvote(id) {
                $.ajax({
                    type: "POST",
                    url: "userActions",
                    data: {action: "downvote", comment_id: id},
                    success: function(err, data) {
                        if (err) {
                            console.log(err);
                        } else {
                            console.log(data);
                        }
                    }
                });
            }
            function upvote(id) {
                $.ajax({
                    type: "POST",
                    url: "userActions",
                    data: {action: "upvote", comment_id: id},
                    success: function(err, data) {
                        if (err) {
                            console.log(err);
                        } else {
                            console.log(data);
                        }
                    }
                });
            }
            //ERRORS WITH UPVOTE AND DOWNVOTE:
            /*
            * 1) USER IS NOT LOGGED IN (ERROR - DO NOT SHOW ERROR)
            * 2) USER IS VOTING ON OWN COMMENT (ERROR - "YOU CANNOT VOTE YOURSELF")
            * 3) USER IS VOTING 2x on either DOWNVOTE OR UPVOTE -> Switch case
            * 4) ERROR WITH DATABASE RECORDING DATA (ERROR - WRITE TO LOG, "UNABLE TO VOTE, TRY AGAIN LATER")
             */
        </script>
    </body>

</html>
