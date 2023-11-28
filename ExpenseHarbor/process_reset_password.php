<?php
include_once "init.php"; // Include necessary files and configurations
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fdfbfb, #8FBC8B);
        }
        .message-container {
            width: 400px;
            padding: 20px;
            border-radius: 8px;
            margin: auto;
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .success-message {
            border: 2px solid #44bd32;
            background-color: #e8f6ef;
            color: #44bd32;
        }
        .error-message {
            border: 2px solid #e84118;
            background-color: #f7d7da;
            color: #e84118;
        }
        .return-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #3498db;
            transition: background-color 0.3s ease;
        }
        .return-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reset_password'])) {
        $emailOrUsername = $getFromU->checkInput($_POST['email_or_username']);
        
        // Check if the email or username exists in the 'user' table
        $user = $getFromU->getUserByEmailOrUsername($emailOrUsername);

        if ($user) {
            // Generate a unique reset token
            $resetToken = bin2hex(random_bytes(32));
            $expiryTime = date('Y-m-d H:i:s', strtotime('+1 hour')); // Set expiry time (e.g., 1 hour)

            // Update the user's information with the reset token and expiry time
            $getFromU->setResetToken($user->UserId, $resetToken, $expiryTime);

            // Send a password reset email with a link containing the reset token
            $resetLink = "http://yourwebsite.com/reset_password.php?token=$resetToken";
            $to = $user->Email;
            $subject = "Password Reset";
            $message = "Dear user,<br>To reset your password, click on the following link: <a href='$resetLink'>$resetLink</a>";
            $headers = "From: your-email@example.com\r\nContent-Type: text/html"; // Replace with your email and specify HTML content type

            // Uncomment the line below to send the email
            //mail($to, $subject, $message, $headers);

            // Output with styling
            echo "<div class='message-container success-message'>";
            echo "<p>Password reset link has been sent to your email.</p>";
            echo "<p>Please check your inbox.</p>";
            echo "<a href='index.php' class='return-btn'>Return To Login Page</a>";
            echo "</div>";
        } else {
            // Output with styling
            echo "<div class='message-container error-message'>";
            echo "<p>No user found with this email or username.</p>";
            echo "<a href='index.php' class='return-btn'>Return To Login Page</a>";
            echo "</div>";
        }
    }
} else {
    header("Location: index.php");
    exit();
}
?>
</body>
</html>
