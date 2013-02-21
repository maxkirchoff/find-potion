<?php
$invite_code = isset($_COOKIE['invite_code']) ? $_COOKIE['invite_code'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Potion Libation tracker - Sign Up for Alpha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="og:title" content="Potion Libation tracker - Sign Up for Alpha"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://findpotion.com/"/>
    <meta property="og:image" content="http://findpotion.com/img/potion-og.png"/>
    <meta property="og:description"
          content="Beer, wine, coffee - Potion is all about the liquids you love.
          Fulfill your inner snob without the work. Collect spectacular roasts,
          special IPAs, tasty Pinots and discover new favorites at the tip of your fingers."/>
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
            <div class="span5">
                <div id="brand">
                    <img src="img/potion_branding2.png" class="brand-image">
                </div>
                <div id="signup">
                    <h2>Sign up for <span class="logo">Potion</span>.</h2>
                    <p>You will have a chance to take part in our ALPHA release as well as provide feedback on our features.</p>
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
                                    <textarea type="text" class="input-xlarge" id="user_notes" name="user_notes" rows=5 placeholder="Why you want to try Potion..." data-content="Why you want to try Potion..." data-original-title="Notes"></textarea>
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="controls">
                                    <input type="checkbox" class="checkbox" id="notify" name="notify" data-content="I would like to receive updates." data-original-title="Send Me Updates">
                                    I want to get email updates about <span class="logo">Potion</span>
                                </div>
                            </div>

                            <input type="hidden" id="invite_code" name="invite_code" value="<?php echo $invite_code; ?>">
                            <?php if (isset($_COOKIE['invite_code'])) { ?>
                                <div class="alert">The link you followed has an invite code. <br />You get priority! :P</div>
                            <?php } ?>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn btn btn-primary btn-large" rel="tooltip" title="first tooltip">Sign Up</button>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                    <?php

                    $src_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src';

                    if($_POST && is_array($_POST))
                    {
                        require_once($src_dir . DIRECTORY_SEPARATOR . 'form_processor.php');
                        require_once($src_dir . DIRECTORY_SEPARATOR . 'config.php');
                        $form_processor = new FindPotion\FormProcessor();

                        $result = $form_processor->sign_up($_POST);

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
            </div>
            <div class="span5">
                <div class="what" id="whatis">
                    <h2>What is <span class="logo">Potion</span>?</h2>
                    <p>
                        Beer, wine, coffee - <span class="logo">Potion</span> is all about the liquids you love.
                    </p>
                    <p>
                        Fulfill your inner snob without the work. Collect spectacular roasts, special IPAs, tasty Pinots and discover new favorites at the tip of your fingers.
                    </p>
                </div>
                <div class="what" id="whatdoes">
                    <h2>What does <span class="logo">Potion</span> do?</h2>
                    <h4>Collect</h4>
                    <p>
                        Snap a photo when you try something new - OR - add tasty beverages from your posts on Facebook, Twitter and Instagram.
                    </p>
                    <h4>Follow</h4>
                    <p>
                        Select your favorite drinks and their producers to get tailored news, inside info and updates.
                    </p>
                    <h4>Discover</h4>
                    <p>
                        Check out recommendations based on everything you've ever drank or just a few of your most beloved.
                    </p>
                    <h4>Share</h4>
                    <p>
                        Post your top picks from a day of wine tasting or an inebriated brewfest so friends can admire you as a guru of libations.
                    </p>
                </div>
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
                user_notes:{
                    required:true
                },
                gender:{
                    required:true
                }
            },
            messages:{
                user_name:"Enter your full name",
                user_notes:"Please tell us why you want to join",
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

