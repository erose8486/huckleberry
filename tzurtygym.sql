CREATE TABLE members (
  id INT NOT NULL AUTO_INCREMENT,
  first_name varchar(25) NOT NULL,
  last_name varchar(25) DEFAULT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
);


CREATE TABLE member_days (
  day_id INT NOT NULL AUTO_INCREMENT,
  class_day date NOT NULL,
  member_id int(11) NOT NULL,
  PRIMARY KEY (day_id),
  FOREIGN KEY (member_id) REFERENCES members(id)
);

CREATE TABLE payments (
  payment_id INT NOT NULL AUTO_INCREMENT,
  member_id INT NOT NULL,
  payment_date date NOT NULL,
  payment_amount decimal(10,0) NOT NULL DEFAULT '0',
  PRIMARY KEY (payment_id),
  FOREIGN KEY (member_id) REFERENCES MEMBERS(id)
);