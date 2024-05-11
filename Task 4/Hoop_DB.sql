-- create database Hoop_DB;
-- use Hoop_DB;
-- drop database Hoop_DB;


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
    
    foreign key (User_ID) references user_account(User_ID)
);

-- update from here

create table Title
(
	Title_ID int auto_increment primary key,
    Content_Rating varchar(10),
    Review_Rating varchar(5), 
    Release_Date date,
    Profile_ID int,
    Title_Name varchar(100),
    Plot_Summary varchar(1000),
    
    foreign key (Profile_ID) references profile_account(Profile_ID)
    
);

create table Series
(
    Title_ID int,
	
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
	
    Duration time,
    Title_ID int,
    
    foreign key (Title_ID) references Title(Title_ID)
);

create table Review
(
	Rating varchar(10),
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
    
    foreign key (Profile_ID) references Profile_Account(Profile_ID),
    foreign key (Title_ID) references Title(Title_ID)
    
	
);



-- language table
create table Available_Language
(
	Language_ID int auto_increment primary key,
	Language_Name varchar(20) not null
	
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



-- crew table
create table Crew
(
	Crew_ID int auto_increment primary key,
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

	-- check relationship
	
);

-- worked_on table
create table Worked_On
(
	Crew_ID int,
	Title_ID int auto_increment,
	Job varchar(30),

	foreign key (Crew_ID) references Crew(Crew_ID),
	foreign key (Title_ID) references Title(Title_ID)

	-- check relationship
	
);

-- cast table
create table Cast_
(
	Actor_ID int auto_increment primary key,
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

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
	First_Name varchar(20) not null,
	Last_Name varchar(20) not null

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








