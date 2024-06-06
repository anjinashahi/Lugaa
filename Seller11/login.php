<?php
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require_once("connection.php");

  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate the user's credentials
  $query = "SELECT * FROM seller WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    // Credentials are valid, set session and redirect via JavaScript
    session_start();
    $_SESSION['email'] = $email;
    echo "<script>window.location.replace('staff.php');</script>";
    exit;
  } else {
    // Credentials are invalid, set error message
    $error = "Invalid email or password.";
  }

  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
}

.container {
  max-width: 350px;
  margin: 0 auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

input[type="text"],
input[type="password"],
input[type="submit"] {
  width: 100%;
  padding: 10px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
  border-radius: 5px;
}

input[type="submit"] {
  background-color: #4caf50;
  color: white;
  border: none;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #45a049;
}

.error {
  color: red;
}
</style>
</head>
<body>

<div class="container">
  <h2>Login</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="email">Email</label>
    <input type="text" id="email" name="email" required>

    <label for="password">Password</label>
    <input type="password" id="password" name="password" required>

    <input type="submit" value="Login">
  </form>
  <div class="error"><?php echo $error ?? ''; ?></div>
</div>

<script>
document.querySelector("form").addEventListener("submit", function(event) {
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  if (!email || !password) {
    event.preventDefault();
    alert("Please fill in all fields.");
  }
});
</script>

</body>
</html>
