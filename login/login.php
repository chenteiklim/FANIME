<?php
$servername = "localhost";
$Username = "root";
$Password = "";
$dbname = "FANIME";  

$conn = new mysqli($servername, $Username, $Password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

session_start();

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['passwords'];

  // Select database
  mysqli_select_db($conn, $dbname); 

  // Retrieve the hashed password from the database based on the provided email
  $sql = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($sql);
 
  if ($result === false) {
    // Display SQL error message
    echo "SQL Error: " . $conn->error;
  }

  if ($result->num_rows > 0) {
    // Fetch the user's data
    $row = $result->fetch_assoc();
    $hashed_password = $row['passwords'];
    
    if ($row['verified'] == 1 && password_verify($password, $row['passwords'])) {
        // Password correct, proceed with login
        $_SESSION['email'] = $email;
        header("Location: ../main/mainpage.html");
        exit(); // Ensure that further code execution is stopped after the redirection
    } 
      
    else {
      // Password incorrect
      header("Location: login.html?success=5");
      exit();
    }
  }
   
  else {
    // No user found with the provided email
    header("Location: login.html?success=5");
    exit();
  }
}
?>