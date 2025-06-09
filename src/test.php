<?php
require 'functions.php';

// REPLACE THIS WITH YOUR ACTUAL EMAIL
$test_email = 'aditisharma73821@gmail.com';  // ← Change this!

$code = generateVerificationCode();
$result = sendVerificationEmail($test_email, $code);

echo "Test Results:<br>";
echo "Email sent to: $test_email<br>";
echo "Verification code: $code<br>";
echo "Status: " . ($result ? "SUCCESS" : "FAILED");

// For debugging
echo "<h2>Debug Info</h2>";
echo "<pre>SMTP Server: " . ini_get('SMTP') . "\n";
echo "Port: " . ini_get('smtp_port') . "\n";
echo "From: " . ini_get('sendmail_from') . "</pre>";
?>