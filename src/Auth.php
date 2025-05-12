<?php


namespace AuthPackage;

use AuthPackage\Database;
use AuthPackage\Validator;
use AuthPackage\Session;


class Auth
{
    private $db;
    // private $sessionKey = 'user_id';

    public function __construct()
    {
        $this->db = (new Database())->getConnection();

        // session_start();
    }

    // Register a new user with validation
    public function register($username, $email, $password)
    {
        // Validate input data
        if (!Validator::validateRequired($username)) {
            return "Username is required.";
        }

        if (!Validator::validateEmail($email)) {
            return "Invalid email format.";
        }

        if (!Validator::validatePassword($password)) {
            return "Password must be at least 8 characters long, and include one uppercase letter, one number, and one special character.";
        }

        $sql = "select * from users where email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        // Check if the email already exists
        if ($stmt->num_rows > 0) {
            return "Email already exists.";
        } else {
            // create new user if the email is not exist in the database
            $randomuserid = $this->checkuniqueid();
            $role = 'student'; // Default role for new users
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("INSERT INTO users (userid ,fullname, email, password,role) VALUES (?,?,?,?,?)");
            $stmt->bind_param('sssss', $randomuserid, $username, $email, $hashedPassword, $role);
            if ($stmt->execute()) {
                return true;
            }
            return false;
        }
    }

    // Login a user with validation
    public function login($email, $password)
    {
        // Validate input data
        if (!Validator::validateRequired($email) || !Validator::validateRequired($password)) {
            return "Both username and password are required.";
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $fetch = $result->fetch_all(MYSQLI_ASSOC);
        if ($fetch[0]['email'] == $email && password_verify($password, $fetch[0]['password'])) {

            //Apply session here 
            Session::setsession($sessionKeys = array(
                'fullname' => $fetch[0]['fullname'],
                'userid' => $fetch[0]['userid'],
                'useremail' => $fetch[0]['email'],
                'user_role' => $fetch[0]['role']
            ));

            return true;
        }
        return false;
        // return "Invalid credentials.";
    }

    // Check if the user is logged in
    public function isLoggedIn($sessionkey)
    {
        return isset($_SESSION[$sessionkey]);
    }

    // Logout the user
    public function logout()
    {
        session_destroy();
        // session_start();
    }

    // generate unique userid
    public function generateuserid(int $length = 30): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = strlen($chars) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[random_int(0, $max)];
        }

        return $str;
    }



    // check of the uniqe id is exsit in database if its true generate new unique userid for indivitual
    public function checkuniqueid(): string
    {

        // Generate a random UUID
        $randomuserid = $this->generateuserid(28);

        // SQL query to check if the UUID exists in the database
        $sql = "select * from users where userid = ?";
        // Prepare the statement
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $randomuserid);
        // Execute the statement
        $stmt->execute();

        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $randomuserid = $this->generateuserid(28);
        }
        return   $randomuserid;
    }
}
