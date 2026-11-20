DROP DATABASE IF EXISTS AuraDev;
CREATE DATABASE AuraDev;

Use AuraDev;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
id INT AUTO_INCREMENT,
name VARCHAR(255) NOT Null,
email VARCHAR(100) Unique,
password VARCHAR(255) NOT NULL,
point INT DEFAULT 0,
PRIMARY KEY (id)
);

DROP TABLE IF EXISTS pets;
CREATE TABLE pets(
id INT AUTO_INCREMENT,
user_id INT NOT NULL,
type VARCHAR(50) NOT NULL,
hp INT DEFAULT 100 CHECK (hp BETWEEN 0 AND 100),
level INT DEFAULT 1,
is_selected BOOLEAN DEFAULT FALSE,
adopt_date DATE DEFAULT (CURRENT_DATE),
last_hp_update DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
FOREIGN KEY (user_id) REFERENCES users(id)
);

DROP TABLE IF EXISTS tasks;
CREATE TABLE tasks(
id INT AUTO_INCREMENT,
user_id INT NOT NULL,
title VARCHAR(100) NOT NULL,
type ENUM('schedule','todo') NOT NULL,
description TEXT,
status ENUM('pending','completed') DEFAULT 'pending',
start_time DATETIME NULL,
end_time DATETIME NULL,
rewarded BOOLEAN DEFAULT FALSE,
PRIMARY KEY (id),
FOREIGN KEY (user_id) REFERENCES users(id)
);


/* ****************
    user init data
*******************
*/
INSERT INTO users (name, email, password, point) VALUES 
("Chaw", 
"chaw@test.com", 
"$2y$12$tuPLxeKR9/ozFr4LNkjQPujBSlDwPytgY3.015dfLx3nZZgeIStHO",  /* chaw */
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Yamin", 
"yamin@test.com", 
"$2y$12$tYEA0m7n3cJtVnh5C.TL7OXJCpu/rgeD332G1e4i2sv5695.eLyy6", /* yamin */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Sint", 
"sint@test.com", 
"$2y$12$I.xmVnIgPlwbvQSlnoyXEOzlrMDXHjTpMlZMcJb1L964s/mait9VW", /* sint */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Enn", 
"enn@test.com", 
"$2y$12$lG01v5uCIWhsNGg4hrZq/uNZXHrg2KeAP2ZJwryyMtGcxUAGcPmSG", /* enn */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Hnin", 
"hnin@test.com", 
"$2y$12$4o2.a3I3vjxO9DBwdRWxHuP9kbpbFDNdOz42ieklbtetL145sGZQW", /* hnin */ 
5000);

/* ****************
    pets init data
*******************
*/

INSERT INTO pets (user_id, type, level, is_selected) VALUES 
(1, 
"hamster", 
2,
true);

INSERT INTO pets (user_id, type, level) VALUES 
(1, 
"cat", 
1);

INSERT INTO pets (user_id, type, level, is_selected) VALUES 
(2, 
"dog", 
2,
true);

INSERT INTO pets (user_id, type, level, is_selected) VALUES 
(3, 
"cat", 
2,
true);

INSERT INTO pets (user_id, type, level, is_selected) VALUES 
(4, 
"cat", 
2,
true);

INSERT INTO pets (user_id, type, level, is_selected) VALUES 
(5, 
"hamster", 
3,
true);

/* ****************
    tasks init data
*******************
*/
INSERT INTO tasks (user_id, title, type, description, status, start_time, end_time) VALUES 
(1,
"BackEnd",
"todo",
"プロジェクトのベックエンド",
"pending",
'2026-5-22',
'2026-6-25'
);

INSERT INTO tasks (user_id, title, type, description, status, start_time, end_time) VALUES 
(2,
"FrontEnd",
"todo",
"プロジェクトのフロントエンド",
"pending",
'2026-5-22',
'2026-6-25'
);

INSERT INTO tasks (user_id, title, type, description, status) VALUES 
(3,
"test1",
"todo",
"testing",
"pending"
);

INSERT INTO tasks (user_id, title, type, description, status, start_time, end_time) VALUES 
(5,
"testSK",
"schedule",
"schedule Test",
"pending",
'2026-06-12 10:30:00',
'2026-06-12 12:30:00'
);

commit;
