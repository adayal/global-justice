<html lang="en">

    <head>
        <?php
        /**
			currently a dashboard page
         */
            require_once("GetDataMethods.php");
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
        ?>
        <!-- jQuery -->
        <script src="<?php echo PUBLIC_FILES."js/jquery.js" ?>"></script>
        <!--<meta http-equiv="refresh" content="60" /> -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>User Profile</title>

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
                                        echo '<a href="../logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>';
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
                        <li>
                            <a href="<?php echo BASE_URL ?>"><i class="fa fa-fw fa-dashboard"></i>Home</a>
                        </li>
						<li class="active">
                            <a href="<?php echo BASE_URL ?>"><i class="fa fa-fw fa-dashboard"></i>Profile</a>
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
                            <h1 class="page-header" id="daily">
                                Hello, <?php echo $user->getUsername() ?>
								
                            </h1>
							
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 text-center">
				

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <h2>User information </h2>
                            
						</div>
						<div class="col-"
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
                if (action === "delete"){
                    deleteRow(rowID);
                } else if (action === "hide") {
                    hideRow(rowID);
                } else if (action === "close") {
                    closeRow(rowID);
                } else if (action === "unhideClose") {
                    unhideCloseRow(rowID);
                } else if (action === "unhideOpen") {
                    unhideOpenRow(rowID);
                } else if (action === "open") {
                    openRow(rowID);
                } else if (action === "addTopic") {
                    showAddTopic();
                } else if (action === "submit") {
                    submitForm();
                } else if (action === "truncate") {
                    truncateRow(rowID);
                }
                else {
                    window.location = "../view?id="+rowID; //determine on page whether or not user can write
                }
            });
            function deleteRow(id) {
                //SetDataMethods -->admin Action
                //Throw Warning
                $.ajax({
                    type: "POST",
                    url : "../adminActions",
                    data: {action: "deleteRow", rowID: id},
                    success: function() {
                        var deletedRow = document.getElementById("row_" + id);
                        document.getElementById("discussion_table").removeChild(deletedRow);
                    }
                });
            }
            function hideRow(id) { //Hiding a row effectively deletes the row from public domain but admins can still see previous responses
                //SetDataMethods -->admin Action
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "hideRow", rowID: id},
                    success: function(data) {
                        //show flag, successfully hidden
                        document.getElementById("row_" + id).className = "warning";
                        document.getElementById("status_" + id).innerHTML = "Hidden";
                        
                        document.getElementById("hide_"+id).innerHTML = "Un-Hide/Keep Closed";
                        document.getElementById("hide_"+id).setAttribute("id", "unhideClose_"+id);
                        
                        //two cases, either open, or close
                        //!! converts the statement to a boolean
                        //We will see if the open button is there in the DOM, if it is, assign it to the variable selectButton, else assign the 
                        //  close button to 'selectButton'
                        //One-liner awesomeness
                        var selectButton = !!document.getElementById("open_"+id) ? document.getElementById("open_"+id) : document.getElementById("close_"+id);
                        selectButton.innerHTML = "Un-Hide/Re-Open";
                        selectButton.setAttribute("id", "unhideOpen_"+id);
                        //document.getElementById("")
                    }
                });
            }
            function closeRow(id) { //Nobody can comment, only view
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "closeRow", rowID: id},
                    success: function(data) {
                        //show flag, successfully closed
                        document.getElementById("row_" + id).className = "danger";
                        document.getElementById("status_" + id).innerHTML = "Closed";
                        document.getElementById("close_"+id).innerHTML = "Open";
                        document.getElementById("close_"+id).setAttribute("id", "open_" + id);
                    }
                });
            }
            function unhideCloseRow(id) { //delete, hide, re-open
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "closeRow", rowID: id},
                    success: function(data) {
                        //show flag, successfully closed
                        
                        document.getElementById("row_" + id).className = "danger";
                        document.getElementById("status_" + id).innerHTML = "Closed";
                        /*
                         * Current buttons:
                         * delete_id
                         * unHideClose --> Hide
                         * unHideOpen --> Open
                         */
                        document.getElementById("unhideClose_"+id).innerHTML = "Hide";
                        document.getElementById("unhideClose_"+id).setAttribute("id", "hide_"+id);
                        
                        document.getElementById("unhideOpen_"+id).innerHTML = "Re-Open";
                        document.getElementById("unhideOpen_"+id).setAttribute("id", "open_"+id);
                    }
                });
            }
            function unhideOpenRow(id) {
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "openRow", rowID: id},
                    success: function(data) {
                        //show flag, successfully hidden
                        document.getElementById("row_" + id).className = "success";
                        document.getElementById("status_" + id).innerHTML = "Active";
                        /*
                         * Current buttons:
                         * delete_id
                         * unhideClose --> Hide
                         * unHideOpen --> Close
                         */
                        document.getElementById("unhideClose_"+id).innerHTML = "Hide";
                        document.getElementById("unhideClose_"+id).setAttribute("id", "hide_"+id);
                        
                        document.getElementById("unhideOpen_"+id).innerHTML = "Close";
                        document.getElementById("unhideOpen_"+id).setAttribute("id", "close_"+id);
                    }
                });
            }
            
            function openRow(id) {
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "openRow", rowID: id},
                    success: function(data) {
                        //show flag, successfully hidden
                        document.getElementById("row_" + id).className = "success";
                        document.getElementById("status_" + id).innerHTML = "Active";
                        document.getElementById("open_"+id).innerHTML = "Close";
                        document.getElementById("open_"+id).setAttribute("id", "close_" + id);
                    }
                });
            }
            function truncateRow(id) {
                $.ajax({
                    type: "POST",
                    url: "../adminActions",
                    data: {action: "truncateRow", rowID: id},
                    success: function(data){
                        //show alert, successfully truncated
                        console.log("table truncated");
                    }
                });
            }            
        </script>
    </body>

</html>
