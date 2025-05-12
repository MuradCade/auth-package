# 🔐 PHP OOP Authentication Package
A modular, object-oriented PHP authentication package with built-in validation, secure password hashing, custom user ID generation, logging, and MySQLi prepared statements. Ideal for quickly integrating user registration and login into procedural or OOP PHP projects.

## 📦 Package Components
Class	Responsibility
Database	Manages secure database connections (MySQLi).
Auth	Handles user registration, login, logout, session checking, and unique ID generation.
Validator	Provides input validation: email format, password strength, and required fields.
Logger	Logs errors, warnings, and info to a file with auto-rotation when the log exceeds 1MB.

## 🚀 Features
- ✅ Email & password validation

- 🔐 Secure password hashing (BCRYPT)

- 🧪 Clean input validation utilities

- 🧾 Auto-rotating file-based error logging

- 🔁 Unique user ID generation with collision checking

- 🛡️ Fully uses prepared statements (MySQLi)

- 🛠️ Installation


# Clone the repo or copy the AuthPackage directory to your project.

- Ensure your database has a users table (see schema below).

- Update database credentials in Database.php if needed.

- 🧱 Database Schema Example
```sql

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  userid VARCHAR(50) UNIQUE,
  fullname VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  role VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
## 📄 Example Usage
➕ Register a User
```php

require_once 'AuthPackage/Auth.php';

use AuthPackage\Auth;

$auth = new Auth();

$result = $auth->register('John Doe', 'john@example.com', 'Password@123');

if ($result === true) {
    echo "Registration successful!";
} else {
    echo "Error: $result";
}
```
## 🔐 Login a User
```php

require_once 'AuthPackage/Auth.php';

use AuthPackage\Auth;

$auth = new Auth();

$result = $auth->login('john@example.com', 'Password@123');

if ($result === true) {
    echo "Login successful!";
    $_SESSION['user_id'] = 'some_user_id'; // Set your own logic here
} else {
    echo "Error: $result";
}
```
## 🔒 Check Session
```php

session_start();
if ($auth->isLoggedIn('user_id')) {
    echo "User is logged in.";
} else {
    echo "User is not logged in.";
}
```
## 🚪 Logout
```php

$auth->logout();
echo "Logged out.";
```
## 📋 Validation Utilities
- Available via Validator class:

```php

Validator::validateEmail($email);
Validator::validatePassword($password);
Validator::validateRequired($username);
```
##🧾 Logging Usage
- Use the Logger for custom logs:
```php

use AuthPackage\Logger;

Logger::info("User registration attempt");
Logger::warning("Possible brute force detected", ['ip' => $_SERVER['REMOTE_ADDR']]);
Logger::error("Database error occurred");
```
## 🧠 Notes
The package is designed for educational or prototype-level use. You may wish to adapt it for production (e.g. stronger session security, rate-limiting, CSRF protection).

### Log rotation is automatically handled when the log file exceeds 1MB.

## 📁 Project Structure
```pgsql

AuthPackage/
│
├── Auth.php
├── Database.php
├── Validator.php
├── Logger.php
└── logs/
    └── error_log.txt
```
## 🔮 Future Improvements (Optional Ideas)
- Add user role-based access control.

- Add email verification.

- Add password reset via email token.

- Convert to PSR-4 and make installable via Composer.