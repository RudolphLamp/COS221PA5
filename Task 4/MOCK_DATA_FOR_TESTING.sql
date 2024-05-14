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
INSERT INTO Title (Content_Rating, Review_Rating, Release_Date, Profile_ID, Title_Name, Plot_Summary)
VALUES 
('PG-13', '8.5', '2023-01-01', 1, 'Mystery of the Ancients', 'A thrilling journey into the secrets of an ancient civilization.'),
('R', '7.8', '2022-05-15', 2, 'The Final Stand', 'A gripping tale of bravery and sacrifice in the face of overwhelming odds.'),
('G', '9.0', '2021-03-12', 3, 'The Little Adventurer', 'A charming story of a young child discovering the wonders of the world.'),
('PG', '8.2', '2023-11-25', 4, 'Haunted Holidays', 'A family holiday turns spooky as strange events unfold in a remote cabin.'),
('PG-13', '6.5', '2022-08-30', 5, 'City of Shadows', 'A detective uncovers dark secrets lurking in the shadows of the city.'),
('R', '7.1', '2020-07-19', 6, 'The Last Frontier', 'Survivors in a post-apocalyptic world fight to reclaim their home.'),
('G', '9.5', '2021-12-01', 7, 'Adventures in Toyland', 'Toys come to life and embark on a magical adventure.'),
('PG', '8.3', '2022-02-14', 8, 'Love in Bloom', 'A heartwarming romance that blossoms in a small town.'),
('PG-13', '7.6', '2020-06-21', 9, 'The Lost Expedition', 'Explorers search for a lost civilization in uncharted territory.'),
('R', '6.9', '2023-03-03', 10, 'Dark Waters', 'A chilling thriller set in a mysterious seaside town.'),
('PG-13', '8.4', '2021-04-11', 11, 'Echoes of the Past', 'A historian discovers a diary that leads to an incredible adventure.'),
('PG', '7.9', '2022-09-14', 12, 'Dreamscape', 'A group of friends shares a series of interconnected dreams.'),
('R', '6.8', '2020-11-19', 13, 'Noir City', 'A hard-boiled detective navigates through a city of corruption.'),
('PG-13', '8.1', '2023-07-07', 14, 'Stellar Voyage', 'An epic sci-fi adventure across the galaxy.'),
('G', '9.2', '2021-08-15', 15, 'Fairytale Forest', 'A magical journey through a forest of living fairy tales.'),
('PG', '7.7', '2022-10-31', 16, 'Mystic Manor', 'A haunted house story with unexpected twists and turns.'),
('R', '6.7', '2020-05-23', 17, 'Edge of Darkness', 'A vigilante takes on the criminal underworld.'),
('PG-13', '8.0', '2021-11-22', 18, 'Future Shock', 'A dystopian future where technology controls society.'),
('PG', '7.5', '2023-02-27', 19, 'Holiday Magic', 'A feel-good holiday story about miracles and family.'),
('R', '7.2', '2022-06-18', 20, 'Warzone', 'A war drama depicting the lives of soldiers in combat.'),
('PG-13', '8.6', '2021-01-05', 21, 'Quantum Leap', 'A scientist travels through time to fix historical mistakes.'),
('G', '9.3', '2023-04-17', 22, 'Animal Kingdom', 'A documentary-style film about the lives of wild animals.'),
('PG', '8.4', '2022-08-02', 23, 'Summer Camp', 'A coming-of-age story set in a summer camp.'),
('PG-13', '7.3', '2020-03-29', 24, 'Urban Legends', 'A modern retelling of classic urban legends.'),
('R', '6.4', '2021-12-08', 25, 'The Underworld', 'A gritty crime drama set in the criminal underbelly of a city.'),
('PG-13', '8.7', '2023-06-20', 26, 'Cyber Warriors', 'A team of hackers fights against digital oppression.'),
('G', '9.1', '2021-05-07', 27, 'Ocean Wonders', 'An exploration of the mysteries of the ocean.'),
('PG', '7.8', '2022-11-10', 28, 'The Secret Garden', 'A young girl discovers a hidden garden that changes her life.'),
('R', '6.6', '2020-02-14', 29, 'Revenge', 'A gripping tale of vengeance and redemption.'),
('PG-13', '8.2', '2023-09-26', 30, 'The Time Machine', 'A scientist invents a time machine and explores different eras.'),
('PG', '7.4', '2021-10-13', 31, 'Magic School', 'Students learn magic at a mystical academy.'),
('R', '6.3', '2022-07-15', 32, 'The Assassin', 'A professional assassin questions their line of work.'),
('PG-13', '8.8', '2020-01-22', 33, 'Galactic Rangers', 'Heroes defend the galaxy from an evil empire.'),
('G', '9.4', '2021-06-06', 34, 'Fantasy Island', 'A place where dreams come true and adventures await.'),
('PG', '7.6', '2022-03-20', 35, 'The Lighthouse', 'A mystery set in a remote lighthouse.'),
('R', '6.5', '2023-05-11', 36, 'Undercover', 'An undercover agent infiltrates a drug cartel.'),
('PG-13', '8.3', '2021-09-27', 37, 'Virtual Reality', 'People get lost in a highly realistic virtual world.'),
('PG', '7.1', '2022-12-03', 38, 'Family Ties', 'A drama about the complexities of family relationships.'),
('R', '6.2', '2020-04-09', 39, 'The Escape', 'A prisoner plans a daring escape from a high-security facility.'),
('PG-13', '8.9', '2023-10-16', 40, 'Alien Invasion', 'Earth faces a threat from extraterrestrial forces.'),
('G', '9.2', '2021-02-18', 41, 'Journey to the Stars', 'An inspiring story about space exploration.'),
('PG', '7.9', '2022-05-27', 42, 'The Heirloom', 'A family discovers the secrets of an ancient heirloom.'),
('R', '6.7', '2020-08-01', 43, 'The Vigilante', 'A person takes justice into their own hands.'),
('PG-13', '8.1', '2021-12-19', 44, 'The Portal', 'A portal to another world is discovered.'),
('PG', '7.2', '2022-06-09', 45, 'Back to School', 'Adults return to school and relive their youth.'),
('R', '6.8', '2023-01-28', 46, 'The Conspiracy', 'A journalist uncovers a massive conspiracy.'),
('PG-13', '8.5', '2021-03-23', 47, 'The Chosen One', 'A prophecy about a chosen hero comes true.'),
('G', '9.0', '2022-10-30', 48, 'Wilderness Adventure', 'A survival story in the wild.'),
('PG', '7.4', '2023-04-06', 49, 'The Quest', 'A group embarks on an epic quest.'),
('R', '6.9', '2021-07-25', 50, 'The Heist', 'A heist gone wrong leads to unexpected consequences.');


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
