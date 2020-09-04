CREATE DATABASE yeticave;

USE yeticave;

CREATE TABLE category (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	code VARCHAR(20) NOT NULL
);

INSERT INTO category (name, code) VALUES ('Доски и лыжи', 'boards'), ('Крепления', 'attachment'), ('Ботинки', 'boots'), ('Одежда', 'clothing');

CREATE TABLE lot (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  date_start DATETIME NOT NULL,
  title VARCHAR(700) NOT NULL,
  description TEXT NOT NULL,
  path VARCHAR(100) NOT NULL,
  cost INT UNSIGNED NOT NULL,
  date_finish DATETIME NOT NULL,
  rate_step INT UNSIGNED NOT NULL,   
  user_id INT UNSIGNED NOT NULL,
  winner_id INT UNSIGNED,
  category_id INT UNSIGNED	NOT NULL
);

CREATE TABLE rate (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	date TIMESTAMP NOT NULL,
	cost INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  lot_id INT UNSIGNED NOT NULL
);

CREATE TABLE user (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	created_at TIMESTAMP NOT NULL,
  email VARCHAR(100) NOT NULL,
	name CHAR(100) NOT NULL,	
	password CHAR(64) NOT NULL,
	contact VARCHAR(20) NOT NULL
);