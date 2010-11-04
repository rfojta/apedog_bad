#!/bin/bash


#checking parameters
if [ -n "${1+x}" ]; then
echo Country name is $1
else
echo Country name is not set ... exiting ..
exit 0
fi
if [ -n "${2+x}" ]; then
echo Country code is $2
else
echo Country code is not set ... exiting ..
exit 0
fi


#inserting row into base db
#mysql -uqwerta -ptesttest -h localhost apedog_base<<EOFMYSQL
#INSERT INTO countries (
		
		#Name ,
		#Code ,
		#Created
		#)
#VALUES (
		#NULL , '$1', '$2', NOW()
       #);
#EOFMYSQL

#making dirs for backuping and images
mkdir backups/_$2
mkdir images/_$2


#creating countries own db
mysql -uqwerta -ptesttest -h localhost <<EOFMYSQL
CREATE DATABASE apedog_$2;
EOFMYSQL

#E="Please create database apedog_$2 and execute actual apedog_new_country.sql"
#echo $E | mail -s “d” krystof1000@gmail.com 
