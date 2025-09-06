<?php
//start session, allows for timer use
session_start();

// **** CONNECT TO DATABSE, WILL ONLY WORK ON XXAMP LOCALHOST AS ROOT ****
$PollyUserDB = new mysqli('localhost', 'root', '', 'PollyUserDB');


//new user registration
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $PollyUserDB->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    //Encrypt User Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $check_user = $PollyUserDB->prepare("SELECT username FROM users WHERE username = ?");
    $check_user->bind_param("s", $username);
    $check_user->execute();
    $check_user->store_result();

    if ($check_user->num_rows > 0) {
        echo "User already exists. <a href='UserRegistration.html'>Login here</a";
        $check_user->close();
        exit;
    }
    $check_user->close();

    //insert user infor into db using sql querey
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $PollyUserDB->prepare($sql);
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        echo "Registration successful! <a href='UserRegistration.html'>Return to Login here</a>";
    } 
    else {
        echo "Error registering user";
    }
    $stmt->close();

    }

//existing user login
if (isset($_POST['returningUser']) && isset($_POST['returningPassword'])) {
    $ReturningUsername = $PollyUserDB->real_escape_string($_POST['returningUser']);
    $ReturningPassword = $_POST['returningPassword'];

    //sql querey to check user in db
    $stmt = $PollyUserDB->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $ReturningUsername);
    $stmt->execute();
    //store results and check validity
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        if (password_verify($ReturningPassword, $hashed_password)) {
            $_SESSION['returningUser'] = $ReturningUsername;
            header("Location: UserDashboard.php");
            exit;
        } else {
            echo "Invalid password. Please try again. <a href='UserRegistration.html'>Return to Login here</a>";
        }
    } else {
        echo "No account found with that username.";
    }
    $stmt->close();
}

// Close the connection
$PollyUserDB->close();
?>
