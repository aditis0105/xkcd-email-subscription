<?php
session_start(); // Required for session management
require_once __DIR__ . '/functions.php'; // Include your functions

$message = ""; // To display status messages (e.g., "Code sent!" or "Email verified!")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XKCD Comic Subscription</title>
</head>
<body>
    <h1>Subscribe to XKCD Comics</h1>

    <!-- Status Message -->
    <?php if (!empty($message)): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- ===== EMAIL INPUT FORM ===== -->
    <form method="post">
        <h3>Step 1: Enter Your Email</h3>
        <input type="email" name="email" placeholder="your@email.com" required>
        <button type="submit" id="submit-email">Submit</button>
    </form>

    <!-- ===== VERIFICATION CODE FORM ===== -->
    <form method="post">
        <h3>Step 2: Enter Verification Code</h3>
        <input type="text" name="verification_code" placeholder="123456" maxlength="6" required>
        <button type="submit" id="submit-verification">Verify</button>
    </form>

    <!-- ===== PHP LOGIC ===== -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle email submission (send verification code)
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $code = generateVerificationCode();
            $_SESSION['verification_code'] = $code;
            $_SESSION['email_to_verify'] = $email; // Store email for verification
            sendVerificationEmail($email, $code);
            $message = "Verification code sent to $email!";
        }

        // Handle verification code submission
        elseif (isset($_POST['verification_code'])) {
            $email = $_SESSION['email_to_verify'] ?? '';
            $code = $_POST['verification_code'];
            
            if (verifyCode($email, $code)) {
                registerEmail($email);
                $message = "Email verified! You'll now receive XKCD comics.";
            } else {
                $message = "Invalid code. Please try again.";
            }
        }
    }
    ?>
</body>
</html>