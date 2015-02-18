CREATE DATABASE EnggConnectTest;

CREATE TABLE Users(
	user_id integer auto_increment,
	username varchar(30),
	password varchar(30),
	primary key(username)
);

CREATE TABLE Posts(
	post_id integer auto_increment,
	post varchar(250).
	primary key(post_id)
);