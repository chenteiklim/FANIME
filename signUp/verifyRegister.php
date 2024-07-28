
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fanime";

require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $usernames = $_POST['names'];
    $basePassword = $_POST['passwords'];
    $confirm_email=$_POST['email2'];
    $confirm_password = $_POST['password2'];
    mysqli_select_db($conn, $dbname); 

    // Check if username already exists in the database
    $checkUsername = "SELECT * FROM users WHERE usernames = '$usernames'";
    $result = $conn->query($checkUsername);
    if ($result->num_rows > 0) {
      header("Location: signUp.html?success=1");
      exit();
    }

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);
    if ($result->num_rows > 0) {
        header("Location: signUp.html?success=2");
        exit();
    }
     // Check if email same with confirm email
    if ($email != $confirm_email) {
        header("Location: signUp.html?success=3");
        exit();
    } 

    // Check if password same with confirm password
    if ($basePassword != $confirm_password) {
        header("Location: signUp.html?success=4");
        exit();
    } 
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signUp.html?success=5");
        exit();
    }

    $passwords = password_hash($_POST['passwords'], PASSWORD_BCRYPT);
    $token = bin2hex(random_bytes(50)); // Generate a unique token
    // Insert user data into the database with a pending status
    $sql = "INSERT INTO users (usernames, email, passwords, token, verified) VALUES ('$usernames', '$email', '$passwords', '$token', 0)";
    
    if ($conn->query($sql) === TRUE) {
        // Send verification email
        $mail = new PHPMailer(true);
        try {
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'f743161100f2a2';
            $phpmailer->Password = '********a1e3';

            $mail->setFrom('abc@hotmail.com', 'Fanime');
            $mail->addAddress('test@hotmail.com', 'Fanime');
            $mail->isHTML(true);
            $mail->Subject = 'Please verify your email address';
            $mail->Body = '<p>Click the link below to verify your email address:</p>
                            <p><a href="http://localhost/project/Fanime/signUp/verify.php?token=' . $token . '">Verify Email</a></p>';

            $mail->send();
            header("Location: checkRegister.html");

        } catch (Exception $e) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>