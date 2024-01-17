#!/bin/bash

# Stop Apache
sudo systemctl start httpd

# Optimization
sudo php /var/www/html/rv-tampa.com/artisan optimize

# Set Laravel Permissions
sudo chown -R apache:apache /var/www/html/rv-tampa.com
sudo chmod -R 755 /var/www/html/rv-tampa.com/storage