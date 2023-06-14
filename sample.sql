CREATE DATABASE IF NOT EXISTS message_board;

USE message_board;

CREATE TABLE users (
	id varchar(36) NOT NULL PRIMARY KEY,
  	first_name VARCHAR(50),
  	last_name VARCHAR(50),
  	user_name VARCHAR(50),
  	user_email VARCHAR(50),
  	user_password CHAR(60),
  	create_at DATETIME NOT NULL DEFAULT now()
);

CREATE TABLE media (
  	user_id VARCHAR(36) NOT NULL,
	media_id VARCHAR(36) NOT NULL PRIMARY KEY,
  	media_name VARCHAR(255),
  	media_description TEXT,
  	media_blob LONGBLOB,
  	CONSTRAINT media_fk_user_id FOREIGN KEY (	user_id) REFERENCES users(id),
  	create_at DATETIME NOT NULL DEFAULT now()
);

CREATE TABLE messages (
  	media_id VARCHAR(36) NOT NULL,
  	user_id VARCHAR(36) NOT NULL,
	msg_id VARCHAR(36) NOT NULL PRIMARY KEY,
  	msg_content TEXT,
  	CONSTRAINT msg_fk_media_id FOREIGN KEY (media_id) REFERENCES media(media_id),
  	CONSTRAINT msg_fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
  	create_at DATETIME NOT NULL DEFAULT now()
);

CREATE TABLE friends(
  id VARCHAR(36) NOT NULL PRIMARY KEY DEFAULT uuid(),
  user_id VARCHAR(36) NOT NULL,
  user_friend_id VARCHAR(36) NOT NULL,
  CONSTRAINT frnd_fk_user_id FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT frnd_fk_friend_user_id FOREIGN KEY (user_friend_id) REFERENCES users(id),
  create_at DATETIME NOT NULL DEFAULT now()
);

ALTER TABLE users ALTER id SET DEFAULT uuid();

ALTER TABLE users ADD CONSTRAINT uc_user UNIQUE (user_email, user_name);

ALTER TABLE users MODIFY COLUMN user_password VARCHAR(255);

CREATE TRIGGER generateID()
BEFORE INSERT ON users

ALTER TABLE users ADD user_photo LONGBLOB AFTER user_passwrd;

SELECT CASE WHEN EXISTS (
	SELECT * FROM users WHERE username = '' OR email = ''
) THEN CAST(1 AS BIT)
ELSE CAST(0 AS BIT) END;


SELECT users.user_name FROM users INNER JOIN friends ON users.id=friends.user_friend_id WHERE friends.user_id LIKE "dd4e1bf1";


insert into friends (user_id, user_friend_id) values (select id from users where id like "", select id from users where id like "");

select id from users

INSERT INTO friends(user_id, user_friend_id)
VALUES(
    SELECT
        id
    FROM
        users
    WHERE
        id LIKE '55b049b3%',
    SELECT
        id
    FROM
        users
    WHERE
        id LIKE '186bd41e%'
);



CREATE TABLE profile_picture (
	image_id tinyint(3) not null default '0',
	image_type VARCHAR(25) not null default '',
	image blob not null,
	image_size varchar(25) not null default '',
	image_ctgy varchar(25) not null default '',
	image_name varchar(50) not null default ''
);

