<?php
require 'functions.php';

$test_email = 'your@test-email.com';
$code = generateVerificationCode();

if (sendVerificationEmail($test_email, $code)) {
    echo "System working! Check mail.log for details";
    echo "<pre>".file_get_contents(__DIR__.'/mail.log')."</pre>";
} else {
    echo "Failed. Check sendmail.log";
}
?>