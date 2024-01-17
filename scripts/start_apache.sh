#!/bin/bash

# Stop Apache
sudo systemctl start httpd

# Optimization
sudo php /var/www/html/rv-tampa.com/artisan optimize

# Set Laravel Permissions
sudo chown -R apache:apache /var/www/html/rv-tampa.com
sudo chmod -R 755 /var/www/html/rv-tampa.com/storage


#Installing VirtualHost if needed

# Define variables
domain="rv-tampa.com"
documentRoot="/var/www/html/$domain/public"
logDirectory="/var/log/httpd/$domain"
virtualHostFile="/etc/httpd/conf.d/$domain.conf"

# Check if the virtual host already exists
if [ -e "$virtualHostFile" ]; then
    echo "Virtual host for $domain already exists. Exiting."
    exit 1
fi

# Create document root and log directory
sudo mkdir -p $documentRoot
sudo mkdir -p $logDirectory

# Create a virtual host configuration file
sudo tee $virtualHostFile > /dev/null <<EOL
<VirtualHost *:80>
    ServerAdmin admin@ciruxdigital.com
    ServerName $domain
    ServerAlias www.$domain
    DocumentRoot $documentRoot

    <Directory "$documentRoot">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    <IfModule mod_rewrite.c>
        <Directory "/var/www/html/public">
            RewriteEngine On
            RewriteBase /
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)$ index.php/$1 [L]
        </Directory>
    </IfModule>
</VirtualHost>
EOL

echo "Virtual host configuration for $domain is complete."