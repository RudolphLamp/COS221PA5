-- create database Hoop_DB;
-- use Hoop_DB;
-- drop Hoop_DB


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
    
    constraint user_email unique LOWER(Email_Address),
    CONSTRAINT email_format CHECK (Email_Address LIKE '%@%.%') -- format email someaddress@something.com
);

-- user address
create table user_address
(
    user_id int,
    street_number varchar(4),
    street_name varchar(60),
    city varchar(50),
    province varchar(50),
    postal_code varchar(20),
    foreign key (user_id) REFERENCES user(user_id)

);

