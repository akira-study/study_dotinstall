create database dotinstall_sns_php;
grant all on dotinstall_sns_php.* to dbuser@localhost identified by 'vagrant';
use dotinstall_sns_php

create table users (
id int not null auto_increment primary key,
name varchar(255),
email varchar(255),
password varchar(255),
created datetime,
 modified datetime
);
