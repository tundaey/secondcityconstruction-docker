#!/usr/bin/env bash
#set -m
#set -e
#mysqld_safe &
#sleep 10
#mysql -u website -p
echo "Setting up initial data..."
#mysql -u root -e "CREATE DATABASE IF NOT EXISTS cms"
#mysql -u website -pSfygBjmhyJIqOSl7 -h 192.168.99.100 -e "CREATE USER 'cms_admin'@'mysql' IDENTIFIED BY 'vIX0C5pRBmAakAhu'"
#echo "Created user..."
#mysql -u website -pSfygBjmhyJIqOSl7 -h 192.168.99.100 -e "GRANT ALL ON cms.* to 'cms_admin'@'mysql' 
#IDENTIFIED BY 'vIX0C5pRBmAakAhu'"
#echo "granted access"
#mysql -u website -pSfygBjmhyJIqOSl7 -h 192.168.99.100 -e "FLUSH PRIVILEGES"
# Wait for the database service to start up.
#echo "Waiting for DB to start up..."  
#docker exec db mysqladmin --silent --wait=30 -uusers_service -p123 ping || exit 1
# Run the setup script.
#echo "Setting up initial data..."  
#docker exec -i db mysql -ucms_admin -pvIX0C5pRBmAakAhu cms < cms.sql  
#fg