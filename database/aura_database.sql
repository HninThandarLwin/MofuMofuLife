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
    admin_user init data
*******************
*/
INSERT INTO users (name, email, password, point) VALUES 
("Chaw", 
"chaw@test.com", 
"$2y$12$ZOIaE8fIIeVfSCUTPzJZC.82eDQ7vjEbBf/gJrFnEjiDXNknnhbNy",  /* chaw346 */
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Yamin", 
"yamin@test.com", 
" $2y$12$J.aLnH8cjIf.mPzfnAfkG.vuWbub7hshXVDPfhhozz714YdvnfwAC", /* yamin207 */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Sint", 
"sint@test.com", 
"$2y$12$aX5sDpeiv24g1sLkx/9vveSIzzRP1DAapUojhET6Vr1MHoXO7hb/q", /* sint092 */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Enn", 
"enn@test.com", 
"$2y$12$dsE.gfH4kcSFVNMHSTx8XeWbrUWr1t8R7YsCc2oOfxd8UCu1sEfia", /* enn145 */ 
5000);

INSERT INTO users (name, email, password, point) VALUES 
("Hnin", 
"hnin@test.com", 
"$2y$12$rkAMIXMykTtSXilZeCkOd.jMA8DrL/zj4tcs2.yKvMk9sbG.93UKC", /* hnin477 */ 
5000);

commit;
