CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT, name varchar(100) NOT NULL, content varchar(1000) NOT NULL, image varchar(1000) NOT NULL, price integer not null);
INSERT INTO product (name, content, image, price) VALUES ('shoes', 'shoes size 27', 'https://media.decathlon.in/207375/soft-140-summer-men-s-active-walking-shoes-black-white.jpg',60);
INSERT INTO product (name, content, image, price) VALUES ('T-shirt', 'T-shirt size 27','https://www.sunspel.com/media/catalog/product/cache/1/image/9df78eab33525d08d6e5fb8d27136e95/4/0/4001_102_5_3.jpg',70);
INSERT INTO product (name, content, image, price) VALUES ('virgin killer', 'virgin killer size 27','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRniBC91Ouwk5FVChvDfkWay1Z_yAWVOxp_y5grhj9ym1xooMGM',80);
CREATE TABLE users (username CHAR(50) PRIMARY KEY, email CHAR(254), password VARCHAR(250), full_name VARCHAR(100), birthday DATE, gender VARCHAR(10));
CREATE TABLE carts (username CHAR(50), id INTEGER, quantity INTEGER, PRIMARY KEY(username, id));
CREATE TABLE users (username CHAR(50) PRIMARY KEY, email CHAR(254), password VARCHAR(250), full_name VARCHAR(100), birthday DATE, gender VARCHAR(10));
INSERT INTO carts(username, id, quantity) values('bach123',1,10);
