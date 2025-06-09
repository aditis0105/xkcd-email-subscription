<?php
session_start();
require_once __DIR__ . '/functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 1: Request unsubscribe (send code)
    if (isset($_POST['unsubscribe_email'])) {
        $email = $_POST['unsubscribe_email'];
        $code = generateVerificationCode();
        $_SESSION['unsubscribe_code'] = $code;
        $_SESSION['email_to_unsubscribe'] = $email;
        sendVerificationEmail($email, $code);
        $message = "Unsubscribe code sent to $email!";
    }
    // Step 2: Verify code and unsubscribe
    elseif (isset($_POST['verification_code'])) {
        $email = $_SESSION['email_to_unsubscribe'] ?? '';
        $code = $_POST['verification_code'];
        if ($code == $_SESSION['unsubscribe_code']) {
            unsubscribeEmail($email);
            $message = "Unsubscribed successfully!";
        } else {
            $message = "Invalid code!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unsubscribe from XKCD</title>
</head>
<body>
    <h1>Unsubscribe</h1>
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Form 1: Email Input -->
    <form method="post">
        <input type="email" name="unsubscribe_email" placeholder="your@email.com" required>
        <button type="submit" id="submit-unsubscribe">Request Unsubscribe</button>
    </form>

    <!-- Form 2: Verification Code -->
    <form method="post">
        <input type="text" name="verification_code" placeholder="123456" maxlength="6" required>
        <button type="submit" id="submit-verification">Confirm Unsubscribe</button>
    </form>
</body>
</html>