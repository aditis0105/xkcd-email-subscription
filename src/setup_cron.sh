#!/bin/bash
# Absolute path to cron.php (replace with your actual path)
CRON_SCRIPT_PATH="/var/www/html/xkcd/src/cron.php"

# Add CRON job to run every 24 hours (at midnight)
CRON_JOB="0 0 * * * php $CRON_SCRIPT_PATH"

# Install the CRON job
(crontab -l 2>/dev/null; echo "$CRON_JOB") | crontab -
echo "CRON job installed! It will run daily at midnight."