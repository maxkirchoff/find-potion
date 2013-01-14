
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
    <div class="span10 offset1">
        <div class="row">
            <div class="span5" id="signup">
                <h2>Sign up for <span class="logo">Potion</span>.</h2>
                <form class="form-vertical" id="signUpHere" method='post' action=''>
                    <fieldset>
                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="user_name" name="user_name" placeholder="Your Full Name" data-content="Enter your first and last name." data-original-title="Full Name">
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <input type="text" class="input-xlarge" id="user_email" name="user_email" placeholder="Your Email Address" data-content="What’s your email address?" data-original-title="Email">

                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <input type="checkbox" class="checkbox" id="notify" name="notify" data-content="I would like to receive updates." data-original-title="Send Me Updates">
                                I want to get emails about <span class="logo">Potion</span>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn btn btn-primary btn-large" rel="tooltip" title="first tooltip">Request Account</button>
                            </div>
                        </div>

                    </fieldset>
                </form>

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
                                    Thanks for finding <span class='logo'>Potion</span>";
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
                ?>
            </div>
            <div class="span5" id="whatis">
                <h2>What is <span class="logo">Potion</span>?</h2>
                <p>
                    <span class="logo">Potion</span> is all about the liquids you love.
                    <br/>
                    <br/>
                    You don't have to dig through hundreds of posts, tweets, emails, and searches just to find out about your perfect IPA or favorite Pinot.
                    <br/>
                    <br/>
                    Follow beers, wine, and other libations to get the info you want and the recommendation you need.
                    <br/>
                    <br/>
                    Follow a single bottle of brew or a specific label of wine.
                    <br/>It's up to you.
                    <br/>
                </p>
            </div>
        </div>
        <footer>
            <div class="container">
            </div>
        </footer>
    </div>
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

