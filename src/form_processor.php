<?php
namespace FindPotion;

use PDO,
    Exception,
    FindPotion\Config;

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
        $this->conf = Config::get_config();
    }

    /**
     * Basic signup function to add an email to our DB
     *
     * @param array $post
     * @return string
     * @throws \Exception
     */
    function sign_up(array $post)
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

                // basic sanitization on notes
                $post['user_notes'] = filter_var($post['user_notes'], FILTER_SANITIZE_STRING);

                // Check for existing user
                if ($this->existing_email_signup($post['user_email']))
                {
                    return 'duplicate';
                }

                // Do all the DB saving work
                $this->save_form_submission($post);
            }
            catch (Exception $e)
            {
                // Log errors
                error_log("Could not process form submission: " . $e->getMessage());
                return 'error';
            }

            return 'success';
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
        $stmt = $dbh->prepare("INSERT INTO signup (user_name, user_email, user_notes, invite_code, notify, created)
                                VALUES (:user_name, :user_email, :user_notes, :invite_code, :notify, :created)");

        // bind all the simple params to the statement
        $stmt->bindParam(':user_name', $post['user_name'], PDO::PARAM_STR, 1000);
        $stmt->bindParam(':user_email', $post['user_email'], PDO::PARAM_STR, 1000);

        // check for notify key, and set to true/false depending on existence
        $post['notify'] = isset($post['notify']);
        // then bind
        $stmt->bindParam(':notify', $post['notify'], PDO::PARAM_BOOL);

        // bind the user notes
        $stmt->bindParam(':user_notes', $post['user_notes']);

        // bind the invite code
        $stmt->bindParam(':invite_code', $post['invite_code'], PDO::PARAM_STR);

        // Grab a UTC datetime obj
        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('UTC'));
        // Set created by mysql's datetime format ... bleh
        $stmt->bindParam(':created', $datetime->format('Y-m-d H:i:s'));

        // DO IT ALL!
        $stmt->execute();
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