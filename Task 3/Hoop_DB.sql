-- create database Hoop_DB;
-- use Hoop_DB;
-- drop database Hoop_DB;


-- table with simple user data,complex and composite get their own tables
create table user
(
	User_ID int auto_increment primary key,
    First_Name varchar(50)not null,
    Last_Name varchar(60) not null,
    Date_of_Birth date not null,
    user_password varchar(100)not null
);

-- user contact details
create table user_contact_details
(
	User_ID int,
    Phone_number varchar(12),
    Email_Address varchar(130),
    foreign key (User_ID) references user(User_ID),
    
    -- constraints
    constraint user_phone_number unique (Phone_number), -- no repeats
    constraint phone_number_format check (Phone_number like '___-___-____'), -- format phone number 012-345-6789
    
    constraint user_email unique lower(Email_Address), -- lowercase 
    constraint email_format check (Email_Address like '%@%.%') -- format email someaddress@something.com
);

-- user address
create table user_address
(
    User_ID int,
    street_number varchar(4),
    street_name varchar(60),
    city varchar(50),
    province varchar(50),
    postal_code varchar(20),
    foreign key (User_ID) references user(User_ID)

);

-- profile table
create table profile
(
	Profile_ID int auto_increment primary key,
    Profile_Name varchar(50),
    Age int, -- derive from dob
    User_ID int,
    Profile_language varchar(50),
    
    foreign key (User_ID) references user(User_ID)
);

create table Title
(
	Title_ID int auto_increment primary key,
    Content_Rating varchar(10),
    Review_Rating varchar(5), 
    Release_Date date
);

create table Series
(
    Title_ID int,
	Series_Name varchar(100),
    First_Episode date, -- would year make more sense?
    Last_Episode date,
    
    
    foreign key (Title_ID) references Title(Title_ID)
);


create table Season
(
	-- link to series and title
    Season_ID int auto_increment primary key,  
    Season_Name varchar(100),
    Title_ID int,  
    
    foreign key (Title_ID) references Title(Title_ID)

);

create table Episode
(
	-- link to season and title
    Episode_ID int auto_increment primary key,
    Episode_Name varchar(100),
    Duration time,
    
    Season_ID int,  
    
    foreign key (Season_ID) references Season(Season_ID)
);

create table Movie
(
	Movie_Name varchar(100),
    Duration time,
    Title_ID int,
    
    foreign key (Title_ID) references Title(Title_ID)
);
-- update from here

-- language table
create table language
(
	Language_ID int auto_increment primary key,
	Language_Name varchar(20) not null
	
);

-- production company table
create table production_company
(
	Company_ID int auto_increment primary key,
	Company_Name varchar(20) not null
	
);

-- crew table
create table crew
(
	Crew_ID int auto_increment primary key,
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

	--check relationship
	
);

create table cast
(
	Actor_ID int auto_increment primary key,
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

	--check relationship
	
	
);

create table director
(
	Director_ID int auto_increment primary key,
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

	--check relationship
	
	
);

create table genre
(
	Genra_ID int auto_increment primary key,
	Genra_Name varchar(20) not null

	--check relationship
	
);

-- create table title
-- (
-- 	Genra_ID int auto_increment primary key,
-- 	Genra_Name varchar(20) not null

-- 	--check relationship
	
-- );






