
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Potion - libation tracker - Sign Up for Beta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Stylesheets -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>

<div class="container">

    <div class="row">


        <div class="span8">
            <?php

            $src_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src';

            if($_POST && is_array($_POST))
            {
                require_once($src_dir . DIRECTORY_SEPARATOR . 'form_processor.php');
                $form_processor = new FindPotion\FormProcessor();

                $result = $form_processor->signup($_POST);

                switch ($result)
                {
                    case 'success':
                        $alert_type = $result;
                        $message = "You did it! We will notify you once you are given beta access.<br/>
                                Thanks for finding Potion&trade;";
                        break;
                    case 'duplicate':
                        $alert_type = 'error';
                        $message = "You have already signed up and we will let you know soon.";
                        break;
                    case 'unsubscribed':
                        $alert_type = 'error';
                        $message = "This email has been unsubscribed previously.";
                        break;
                    case 'error':
                    default:
                        $alert_type = 'error';
                        $message = "There was an error. Please try again.";
                        break;
                }

                echo "<div class=\"alert alert-{$alert_type}\">
                        {$message}
                    </div>";
            }
            else if (isset($_GET['unsubscribe']))
            {
                require_once($src_dir . DIRECTORY_SEPARATOR . 'form_processor.php');
                $form_processor = new FindPotion\FormProcessor();

                $result = $form_processor->unsubscribe($_GET['unsubscribe']);

                switch ($result)
                {
                    case 'success':
                        $alert_type = $result;
                        $message = "Sorry to see you go, but we have removed you from our list.";
                        break;
                    case 'error':
                    default:
                        $alert_type = 'error';
                        $message = "There was an error. Please try again.";
                        break;
                }

                echo "<div class=\"alert alert-{$alert_type}\">
                        {$message}
                    </div>";
            }

            ?>

            <form class="form-horizontal" id="signUpHere" method='post' action=''>
                <fieldset>
                    <legend>Sign up for Potion&trade; private beta.</legend>
                    <div class="control-group">
                        <label class="control-label" for="input01">Name</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="user_name" name="user_name" data-content="Enter your first and last name." data-original-title="Full Name">

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input02">Email</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="user_email" name="user_email" data-content="What’s your email address?" data-original-title="Email">

                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input03"></label>
                        <div class="controls">
                            <input type="checkbox" class="checkbox" id="notify" name="notify" data-content="I would like to receive updates." data-original-title="Send Me Updates">
                            I would like to get email notifications about Potion&trade;
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="input04"></label>
                        <div class="controls">
                            <button type="submit" class="btn btn-success" rel="tooltip" title="first tooltip">Request Account</button>

                        </div>

                    </div>

                </fieldset>
            </form>
        </div>

    </div>


</div><!--/row-->
</div><!--/span-->
</div><!--/row-->

<hr>

<footer>
    <div class="container">
        <p>&copy; Potion, Inc</p>
    </div>
</footer>

</div><!--/.fluid-container-->

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#signUpHere").validate({
            rules:{
                user_name:{
                    required:true
                },
                user_email:{
                    required:true,
                    email: true
                },
                gender:{
                    required:true
                }
            },
            messages:{
                user_name:"Enter your full name",
                user_email:{
                    required:"Enter your email address",
                    email:"Enter valid email address"
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>

</body>
</html>

