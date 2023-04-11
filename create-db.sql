CREATE DATABASE IF NOT EXISTS social_media_php;

USE social_media_php;

CREATE TABLE users(
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(128) NOT NULL,
	email VARCHAR(128) NOT NULL,
	birth_date DATE,
	`password` VARCHAR(128) NOT NULL,
	avatar VARCHAR(256),
	cover VARCHAR(256),
	gender VARCHAR(16),
	
	created_at TIMESTAMP DEfAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	PRIMARY KEY(id),
	UNIQUE(email)
);

CREATE table posts(
	post_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	
	content LONGTEXT,
	images TEXT(4096),
	
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	FOREIGN KEY(user_id) REFERENCES users(id),
	PRIMARY KEY(post_id)
);

CREATE table comments(
	comment_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	post_id INT NOT NULL,
	
	content MEDIUMTEXT,
	images TEXT(4096),
	
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	
	PRIMARY KEY(comment_id),
	FOREIGN KEY(post_id) REFERENCES posts(post_id),
	FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE table likes(
	like_id INT NOT NULL AUTO_INCREMENT,
	user_id INT NOT NULL,
	comment_id INT,
	post_id INT,
	
	PRIMARY KEY (like_id),
	FOREIGN KEY (user_id) REFERENCES users(id),
	FOREIGN KEY (comment_id) REFERENCES comments(comment_id),
	FOREIGN KEY (post_id) REFERENCES posts(post_id)
);