CREATE TABLE carts (username CHAR(50), id INTEGER, quantity INTEGER, PRIMARY KEY(username, id));
CREATE TABLE users (username CHAR(50) PRIMARY KEY, email CHAR(254), password VARCHAR(250), full_name VARCHAR(100), birthday DATE, gender VARCHAR(10));
INSERT INTO carts(username, id, quantity) values('bach123',1,10);
