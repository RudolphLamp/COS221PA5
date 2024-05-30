# NOTHING BUT HOOPS COS221 PA5

![Project Logo](Task5/logo/hoop_logo.png)

## Team Members

| Name                          | Email Address               |
|-------------------------------|-----------------------------|
| Rudolph Lamprecht             | u20598425@tuks.co.za        |
| Arnaud Zander Strydom         | U23536013@tuks.co.za        |
| Zainab Abdulrasaq             | u22566202@tuks.co.za        |
| Tshireletso Ramatsobane Sebake| u22636022@tuks.co.za        |
| Samkelekile Ndevu             | u21593681@tuks.co.za        |
| Christopher Katranas          | U19155853@tuks.co.za        |
| Paballo Diyase                | u23528142@tuks.co.za        |

## Project Description

For our COS221 module, we were tasked with creating a large database and developing a web application to manage and update it. 
The project involved designing a streaming service from the ground up, featuring both admin and normal user functionalities. 
Admin users have the ability to manage content and user data, while normal users can interact with the streaming service to access and enjoy the content.

## Installation

Installations and requirements.
To run the project, you need to have a web browser installed as it uses phpMyAdmin on Wheatly and the web app is also run on Wheatly. A registered username and password is required to accsess the web app.

If you want to run it locally a few extra steps are required.
You need to install XAMPP and change the file paths to use the files on your local machine in your specified XAMPP execution folder .

**1.** Install XAMPP:

Download and install XAMPP from https://www.apachefriends.org/index.html.
Start the Apache and MySQL modules in the XAMPP Control Panel.

**2.** Set up phpMyAdmin:

Open your browser and go to http://localhost/phpmyadmin.
Create a new database for the project.

**3.** Copy Website Files:

Clone the repository:
```sh
git clone https://github.com/RudolphLamp/COS221PA5.git
```

Copy the website files (Task5/final dir) to the htdocs directory of your XAMPP installation (usually located at C:\xampp\htdocs on Windows).

**4.** Configure the API:

Navigate to the directory where you copied the website files.
Open all the files in a code editor like VS CODE.
Update all the file paths to your specific XAMPP file where the downloaded files are stored.
You need to specify the exact paths for each file.
Open the config.php file located in the api directory.
Update the database connection settings in api.php to match your local phpMyAdmin database configuration.

**5.** Run the Web Server:
Start the Apache server from the XAMPP Control Panel.
Open your browser and go to http://localhost/your-repo (replace your-repo with the directory name where you copied the website files).

## Task Allocation

| Student Number  | Name                           | Tasks           |
|-----------------|--------------------------------|-----------------|
| U23536013       | Arnaud Zander Strydom          | Task 5,6,7,8    |
| u22566202       | Zainab Abdulrasaq              | Task 2,4,5    |
| u22636022       | Tshireletso Ramatsobane Sebake | Task 2,3        |
| u21593681       | Samkelekile Ndevu              | Task 5,6        |
| U19155853       | Christopher Katranas           | Task 2,4,6,8    |
| u23528142       | Paballo Diyase                 | Task 1,2,4,5    |
| u20598425       | Rudolph Lamprecht              | Task 5,6,8      |
