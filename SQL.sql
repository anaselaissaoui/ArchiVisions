
CREATE DATABASE archivision;

USE archivision;

CREATE TABLE member (
  mem_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  mem_cin VARCHAR(255),
  mem_name VARCHAR(255),
  mem_username VARCHAR(255),
  mem_address VARCHAR(255),
  mem_email VARCHAR(255),
  mem_pass VARCHAR(255),
  mem_type VARCHAR(255),
  mem_phone VARCHAR(255),
  mem_birthd DATE,
  mem_penalty INT,
  mem_cr_acc DATE
);
 


CREATE TABLE librarian (
  lib_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  lib_name VARCHAR(255),
  lib_email VARCHAR(255),
  lib_pass VARCHAR(255)
);


CREATE TABLE works (
  work_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  work_title VARCHAR(255),
  work_author VARCHAR(255),
  work_img VARCHAR(255),
  work_state VARCHAR(255),
  work_type VARCHAR(255),
  work_pub_d DATE,
  work_purch_d DATE,
  work_pages INT,
  lib_id INT NOT NULL,
  FOREIGN KEY (lib_id) REFERENCES librarian(lib_id)
);

CREATE TABLE booking (
  book_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  book_date DATE,
  mem_id INT NOT NULL,
  work_id INT NOT NULL,
   FOREIGN KEY (mem_id) REFERENCES member(mem_id),
   FOREIGN KEY (work_id) REFERENCES works(work_id)

);
CREATE TABLE loan (
  loan_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  loan_date DATE,
  book_id INT NOT NULL,
  FOREIGN KEY (book_id) REFERENCES booking(book_id)
);



INSERT INTO works (work_title, work_author, work_img, work_state, work_type, work_pub_d, work_purch_d, work_pages, lib_id)
VALUES 
('The Great Gatsby', 'F. Scott Fitzgerald', './img/The_Great_Gatsby_10.jpg', 'Good condition', 'Book', '1925-04-10', '2022-01-15', 180, 1),
('To Kill a Mockingbird', 'Harper Lee', './img/to_kill_a_mockingbird.jpg', 'New', 'Book', '1960-07-11', '2022-02-22', 324, 1),
('Pride and Prejudice', 'Jane Austen', './img/pride_and_prejudice.jpg', 'Acceptable', 'Book', '1813-01-28', '2022-03-11', 432, 1),
('1984', 'George Orwell', '1984.jpg', './img/Good condition', 'Book', '1949-06-08', '2022-01-01', 328, 1),
('Animal Farm', 'George Orwell', './img/animal_farm.jpg', 'Good condition', 'Book', '1945-08-17', '2022-02-14', 144, 1),
('Brave New World', 'Aldous Huxley', './img/brave_new_world.jpg', 'Acceptable', 'Book', '1932-05-01', '2022-03-09', 288, 1),
('The Catcher in the Rye', 'J.D. Salinger', './img/catcher_in_the_rye.jpg', 'New', 'Book', '1951-07-16', '2022-01-12', 224, 1),
('Lord of the Flies', 'William Golding', './img/lord_of_the_flies.jpg', 'Good condition', 'Book', '1954-09-17', '2022-02-27', 224, 1),

-- creating the event that will run each 10minutes to check the date of the reservation if it passed the 24hours and if so then it will delete the row from my table booking 

CREATE EVENT delete_booking_event
ON SCHEDULE
    EVERY 10 MINUTE
DO
    DELETE FROM booking
    WHERE book_date < DATE_SUB(NOW(), INTERVAL 24 HOUR)
    AND book_status = 'in progress';

-- creating the trigger to update our work to not appera on my page because it's reserved ,
DELIMITER //

CREATE TRIGGER book_work
AFTER INSERT ON booking
FOR EACH ROW
BEGIN
    UPDATE works SET work_dispo = 0 WHERE work_id = NEW.work_id;
END//

DELIMITER ;


