-- Populate 'user' table
INSERT INTO user (First_Name, Last_Name, Date_of_Birth, user_password) 
VALUES 
('John', 'Doe', '1990-05-15', 'password123'),
('Alice', 'Smith', '1985-09-20', 'securepass'),
('Michael', 'Johnson', '1988-07-12', 'mysecretpassword'),
('Emily', 'Brown', '1995-03-28', 'p@ssw0rd'),
('David', 'Wilson', '1992-11-10', 'password123'),
('Sophia', 'Lee', '1998-08-18', 'strongpassword');

-- Populate 'user_contact_details' table
INSERT INTO user_contact_details (User_ID, Phone_number, Email_Address) 
VALUES 
(1, '123-456-7890', 'john@example.com'),
(2, '234-567-8901', 'alice@example.com'),
(3, '345-678-9012', 'michael@example.com'),
(4, '456-789-0123', 'emily@example.com'),
(5, '567-890-1234', 'david@example.com'),
(6, '678-901-2345', 'sophia@example.com');

-- Populate 'user_address' table
INSERT INTO user_address (User_ID, street_number, street_name, city, province, postal_code) 
VALUES 
(1, '123', 'Main Street', 'New York', 'NY', '10001'),
(2, '456', 'Oak Avenue', 'Los Angeles', 'CA', '90001'),
(3, '789', 'Elm Street', 'Chicago', 'IL', '60601'),
(4, '1011', 'Pine Road', 'Houston', 'TX', '77001'),
(5, '1213', 'Maple Lane', 'Miami', 'FL', '33101'),
(6, '1415', 'Cedar Boulevard', 'San Francisco', 'CA', '94101');

-- Populate 'profile' table
INSERT INTO profile (Profile_Name, Age, User_ID, Profile_language) 
VALUES 
('John\'s Profile', YEAR(CURDATE()) - YEAR('1990-05-15'), 1, 'English'),
('Alice\'s Profile', YEAR(CURDATE()) - YEAR('1985-09-20'), 2, 'English'),
('Michael\'s Profile', YEAR(CURDATE()) - YEAR('1988-07-12'), 3, 'English'),
('Emily\'s Profile', YEAR(CURDATE()) - YEAR('1995-03-28'), 4, 'English'),
('David\'s Profile', YEAR(CURDATE()) - YEAR('1992-11-10'), 5, 'English'),
('Sophia\'s Profile', YEAR(CURDATE()) - YEAR('1998-08-18'), 6, 'English');

-- Populate 'Title' table
INSERT INTO Title (Content_Rating, Review_Rating, Release_Date) 
VALUES 
('PG-13', '9.3', '1994-09-23'),
('R', '9.2', '1972-03-24'),
('PG-13', '9.0', '2008-07-18'),
('R', '8.9', '1994-10-14'),
('PG-13', '8.8', '1994-07-06'),
('PG', '8.5', '2001-11-16'),
('PG-13', '9.0', '2008-07-18'),
('R', '8.9', '1994-10-14'),
('PG-13', '8.8', '1994-07-06');

INSERT INTO Series (Series_Name, First_Episode, Last_Episode)
VALUES 
('Breaking Bad', '2008-01-20', '2013-09-29'),
('Friends', '1994-09-22', '2004-05-06'),
('Game of Thrones', '2011-04-17', '2019-05-19'),
('Stranger Things', '2016-07-15', '2019-05-19'),
('The Office', '2005-03-24', '2013-05-16'),
('The Simpsons', '1989-12-17', '2019-05-19');


-- Populate 'Season' table
INSERT INTO Season (Season_Name, Title_ID) 
VALUES 
('Season 1', 1),
('Season 1', 2),
('Season 1', 3),
('Season 1', 4),
('Season 1', 5),
('Season 1', 6);



-- Populate 'Episode' table
INSERT INTO Episode (Episode_Name, Duration, Season_ID) 
VALUES 
('Pilot', '00:58:00', 1),
('The One Where Monica Gets a Roommate', '00:22:00', 2),
('Winter Is Coming', '00:58:00', 3),
('Chapter One: The Vanishing of Will Byers', '00:47:00', 4),
('Pilot', '00:22:00', 5),
('Simpsons Roasting on an Open Fire', '00:22:00', 6);

-- Populate 'Movie' table
INSERT INTO Movie (Movie_Name, Duration,Title_ID) 
VALUES 
('The Shawshank Redemption', '02:22:00',7),
('The Godfather', '02:55:00',8),
('The Dark Knight', '02:32:00',9);
