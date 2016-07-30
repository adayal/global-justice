<!DOCTYPE html>
<html lang="en">

    <head>

        <title>Global Justice</title>

        <!-- Bootstrap Core CSS -->
        <link href="public/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="public/css/grayscale.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <script src="<?php echo PUBLIC_FILES."notifIt/js/notifIt.js" ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_FILES."notifIt/css/notifIt.css" ?>">
        
        
        
        
    <!-- jQuery -->
    <script src="public/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="public/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="public/js/jquery.easing.min.js"></script>

    <!-- Google Maps API Key - Use your own API key to enable the map feature. More information on the Google Maps API can be found at https://developers.google.com/maps/ -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRngKslUGJTlibkQ3FkfTxj3Xss1UlZDA&sensor=false"></script>

    <!-- Custom Theme JavaScript -->
    <script src="public/js/grayscale.js"></script>
    
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->



    <div class="modal fade" id="login-signup-dialog" tabindex="-1" role="dialog" aria-labelledby="login-signup-dialog-label">
        <div class="modal-dialog" role="document" style="color: black">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="login-signup-dialog-label">User Login/Sign-up</h4>
                </div>
                <div class="modal-body" style='font-family: Helvetica Neue,Helvetica,Arial,sans-serif' id="modal-body">
                    <ul class="nav nav-tabs nav-justified nav-pills">
                        <li class="active" id="login-tab"><a href="#tab1" data-toggle="tab">Login</a></li>
                        <li id="signup-tab"><a href="#tab2" data-toggle="tab">Sign-up</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <form action="Login.php" method="POST">
                                <div class="form-group">
									<br/>
                                    <label for="recipient-name" class="control-label">Email: </label>
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form>
                                <br/>
                                <div class="form-group">
                                    <label class="control-label">Email:</label>
                                    <input type="text" class="form-control" id="newEmail" name="email">
                                </div>
								<div class="form-group">
                                    <label class="control-label">Username:</label>
                                    <input type="text" class="form-control" id="newUsername" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Password:</label>
                                    <input type="password" class="form-control" id="newPassword" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Confirm Password:</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">First Name:</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Last Name:</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <button type="button" class="btn btn-primary" id="login-button">Submit</button>
                </div>
            </div>
        </div>
    </div>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i>  <span class="light">Make an</span> Impact
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">Impact Calculator</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#download">View Topics</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#download">About</a>
                    </li>
                    <li>
                        <?php 
                            if (isset($_SESSION) && isset($_SESSION['IS_LOGIN_VALID']) && $_SESSION['IS_LOGIN_VALID'])
                                echo '<a id="logout" href="logout">Logout</a>';
                            else
                                echo '<a id="login_modal" data-toggle="modal" data-target="#login-signup-dialog">Login/Sign Up</a>';
                            ?>
                            
                    </li>
                    <li>
                        <a id="dashboard" href="dashboard">Discussion Board</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">Global Justice</h1>
                        <p class="intro-text">Fight the world's injustice by working together.<br>Created by Virginia Tech.</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Impact Calculator</h2>
                <p>Grayscale is a free Bootstrap 3 theme created by Start Bootstrap. It can be yours right now, simply download the template on <a href="http://startbootstrap.com/template-overviews/grayscale/">the preview page</a>. The theme is open source, and you can use it for any purpose, personal or commercial.</p>
                <p>This theme features stock photos by <a href="http://gratisography.com/">Gratisography</a> along with a custom Google Maps skin courtesy of <a href="http://snazzymaps.com/">Snazzy Maps</a>.</p>
                <p>Grayscale includes full HTML, CSS, and custom JavaScript files along with LESS files for easy customization.</p>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Download Grayscale</h2>
                    <p>You can download Grayscale for free on the preview page at Start Bootstrap.</p>
                    <a href="http://startbootstrap.com/template-overviews/grayscale/" class="btn btn-default btn-lg">Visit Download Page</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact Start Bootstrap</h2>
                <p>Feel free to email us to provide some feedback on our templates, give us suggestions for new templates and themes, or to just say hello!</p>
                <p><a href="mailto:feedback@startbootstrap.com">feedback@startbootstrap.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="https://twitter.com/SBootstrap" class="btn btn-default btn-lg"><i class="fa fa-twitter fa-fw"></i> <span class="network-name">Twitter</span></a>
                    </li>
                    <li>
                        <a href="https://github.com/IronSummitMedia/startbootstrap" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/+Startbootstrap/posts" class="btn btn-default btn-lg"><i class="fa fa-google-plus fa-fw"></i> <span class="network-name">Google+</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <div id=""></div>

    <!-- Footer -->
    <footer>
    <script type="text/javascript">      
        $("#login-button").on("click", function()
        {
            if ($('#login-tab').hasClass('active')) 
            {
                //Validate the login form only
                var email = $('#username').val().trim();
                var password = $('#password').val().trim();
                
                if (email !== "" && password !== "")
                {
                    $.ajax({
                        type: "POST",
                        url: "login",
                        data: {email: email, password: password},
                        success: function(data)
                        {
                            if (data === "true")
                            {
                                function redirect() {
                                    window.location = "dashboard";
                                }
                                notif({
                                    msg: "Logging you in...",
                                    type: "success",
                                    position: "center",
                                    timeout: 2000
                                });
                                setTimeout(redirect(), 2000);
                            }
                            else
                            {
                                notif({
                                    msg: "Wrong Username or Password",
                                    type: "error",
                                    position: "center",
                                    timeout: 3000
                                });
                            }
                        }
                    });
                }
                else
                {
                    if (email === "") {
                        $('#username').css("borderColor","#F50101");
                    }
                    if (password === "") {
                        $('#password').css("borderColor","#F50101");
                    }
                    if ($('#login_error_message').length === 0) {
                        var div = document.createElement('div');
                        var message = document.createTextNode("Please fill in the blanks");
                        div.className = 'alert alert-danger';
                        div.setAttribute('id','login_error_message');
                        div.appendChild(message);
                        $('#modal-body').append(div);
                    }
                }
            }
            else
            {
                var username = $('#newUsername').val().trim();
                var password = $('#newPassword').val().trim();
                var email = $('#newEmail').val().trim();
                var confirmPassword = $('#confirmPassword').val().trim();
                var firstName = $('#firstName').val().trim();
                var lastName = $('#lastName').val().trim();

                if (password === confirmPassword)
                {
                    console.log('bye');
                    if (username.length > 0 && password.length > 0 && email.length > 0 
                    && email.indexOf('@') !== -1 && email.indexOf('.') !== -1 && confirmPassword.length > 0 
                    && firstName.length > 0 && lastName.length > 0) {
                        $.ajax({
                            type: "POST",
                            url: "signup",
                            data: {
                                username: username,
                                password: password,
                                confirmPassword: confirmPassword,
                                email: email,
                                firstName: firstName,
                                lastName: lastName
                            },
                            success: function(data) {
                                alert(data);
                            }
                        });
                    }
                }
            }
        });


    </script>
        
    </footer>


</body>

</html>
