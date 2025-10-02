<?php
session_start();
include 'connection.php';


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password'])){
        $name = trim($_POST['name']) ;
        $email = trim($_POST['email']) ;
        $phone = trim($_POST['phone']) ;
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
//check email if already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check -> bind_param("s", $email);
        $check -> execute();
        $check -> store_result();
        if($check-> num_rows > 0){
            $message =  "<p>Email is used in another account . please use another EMAIL different from .$email</p>";
        } else{
            $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES(?, ?, ?,? )");
            $stmt->bind_param("ssss", $name, $email, $phone, $password);
        if($stmt->execute()){
            $_SESSION['users'] = $name;
        $message = "<p>&#9989;   <!-- ✅ -->Registration successful .$name </p>"."</br>"."<p><button><a href='continue.php'>continue</a></button> </p>";
        }
        }
    }
    else{
        $message = "<p> &#9940 All fields are required</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="container">

        <h2>sign up</h2>
    <form action="signup.php" method="POST"> 
        <input type="text" name="name" placeholder="👥 Enter your name"><br><br><br>
        <input type="email" name="email" placeholder="✉️ Enter your email"><br><br><br>    
        <input type="number" name="phone" placeholder="☎️ Enter your phone number"><br><br><br>
        <input type="password" name="password" placeholder="🔒 Enter your password" id="password"><br>
        <input type="checkbox" onclick="togglePassword()" class="check"> Show Password
        <input type="submit" value="Sign Up"><br><br>
        
    </form>
    <div class="messa"> <?php if(!empty($message)) echo "$message"; ?> </div>
    </div>
</body>
</html>
<script>
        function togglePassword() {
            var pw = document.getElementById("password");
            if (pw.type === "password") {
                pw.type = "text";
            } else {
                pw.type = "password";
            }
        }
    </script>