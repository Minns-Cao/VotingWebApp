CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  otp INT NOT NULL,
  active VARCHAR(255) DEFAULT 'no', 
  expired VARCHAR(255) DEFAULT 'no',
  expiretime DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE(email),
  UNIQUE(username)
);

-- tạo trigger thêm giá trị expire
DELIMITER //
CREATE TRIGGER create_expire_value
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
   SET NEW.expiretime = CURRENT_TIMESTAMP + INTERVAL 600 SECOND;
END;//
DELIMITER ;

INSERT INTO users(username,role,email,password,otp)
VALUES('caom900','admin','caom900@gmail.com','123456','999999')

INSERT INTO users(username,role,email,password,otp)
VALUES('user123','user','test123@gmail.com','1234','444444')


-- ======
CREATE TABLE candidates (
  can_id VARCHAR(255) PRIMARY KEY,
  can_name VARCHAR(255) NOT NULL,
  can_avt VARCHAR(255),
  can_desc TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE photos (
  photo_id INT PRIMARY KEY AUTO_INCREMENT,
  can_id INT NOT NULL,
  photo_name VARCHAR(255) NOT NULL,
  FOREIGN KEY (can_id) REFERENCES candidates(can_id),
)

CREATE TABLE votes (
  vote_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  can_id VARCHAR(255) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (can_id) REFERENCES candidates(can_id),
  UNIQUE(user_id, can_id)
);

CREATE TABLE imgCan (
  id INT PRIMARY KEY AUTO_INCREMENT,
  imgName VARCHAR(255),
  can_id VARCHAR(255) NOT NULL,
  isAvt INT,
  FOREIGN KEY (can_id) REFERENCES candidates(can_id),
  UNIQUE(imgName)
)

INSERT INTO votes(user_id, can_id) 
VALUES('10','123')

SELECT A.`vote_id` , B.`username` , A.`can_id` FROM `votes` AS A LEFT JOIN `users` AS B ON B.`id` = A.`user_id` 


SELECT A.`vote_id` , B.`username` , C.can_name FROM `votes` AS A 
LEFT JOIN `users` AS B ON B.`id` = A.`user_id` 
LEFT JOIN `candidates` as C on C.can_id = A.can_id

SELECT can_id, count(*) AS count FROM votes GROUP BY can_id;

-- SELECT * FROM 

SELECT A.can_id, A.can_name, COALESCE(B.count, 0) as votes FROM candidates as A 
LEFT JOIN (SELECT can_id, count(*) AS count FROM votes GROUP BY can_id) as B ON B.can_id = A.can_id
ORDER BY votes DESC