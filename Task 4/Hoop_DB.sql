-- create database Hoop_DB;
-- use Hoop_DB;
-- drop database Hoop_DB;



-- language table
create table Available_Language
(
	Language_ID int auto_increment primary key,
	Language_Name varchar(20) not null
	
);


-- table with simple user data,complex and composite get their own tables
create table User_Account
(
	User_ID int auto_increment primary key,
    First_Name varchar(50)not null,
    Last_Name varchar(60) not null,
    Date_of_Birth date not null,
    user_password varchar(100)not null,
    Admin_privileges boolean,
     Email_Address varchar(130),
      constraint user_email unique lower(Email_Address), -- lowercase 
    constraint email_format check (Email_Address like '%@%.%') -- format email someaddress@something.com
);


-- profile table
create table profile_account
(
	Profile_ID int auto_increment primary key,
    Profile_Name varchar(50)NOT NULL,
    
    User_ID int,
    Child_Profile boolean,
	Language_ID int,
    
    foreign key (User_ID) references user_account(User_ID),
	foreign key (Language_ID int) references Available_Language(Language_ID int)
);

-- update from here

create table Content_Rating
(
	Content_Rating_ID int auto_increment primary key,
	Rating varchar(11),
	Child_Safe boolean
);

create table Title
(
	Title_ID int auto_increment primary key,
    Title_Name varchar(100),
    Content_Rating_ID int,
    Review_Rating int(11), 
    Release_Date int(5),
    Plot_Summary varchar(1731),
    Crew varchar(100),
    Image varchar(127),
    Language_ID int,

    foreign key (Content_Rating_ID) references Content_Rating(Content_Rating_ID),
	foreign key (Language_ID int) references Available_Language(Language_ID int)
    
);


-- dubbed_for language table
create table Dubbed_For
(
	Language_ID int ,
    Title_ID int,
    
	foreign key (Language_ID) references Available_Language(Language_ID),
	foreign key (Title_ID) references Title(Title_ID)
	
	
);

-- subtitles_for language table
create table Subtitles_For
(
	Language_ID int,
	Title_ID int,

	foreign key (Language_ID) references Available_Language(Language_ID),
	foreign key (Title_ID) references Title(Title_ID)
	
	
);

create table Series
(
    Title_ID int,
    
    foreign key (Title_ID) references Title(Title_ID)
);


create table Season
(
	-- link to series and title
    Season_ID int auto_increment primary key,  
    Season_Number int(4),
    Season_Name varchar(100),
    Title_ID int,  
    
    foreign key (Title_ID) references Title(Title_ID)

);

create table Episode
(
	-- link to season and title
    Episode_ID int auto_increment primary key,
    Episode_Number int(4),
    Episode_Name varchar(100),
    Duration int(4),
    
    Season_ID int,  
    
    foreign key (Season_ID) references Season(Season_ID)
);

create table Movie
(
	
    Duration int(4),
    Title_ID int,
    
    foreign key (Title_ID) references Title(Title_ID)
);

create table Review
(
	Rating int(2),
    Review_Content varchar(250),
    Title_ID int,
    Profile_ID int,
    
    
    -- foreign keys
     foreign key (Profile_ID) references profile_account(Profile_ID),
     foreign key (Title_ID) references Title(Title_ID)
);

-- update from here

-- watched table
create table Watched
(
	Profile_ID int,
	Title_ID int,
	Watch_Date date,
    
    foreign key (Profile_ID) references Profile_Account(Profile_ID),
    foreign key (Title_ID) references Title(Title_ID)
    
	
);



-- production company table
create table Production_Company
(
	Company_ID int auto_increment primary key,
	Company_Name varchar(20) not null
	
);

-- produced table
create table Produced
(
	Company_ID int,
	Title_ID int,
    
	foreign key (Company_ID) references Production_Company(Company_ID),
	foreign key (Title_ID) references Title(Title_ID)
	
	
);



-- cast table
create table Cast_
(
	Actor_ID int auto_increment primary key,
	Name varchar(40) not null

	-- check relationship
	
	
);

-- stars_in table
create table Stars_In
(
	Actor_ID int,
	Title_ID int,
	Roles varchar(30),

	foreign key (Actor_ID) references Cast_(Actor_ID),
	foreign key (Title_ID) references Title(Title_ID)

	-- check relationship
	
);


-- director table
create table Director
(
	Director_ID int auto_increment primary key,
	Name varchar(40) not null

	-- check relationship
	
	
);

-- directed_by table 
create table Directored_By
(
	Director_ID int,
	Title_ID int,

	foreign key (Director_ID) references Director(Director_ID),
	foreign key (Title_ID) references Title(Title_ID)
	

	-- check relationship
	
	
);

-- genre table
create table Genre
(
	Genre_ID int auto_increment primary key,
	Genra_Name varchar(20) not null

	-- check relationship
	
);

create table Title_Genre
(
	Genre_ID int,
	Title_ID int,
    
    foreign key (Genre_ID) references Genre(Genre_ID),
	foreign key (Title_ID) references Title(Title_ID)
	
    

	-- check relationship
	
);








