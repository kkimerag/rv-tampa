#!/bin/bash
sudo su
cd /var/app/current
php artisan optimize
echo "Hello from AWS hook" >> 'test.txt'