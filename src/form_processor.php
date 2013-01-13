<?php
namespace FindPotion;

use PDO,
    Exception;

class FormProcessor
{
    /**
     * @var array
     */
    protected $conf = array();

    /**
     * Basic construct, grabs the config and loads it
     */
    function __construct()
    {
        $this->conf = $this->get_config();
    }

    /**
     * Basic signup function to add an email to our DB
     *
     * @param array $post
     * @return string
     * @throws \Exception
     */
    function signup(array $post)
    {
        // Assert that we have our required fields
        if ($this->assert_required_fields($post))
        {
            // Prepare for any exception catching
            try
            {
                // Validate the email field
                if (! filter_var($post['user_email'], FILTER_VALIDATE_EMAIL))
                {
                    throw new Exception("Email address is not valid.");
                }

                // basic sanitization on user name
                $post['user_name'] = filter_var($post['user_name'], FILTER_SANITIZE_STRING);

                // Check for existing user
                if ($this->existing_email_signup($post['user_email']))
                {
                    return 'duplicate';
                }

                // Do all the DB saving work
                $post['user_key'] = $this->save_form_submission($post);

                return 'success';
            }
            catch (Exception $e)
            {
                // Log errors
                error_log("Could not process form submission: " . $e->getMessage());
                return 'error';
            }
        }
    }

    /**
     * @param $email
     * @return bool
     */
    private function existing_email_signup($email)
    {
        // Grab db handle
        $dbh = $this->get_db_handle();

        // Prepare statement
        $stmt = $dbh->prepare("SELECT * FROM signup WHERE user_email = :user_email");

        // bind the params to statement
        $stmt->bindParam(':user_email', $email);

        // Execute
        $stmt->execute();

        // Grab all statement results
        $result = $stmt->fetchAll();

        // true for existing results / false for no results
        return (bool) $result;
    }

    /**
     * @param array $post
     */
    private function save_form_submission(array $post)
    {
        // Grab a db handle
        $dbh = $this->get_db_handle();

        // prepare the bestest DB insert statement
        $stmt = $dbh->prepare("INSERT INTO signup (user_name, user_email, notify, user_key, created)
                                VALUES (:user_name, :user_email, :notify, :user_key, :created)");

        // bind all the simple params to the statement
        $stmt->bindParam(':user_name', $post['user_name'], PDO::PARAM_STR, 1000);
        $stmt->bindParam(':user_email', $post['user_email'], PDO::PARAM_STR, 1000);

        // check for notify key, and set to true/false depending on existence
        $post['notify'] = isset($post['notify']);
        // then bind
        $stmt->bindParam(':notify', $post['notify'], PDO::PARAM_BOOL);

        // Grab a UTC datetime obj
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('UTC'));
        // Set created by mysql's datetime format ... bleh
        $stmt->bindParam(':created', $datetime->format('Y-m-d H:i:s'));

        // Get a unique user key
        $user_key = $this->generate_user_key();
        // BIND!
        $stmt->bindParam(':user_key', $user_key);

        // DO IT ALL!
        $stmt->execute();

        return $user_key;
    }

    /**
     * TODO: This doesn't account for any other user_keys created at the same time...make super ultimate unique
     * @return string
     */
    private function generate_user_key()
    {
        // Try a simple uniqid with the most entropies
        $user_key = uniqid('', true);

        // Check for existence of that uniqid
        if ($this->existing_user_key($user_key))
        {
            // If it already exists, let's try again
            $this->generate_user_key();
        }

        //we got something that **should** be unique
        return $user_key;
    }

    /**
     * @param $user_key
     * @return bool
     */
    private function existing_user_key($user_key)
    {
        // Grab a DB handle
        $dbh = $this->get_db_handle();

        // prepare the statement
        $stmt = $dbh->prepare("SELECT * FROM signup WHERE user_key = :user_key");

        // bind params to the statement
        $stmt->bindParam(':user_key', $user_key);

        // Execute!
        $stmt->execute();

        // get any results
        $result = $stmt->fetchAll();

        // true is we had truthy, false if not.
        return (bool) $result;
    }

    /**
     * @return \PDO
     */
    private function get_db_handle()
    {
        // Read our conf
        $conf = $this->conf;

        // Load the dsn string
        $dsn = "mysql:host={$conf['db']['host']};dbname={$conf['db']['name']};charset=UTF-8";

        // instantiate a new PDO
        $dbh = new PDO($dsn, $conf['db']['user'], $conf['db']['password']);

        // Turn on Exceptions
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // pass back our db handle
        return $dbh;
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function get_config()
    {
        // Load the conf str
        $conf_file = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'config.ini';

        // Check for conf file's existence
        if (! file_exists($conf_file))
        {
            throw new Exception("Configuration cannot be found.");
        }

        // parse the conf file
        return parse_ini_file($conf_file, true);
    }

    /**
     * @return array
     */
    private function required_fields()
    {
        // required fields array
        return array("user_name", "user_email");
    }

    /**
     * @param array $post
     * @return bool
     */
    protected function assert_required_fields(array $post)
    {
        // Check required fields against submitted fields
        foreach ($this->required_fields() as $required_field)
        {
            if (! array_key_exists($required_field, $post))
            {
                return false;
            }
        }
        return true;
    }
}