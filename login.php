<?php
session_start();
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $check = $conn->query("SELECT * FROM user WHERE username = '$username' AND password = '$password'");
    if ($check->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("Location: dash.php"); 
    } else {
        $msg = "Login gagal! Username / password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
          font-family: Arial, sans-serif;
          background-image: url(abs1.jpg);
          display: flex;
          height: 100vh;
          justify-content: center;
          align-items: center;
          background-size: cover;
        }
        .form-box {
          background-color: rgba(255, 255, 255, 0.418); 
          padding: 100px;
          border-radius: 10px;
          box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
          width: 330px;
          height: 10%;
          text-align: center;
          backdrop-filter: blur(20px); 
        }
        form {
          margin-top: -90px;
        }
        input {
          width: 90%;
          padding: 10px;
          margin: 10px 0;
        }
        button {
          width: 100%;
          padding: 10px;
          background-color:rgb(6, 10, 15);
          border: none;
          color: white;
          font-weight: bold;
          cursor: pointer;
        }
        .msg {
          margin-top: 10px;
          color: red;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <form action="" method="POST">
            <h2>Login</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Belum punya akun? <a href="register.php">Daftar</a></p>
            <?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
        </form>
    </div>
</body>
</html>
