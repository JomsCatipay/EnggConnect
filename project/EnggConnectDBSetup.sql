CREATE DATABASE enggconnecttest;

USE enggconnecttest;

CREATE TABLE Users(
	user_id integer auto_increment,
	username varchar(30),
	password varchar(30),
	primary key(user_id)
);

CREATE TABLE Posts(
	post_id integer auto_increment,
	post varchar(250),
	primary key(post_id)
);

CREATE USER 'EnggConnect'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT on enggconnecttest.* to 'EnggConnect';
GRANT INSERT on enggconnecttest.* to 'EnggConnect';