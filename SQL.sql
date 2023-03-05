
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
('The Great Gatsby', 'F. Scott Fitzgerald', 'great_gatsby.jpg', 'Good condition', 'Book', '1925-04-10', '2022-01-15', 180, 1),
('To Kill a Mockingbird', 'Harper Lee', 'to_kill_a_mockingbird.jpg', 'New', 'Book', '1960-07-11', '2022-02-22', 324, 1),
('Pride and Prejudice', 'Jane Austen', 'pride_and_prejudice.jpg', 'Acceptable', 'Book', '1813-01-28', '2022-03-11', 432, 1),
('1984', 'George Orwell', '1984.jpg', 'Good condition', 'Book', '1949-06-08', '2022-01-01', 328, 1),
('Animal Farm', 'George Orwell', 'animal_farm.jpg', 'Good condition', 'Book', '1945-08-17', '2022-02-14', 144, 1),
('Brave New World', 'Aldous Huxley', 'brave_new_world.jpg', 'Acceptable', 'Book', '1932-05-01', '2022-03-09', 288, 1),
('The Catcher in the Rye', 'J.D. Salinger', 'catcher_in_the_rye.jpg', 'New', 'Book', '1951-07-16', '2022-01-12', 224, 1),
('Lord of the Flies', 'William Golding', 'lord_of_the_flies.jpg', 'Good condition', 'Book', '1954-09-17', '2022-02-27', 224, 1),
('Of Mice and Men', 'John Steinbeck', 'of_mice_and_men.jpg', 'Acceptable', 'Book', '1937-07-07', '2022-03-06', 112, 1),
('The Outsiders', 'S.E. Hinton', 'the_outsiders.jpg', 'Good condition', 'Book', '1967-04-24', '2022-01-29', 192, 1),
("The Lord of the Rings", "J.R.R. Tolkien", "https://images-na.ssl-images-amazon.com/images/I/51SOFvoWttL._SX331_BO1,204,203,200_.jpg", "New", "Book", "1954-07-29", "2022-02-15", 1178, 1),
("Invisible Man", "Ralph Ellison", "https://images-na.ssl-images-amazon.com/images/I/51YqBCzgFwL._SX329_BO1,204,203,200_.jpg", "Assez usé", "Book", "1952-04-14", "2022-03-01", 608, 1);
