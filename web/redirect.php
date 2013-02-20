<?php
$src_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src';
require_once($src_dir . DIRECTORY_SEPARATOR . 'config.php');

// Get the config
// If you're reading this, use the redirect.php?invite_code=github if you want early access ;)
$config = \FindPotion\Config::get_config();

// If we have invite codes
if (isset($config['invite_codes']))
{
    // If someone sent an invite code and that code is a invite code array key
    if (isset($_GET['invite_code']) && array_key_exists($_GET['invite_code'], $config['invite_codes']))
    {
        // set the invite code in the cookie
        setcookie("invite_code", $config['invite_codes'][$_GET['invite_code']], time() + (86400* 7));
    }
}

header("Location: /");