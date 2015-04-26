CREATE DATABASE IF NOT EXISTS enggconnecttest;

USE enggconnecttest;

CREATE TABLE IF NOT EXISTS Users(
	user_id integer auto_increment NOT NULL,
	username varchar(30) NOT NULL,
	password varchar(255) NOT NULL,
	dept ENUM ('ChE', 'CE', 'CS', 'EEE', 'GE', 'IE', 'ME', 'MMM'),
	snum varchar(10),
	type ENUM ('Contributor', 'Administrator') NOT NULL,

	unique key(username),
	unique key(snum),
	primary key(user_id)
);

CREATE TABLE IF NOT EXISTS Topics(
	topic_id integer auto_increment NOT NULL,
	poster_id integer,
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	title varchar(100) NOT NULL,
	details TEXT,

	foreign key (poster_id) references Users(user_id)
		on delete set null
		on update cascade,
	primary key(topic_id)
);

CREATE TABLE IF NOT EXISTS Questions(
	q_id integer auto_increment NOT NULL,
	topic_id integer,
	question varchar(255),

	foreign key(topic_id) references Topics(topic_id)
		on delete cascade
		on update cascade,
	primary key(q_id)
);

CREATE TABLE IF NOT EXISTS Answers(
	a_id integer auto_increment NOT NULL,
	q_id integer,
	answer varchar(255) ,
	vote_count integer,

	foreign key (q_id) references Questions(q_id) 
		on delete cascade 
		on update cascade,
	primary key(a_id)
);

CREATE TABLE IF NOT EXISTS Posts(
	p_id integer auto_increment NOT NULL,
	poster_id integer,
	answer_id integer,
	question_id integer,
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	explanation TEXT,

	foreign key (poster_id) references Users(user_id)
		on delete set null
		on update cascade,
	foreign key (answer_id) references Answers(a_id)
		on delete cascade
		on update cascade,
	foreign key (question_id) references Questions(q_id) 
		on delete cascade 
		on update cascade,
	primary key(p_id)
);

CREATE TABLE IF NOT EXISTS Replies(
	r_id integer auto_increment NOT NULL,
	p_id integer,
	poster_name varchar(30),
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	reply TEXT,

	foreign key (poster_name) references Users(username)
		on delete set null
		on update cascade,
	foreign key (p_id) references Posts(p_id)
		on delete cascade
		on update cascade,
    primary key(r_id)
);

CREATE TABLE IF NOT EXISTS ReportedPosts(
	rep_id integer auto_increment NOT NULL,
	post_id integer,
	reporter_id integer,
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	foreign key (post_id) references Posts(p_id)
		on delete cascade
		on update cascade,
	foreign key (reporter_id) references Users(user_id)
		on delete set null
		on update cascade,
	primary key(rep_id)
);


CREATE TABLE IF NOT EXISTS ReportedReplies(
	rep_id integer auto_increment NOT NULL,
	reply_id integer,
	reporter_id integer,
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

	foreign key (reply_id) references Replies(r_id)
		on delete cascade
		on update cascade,
	foreign key (reporter_id) references Users(user_id)
		on delete set null
		on update cascade,
	primary key(rep_id)
);

CREATE TABLE IF NOT EXISTS UserQueue(
	u_id integer,
	action ENUM ('Upgrade', 'Downgrade'),
	date_of_post TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	vote_count integer,

	foreign key (u_id) references Users(user_id)
		on delete cascade
		on update cascade,
	primary key(u_id)
);

CREATE TABLE IF NOT EXISTS QueuePosts(
	admin_id integer,
	pawn_id integer,

	foreign key (admin_id) references Users(user_id)
		on delete cascade
		on update cascade,
	foreign key (pawn_id) references UserQueue(u_id)
		on delete cascade
		on update cascade,
	primary key(admin_id, pawn_id)
);

CREATE USER 'EnggConnect'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT on enggconnecttest.* to 'EnggConnect'@'localhost';
GRANT INSERT on enggconnecttest.* to 'EnggConnect'@'localhost';

INSERT INTO users ('username', 'password', 'type') VALUES ("admin", "password", 'Administrator');