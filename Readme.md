# Simple Authentication Package
Simple Auth Package is a simple authentication system built in PHP, offering basic functionality for user registration, login, session management, and CSRF token generation/validation. The package is lightweight, easy to integrate, and can be extended to fit your needs. In the future, features like email verification will be added.

## Features

- **User Registration**
- **User Login**
- **Session Management**
- **CSRF Token Generation and Validation**
- **User Logout**
- **Logging (Error, Warning, Info)**


## Installation

To install and use this package, follow these steps:

### Install the package using Composer

- Make sure Composer is installed, then run:

```bash
composer require etech-online-academy/simple-package
```
- Include Composer Autoloader in your project
After installing via Composer, include the autoloader in your main PHP file:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Classes and Usage
1. Session Class
The Session class is used to manage session data (like user details) in the application.

#### Set Session Data Use this method to store user data in the session:


```php
use AuthPackage\Session;

Session::setsession([
    'fullname' => 'John Doe',
    'userid' => 'user123',
    'useremail' => 'john.doe@example.com',
    'user_role' => 'student'
]);
```

2. CSRFToken Class
The CSRFToken class provides methods to generate and validate CSRF tokens for secure form submissions.

Generate a CSRF Token
Use this method to generate a CSRF token and include it in a form:
```php
use AuthPackage\CSRFToken;

$csrfToken = CSRFToken::generateToken();
echo "<input type='hidden' name='csrf_token' value='{$csrfToken}'>";
```
- Validate the CSRF Token
Validate the CSRF token when processing a form submission:
```php
use AuthPackage\CSRFToken;

if (!CSRFToken::validateToken($_POST['csrf_token'])) {
    die('Invalid CSRF token.');
}
```
- Remove CSRF Token
Once the form is processed, remove the token from the session:
```php
use AuthPackage\CSRFToken;

CSRFToken::removeToken();
```
3. Auth Class
The Auth class handles user authentication (registration, login, session management).

- Register a New User,
Use this method to register a new user:
```php
use AuthPackage\Auth;

$auth = new Auth();
$registrationResult = $auth->register('John Doe', 'john.doe@example.com', 'SecurePass123!');

if ($registrationResult === true) {
    echo "Registration successful!";
} else {
    echo "Error: " . $registrationResult;
}
```
- Login a User,
This method logs a user in by validating their email and password:

```php
use AuthPackage\Auth;

$auth = new Auth();
$loginResult = $auth->login('john.doe@example.com', 'SecurePass123!');

if ($loginResult === true) {
    echo "Login successful!";
} else {
    echo "Error: Invalid credentials.";
}
```
- Check if the User is Logged In,You can check if a user is logged in by checking the session:
```php
if ($auth->isLoggedIn('userid')) {
    echo "User is logged in!";
} else {
    echo "User is not logged in.";
}
```
- Logout the User,This method logs the user out by destroying the session:
```php
$auth->logout();
echo "You have been logged out.";
```

4. Logger Class,
The Logger class allows you to log messages to a log file for error tracking, debugging, and general information.

Log a Message
Use the Logger::log() method to log messages. You can log messages with different severity levels: INFO, WARNING, and ERROR.
```php
use AuthPackage\Logger;

// Log an info message
Logger::log('User logged in successfully', 'INFO');
// Log a warning message
Logger::log('Password attempt failed', 'WARNING');
// Log an error message
Logger::log('Database connection failed', 'ERROR');

```
### Log Format
Each log entry will include:

- Timestamp: Date and time of the log entry.
- Log Level: Severity level (INFO, WARNING, ERROR).
- Message: The log message.
- Context: Optional additional context for debugging.

1. Sample log entry:
```php
[2025-05-12 12:00:00] INFO: User logged in successfully
[2025-05-12 12:01:00] WARNING: Password attempt failed
[2025-05-12 12:02:00] ERROR: Database connection failed
```
2. Log to a Custom File
-  You can customize the log file path when initializing the Logger:
```php
use AuthPackage\Logger;
// Initialize Logger with a custom log file path
Logger::setLogFilePath(__DIR__ . '/custom_logs/auth_log.txt');
// Log an error message to the custom log file
Logger::log('Error while connecting to database', 'ERROR');
```

### Example Usage in a Simple Application
```php
// Include the Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

use AuthPackage\Auth;
use AuthPackage\CSRFToken;
use AuthPackage\Session;

// Create a new instance of Auth
$auth = new Auth();

// Handle user registration
if (isset($_POST['register'])) {
    $csrfToken = $_POST['csrf_token'];

    // Validate CSRF token
    if (!CSRFToken::validateToken($csrfToken)) {
        die('Invalid CSRF token.');
    }

    // Register the user
    $registrationResult = $auth->register($_POST['username'], $_POST['email'], $_POST['password']);
    
    if ($registrationResult === true) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $registrationResult;
    }
}

// Handle user login
if (isset($_POST['login'])) {
    $csrfToken = $_POST['csrf_token'];

    // Validate CSRF token
    if (!CSRFToken::validateToken($csrfToken)) {
        die('Invalid CSRF token.');
    }

    // Login the user
    $loginResult = $auth->login($_POST['email'], $_POST['password']);
    
    if ($loginResult === true) {
        echo "Login successful!";
    } else {
        echo "Error: Invalid credentials.";
    }
}

// Check if the user is logged in
if ($auth->isLoggedIn('userid')) {
    echo "Welcome, " . $_SESSION['fullname'];
} else {
    echo "Please log in.";
}
```



### License
This package is licensed under the MIT License.
### Contribution
We welcome contributions! If you'd like to help improve this package, please fork the repository, make your changes, and submit a pull request. If you encounter any bugs or have feature requests, please open an issue in the repository.


