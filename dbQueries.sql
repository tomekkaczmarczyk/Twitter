CREATE DATABASE twitter;

CREATE TABLE users (
  id              INT          NOT NULL AUTO_INCREMENT,
  email           VARCHAR(255) NOT NULL UNIQUE,
  hashed_password VARCHAR(255),
  description     TEXT,
  is_active       INT,
  PRIMARY KEY (id)
);

CREATE TABLE tweets (
  id            INT NOT NULL AUTO_INCREMENT,
  content       VARCHAR(140),
  user_id       INT,
  creation_date DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE comments (
  id            INT NOT NULL AUTO_INCREMENT,
  content       VARCHAR(60),
  user_id       INT NOT NULL,
  tweet_id      INT NOT NULL,
  creation_date DATETIME,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users (id),
  FOREIGN KEY (tweet_id) REFERENCES tweets (id)
);

CREATE TABLE messages (
  id            INT NOT NULL AUTO_INCREMENT,
  content       TEXT,
  sender_id     INT NOT NULL,
  addresser_id  INT NOT NULL,
  if_read       INT,
  creation_date DATETIME;
PRIMARY KEY (id),
FOREIGN KEY (sender_id) REFERENCES users(id),
FOREIGN KEY (addresser_id) REFERENCES users(id)
);

ALTER DATABASE twitter
CHARACTER SET utf8
COLLATE utf8_polish_ci;
ALTER TABLE users
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_polish_ci;
ALTER TABLE tweets
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_polish_ci;
ALTER TABLE comments
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_polish_ci;
ALTER TABLE messages
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_polish_ci;
