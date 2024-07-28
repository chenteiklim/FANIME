<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fanime</title>
    <link rel="icon" href="../assets/logo.png" sizes="32x32" type="image/png">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: white;
        }
        .container {
            text-align: center;
            background: lavendar;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            color: #555;
        }
        #bigTitle{
            display:flex;
        }

        #logoImg{
            margin-left:10px;
            width: 30px;
            height:30px;
        }
        #fanime{
            font-size: 30px;
            margin-left:5px;
        }

    </style>
</head>
<body>
    
    <div class="container">
        <div id="bigTitle">
            <img id="logoImg" src="../assets/logo.png" alt="" srcset="">
            <div id="fanime">Fanime</div>  
        </div>
    
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "fanime";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            // Prepare the SQL query to find the user by token
            $sql = "SELECT * FROM users WHERE token = '$token' AND verified = 0";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Token is valid, mark the user as verified
                $sql = "UPDATE users SET verified = 1 WHERE token = '$token'";
                if ($conn->query($sql) === TRUE) {
                    echo "<h1>Verification Successful!</h1>";
                    echo "<p>Your email has been verified. You can now log in.";
                } else {
                    echo "<h1>Verification Failed</h1>";
                    echo "<p>There was an error updating your account. Please try again later.</p>";
                }
            } else {
                echo "<p>The verification link is invalid or expired. Please request a new verification link.</p>";
            }
        } else {
            echo "<h1>No Token Provided</h1>";
            echo "<p>No verification token was provided. Please use the link sent to your email.</p>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>