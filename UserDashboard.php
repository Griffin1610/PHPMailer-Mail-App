<?php
session_start();
//checks if startTime is set
if(!isset($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time();}

//Calculating time spent in session
$elapsedTime = time() - $_SESSION['startTime'];

//Convert time to hours then minutes then seconds
$hours = floor($elapsedTime / 3600);
$minutes = floor(($elapsedTime % 3600) / 60);
$seconds = $elapsedTime % 60; 
?>

<html>
    <head>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['returningUser']); ?></h1>
        <link rel="stylesheet" href="style.css">
        <h3>Send an Email</h3>
    </head>
    <body>
    <form action="" method="POST" name="Form1">
        <label for="toEmail">Recipient Email:</label><br>
        <input type="email" id="toEmail" name="toEmail" required><br><br>
        <label for="subject">Subject:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="5" cols="30" required></textarea><br><br>
        <button type="submit" name="sendEmail">Send Email</button>
    </form>
    <form action="" name="Form2">
        <button type="submit" name="logout">Logout</button>
    </form>    
        <p>Time Active (refresh to update): 
            <?php printf('%02d:%02d:%02d', $hours, $minutes, $seconds); ?>
        </p>
    </body>
</html>

<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require __DIR__ . '/vendor/autoload.php';


//end session on user input
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: UserRegistration.html");
    exit; }

//send email on user input
if(isset($_POST['sendEmail'])) {
    $toEmail = $_POST['toEmail'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $mail = new PhpMailer(true);
    try {
        // **** MY LOCAL SMTP SERVER. THIS MUST BE CHANGED TO RUN ON OTHER DEVICES ****
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'griffinpolly@gmail.com'; //my email
        $mail->Password = 'jmpr cwlv yxqx feyp'; //my App Password (16 digit google Passkey)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //send content of email
        $mail->setFrom('griffinpolly@gmail.com', 'Your Name');
        $mail->addAddress($toEmail);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = nl2br(htmlspecialchars($message));
        $mail->send();
        echo "<p>Email sent successfully to $toEmail!</p>";} 
    catch (Exception $e) {
        echo "<p>Failed to send email. Check SMTP settings";
    }
}
?>
