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

-- update from here
