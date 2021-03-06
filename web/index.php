<?php
$invite_code = isset($_COOKIE['invite_code']) ? $_COOKIE['invite_code'] : '';

$src_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src';
require_once($src_dir . DIRECTORY_SEPARATOR . 'config.php');
$config = \FindPotion\Config::get_config();

if($_POST && is_array($_POST))
{
    require_once($src_dir . DIRECTORY_SEPARATOR . 'form_processor.php');
    $form_processor = new FindPotion\FormProcessor();

    $result = $form_processor->sign_up($_POST);

    switch ($result)
    {
        case 'success':
            $alert_type = $result;
            $message = "You did it! We will notify you with further information.<br/>
                                        Thanks for finding <span class='logo'>Potion</span>.";
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
else
{
?>
<!DOCTYPE html>
<html lang="en" xmlns:fb="http://ogp.me/ns/fb#">
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

<!-- facebook stuff -->
<div id="fb-root"></div>
<script>
    (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=540679195963568";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>

<div class="container">
    <div class="span10 offset1">
        <div class="row">
            <div class="span5">
                <div id="signup">
                    <h2>Sign up for <span class="logo">Potion</span>.</h2>
                    <p>You will have a chance to take part in our ALPHA release as well as provide feedback on our features.</p>
                    <div id="formWrapper">
                        <form class="form-vertical" data-async data-target="#formWrapper" id="signUpHere" method='POST' action='index.php'>

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
                                <?php if ($invite_code && !$_POST) { ?>
                                    <div class="alert">The link you followed has an invite code. <br />You get priority! :P</div>
                                <?php } ?>
                                <div class="control-group">
                                    <div class="controls">
                                        <button type="submit" class="btn btn btn-primary btn-large" rel="tooltip" title="first tooltip">Sign Up</button>
                                    </div>
                                </div>

                            </fieldset>
                        </form>
                    </div>
                </div>
                <div id="follow">
                    <h2>Follow <span class="logo">Potion</span></h2>

                    <!-- facebook follow icon -->
                    <div class="socialIcons">
                        <a href="http://www.facebook.com/pages/Potion/125810240932579" rel="external">
                            <img src="img/f_logo.png" class="facebookLogo" width=65 height=65 alt="Potion on Facebook"/>
                        </a>
                    </div>

                    <!-- Twitter follow icon -->
                    <div class="socialIcons">
                        <a href="https://twitter.com/FindPotion" rel="external">
                            <img src="img/twitter.png" class="twitterLogo" width=65 height=65 alt="@FindPotion on Twitter"/>
                        </a>
                    </div>
                    <!-- Google+ follow icon -->
                    <div class="socialIcons">
                        <a href="https://plus.google.com/101434536275916119513?prsrc=3" rel="external">
                            <img src="//ssl.gstatic.com/images/icons/gplus-64.png" alt="Potion on Google+" style="border:0;width:64px;height:64px;"/>
                        </a>
                    </div>
                    <p></p>
                </div>
                <?php if (isset($config['contact']['email'])) { ?>
                <div id="contactUs" class="wide">
                    <h2>Have a question?</h2>
                    <p>
                        Email us at <a href="mailto:<?php echo $config['contact']['email']; ?>"><?php echo $config['contact']['email']; ?></a>
                    </p>
                </div>
                <?php } ?>
            </div>
            <div class="span5">
                <div id="brand">
                    <img src="img/potion_branding2.png" class="brand-image">
                </div>
                <div class="what" id="whatIs">
                    <h2>What is <span class="logo">Potion</span>?</h2>
                    <p>
                        Beer, wine, coffee - <span class="logo">Potion</span> is all about the liquids you love.
                    </p>
                    <p>
                        Fulfill your inner snob without the work. Collect spectacular roasts, special IPAs, tasty Pinots and discover new favorites at the tip of your fingers.
                    </p>
                </div>
                <div class="what" id="whatDoes">
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
            <?php if (isset($config['contact']['email'])) { ?>
            <div id="contactUs" class="narrow">
                <h2>Have a question?</h2>
                <p>
                    Email us at <a href="mailto:<?php echo $config['contact']['email']; ?>"><?php echo $config['contact']['email']; ?></a>
                </p>
            </div>
            <?php } ?>
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
<script type="text/javascript" src="js/site.js"></script>
<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo $config['analytics']['google']; ?>']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
</body>
</html>
<?php }
