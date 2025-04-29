<?php include 'db.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $check = $conn->query("SELECT * FROM user WHERE username = '$username'");
    if ($check->num_rows > 0) {
        $msg = "Username sudah digunakan!";
    } else {
        $conn->query("INSERT INTO user (username, password) VALUES ('$username', '$password')");
        $msg = "Berhasil daftar! Silakan <a href='login.php'>login</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar</title>
    <style>
        body {
  font-family: Arial, sans-serif;
  background-image: url(abs2.webp);
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
  height: 20%;
  text-align: center;
  backdrop-filter: blur(20px); 

form {
  margin-top: -80px;
}

input {
  width: 90%;
  padding: 10px;
  margin: 10px 0;
}

button {
  width: 100%;
  padding: 10px;
  background-color: #0078f8;
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
       
        <form method="POST">
             <h2>Register</h2>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password" placeholder="confirm your password" required>
            <button type="submit">Daftar</button>
            <p>Sudah punya akun? <a href="login.php">Login</a></p>
            <?php if (isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
        </form>
    </div>
</body>
</html>
