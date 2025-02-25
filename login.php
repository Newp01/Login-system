<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user && $user["account_activation_hash"] === null) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: index.php");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <--- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> --->
    <link rel="stylesheet" href="bootstrap/bootstrap.css">
</head>
<body>
    
    <h1>Login</h1>
    
    <?php if ($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    
    <form method="post">
        <div class="col-sm-9">
            <div class="row mb-3">
                <label for="email">email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" id="email value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>
                <div class="row mb-3">
                    <div class="col-sm-6">
                        <label for="password">Password</label>
                       
                    <input type="password" name="password" id="password">
                </div>
            </div>
        </div>
        <button>Log in</button>
    </form>

    <a href="forgot-password.php">Forgot password?</a>
    
</body>
</html>








