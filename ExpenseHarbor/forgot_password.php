<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background: linear-gradient(135deg, #fdfbfb, #D0F0C0);
}

form {
    width: 400px;
    padding: 20px;
    border-radius: 8px;
    margin: auto;
    text-align: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    background-color: #e8f6ef;
    border: 2px solid #44bd32;
    color: #44bd32;
}

.group {
    margin-bottom: 20px;
}

.form-controller {
    position: relative;
    margin-bottom: 25px;
}

.form-controller i.fa {
    position: absolute;
    top: 10px;
    left: 10px;
    color: #888;
}

input[type="text"] {
    width: calc(100% - 40px);
    padding: 10px 10px 10px 30px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
}

input[type="text"]:focus {
    border-color: #555;
}

button[type="submit"] {
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    background-color: #3498db;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #2980b9;
}
 </style>
</head>

<body>
    <form action="process_reset_password.php" method="post">
        <div class="group">
            <div class="form-controller">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <input type="text" name="email_or_username" placeholder="Enter Email or Username" required>
            </div>
        </div>
        <button type="submit" class="reset-password" name="reset_password">Reset Password</button>
    </form>
</body>

</html>
