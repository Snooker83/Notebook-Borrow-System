CREATE TABLE users(

id INT AUTO_INCREMENT PRIMARY KEY,

first_name VARCHAR(100),

last_name VARCHAR(100),

student_id VARCHAR(10) UNIQUE,

phone VARCHAR(10),

email VARCHAR(150) UNIQUE,

password VARCHAR(255),

is_verified TINYINT(1) DEFAULT 0,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE email_otp(

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT,

otp CHAR(6),

is_used TINYINT(1) DEFAULT 0,

created_at DATETIME,

expires_at DATETIME,

FOREIGN KEY(user_id) REFERENCES users(id)

);

CREATE TABLE admins(

id INT AUTO_INCREMENT PRIMARY KEY,

username VARCHAR(100),

password VARCHAR(255)

);

CREATE TABLE notebooks(

id INT AUTO_INCREMENT PRIMARY KEY,

name VARCHAR(100),

spec TEXT,

image VARCHAR(255),

status ENUM('Available','Pending','Borrowed')
DEFAULT 'Available'

);

CREATE TABLE transactions(

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT,

notebook_id INT,

borrow_time DATETIME,

return_time DATETIME NULL,

status ENUM('Pending','Borrowed','Returned')
DEFAULT 'Pending',

approved_by INT NULL,

FOREIGN KEY(user_id) REFERENCES users(id),

FOREIGN KEY(notebook_id) REFERENCES notebooks(id),

FOREIGN KEY(approved_by) REFERENCES admins(id)

);