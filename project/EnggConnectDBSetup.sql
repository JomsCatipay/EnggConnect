CREATE DATABASE enggconnecttest;

USE enggconnecttest;

CREATE TABLE Users(
	user_id integer auto_increment,
	username varchar(30) NOT NULL,
	password varchar(255) NOT NULL,
	dept ENUM ('ChE', 'CE', 'CS', 'EEE', 'GE', 'IE', 'ME', 'MMM'),
	snum varchar(10),
	type ENUM ('Contributor', 'Administrator') NOT NULL,
	primary key(user_id)
);

CREATE TABLE Topics(
	topic_id integer auto_increment,
	title varchar(100) NOT NULL,
	poster_id integer,
	details TEXT,

	foreign key (poster_id) references Users(user_id)
		on delete set null
		on update cascade,
	primary key(topic_id)
);

CREATE TABLE Questions(
	q_id integer auto_increment,
	topic_id integer,
	question varchar(255),

	foreign
	primary key(q_id)
);

CREATE USER 'EnggConnect'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT on enggconnecttest.* to 'EnggConnect';
GRANT INSERT on enggconnecttest.* to 'EnggConnect';