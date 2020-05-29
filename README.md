# ![Let's Ride Logo](LetsRide/images/logo-small.png) Let's Ride
Let's Ride is an on-demand Bay Area ride sharing service for the Web. Our features include:
* Real-time location tracking
* Automated pairing system to closest Driver
* Ability to cancel before pickup
* Dynamic map that changes depending on state
* Rating system for Riders and Drivers
* User profiles
* Extremely competitve rates


# Table of Contents
* [Installation](#installation)
  * [Enivornment Setup](#environment-setup)
  * [Application Setup](#application-setup)
* [Testing Application](#testing-application)
  * [Requirements](#requirements)
  * [Components](#components)
  * [Login Credentials](#login-credentials)
  * [Spoofing Location](#spoofing-location)
* [Troubleshooting](#troubleshooting)
* [Video Guides](#video-guides)
* [Miscellaneous](#miscellaneous)

# Installation

## Environment Setup

### 1. Install XAMPP
XAMPP is a development environment used to test and run our application.

Download and install the latest stable version of XAMPP at [apachefriends.org](https://www.apachefriends.org/index.html).

Required Components
* Mac: XAMPP Core Files
* Windows: Apache, MySQL, PHP, phpMyAdmin

### 2. Setup XAMPP

#### 2.1 Open XAMPP Application Manager / Control Panel
* Mac: ```/Applications/XAMPP/manager-osx.app```
* Windows: ```C:\xampp\xampp-control.exe```

#### 2.2 Start Apache and MySQL servers
If MySQL won't start because of blocked port, follow instructions below:

* Mac:
  1. Go to Manager Servers > Select MySQL Database > Configure
  2. Change the Port to a different port (i.e. 3307) and Save.
  3. Open and edit ```/Applications/XAMPP/xamppfiles/etc/my.cnf```
  4. Change the port number on line 28 to the new port number you set in the previous part.
* Windows:
  1. Go to Config > Service and Port Settings > MySQL
  2. Change Main Port to a different port (i.e. 3307) and Save.
  3. Click on Config for MySQL > my.ini
  4. Change the port number on line 28 to the new port number you set in the previous part.
  5. Open and edit ```C:\xampp\phpMyAdmin\config.inc.php```
  6. Add ```$cfg['Servers'][$i]['port'] = '3307';``` to the file with your new port number. Save and close.

### 3. Testing XAMPP

#### 3.3.1 Test Apacher Server
Type in the following URL in a web browser:
````
http://localhost
````
or
```
http://127.0.0.1/
```
You should see webpage by XAMPP.

#### 3.3.2 Test MySQL Server
Type in the following URL in a web browser:
````
http://localhost/phpmyadmin
````
You should be logged into phpMyAdmin and see the list of tables on the left.


## Application Setup

### 1. Download Project
Clone or download this repository.

### 2. Setup Project with XAMPP
Place ```LetsRide``` directory into ```XAMPP/htdocs```

Start XAMPP and go to ```http://localhost/LetsRide```

You should see the Let's Ride Homepage.

### 3. Setup Database
In the ```database``` directory, there are two sql scripts that must be executed.

Start XAMPP and open ```http://localhost/phpmyadmin``` in a web browser.

* Load Schema
  1. In phpMyAdmin home, select the Import tab.
  2. Choose File and select ```database/LetsRideDB-scheme.sql```
  3. Leave default settings and click Go.
* Load Data
  1. In phpMyAdmin, select LetsRideDB on the left.
  2. Select the Import tab of this database.
  3. Choose File and select ```database/LetsRideDB-data.sql```
  4. Leave default settings and click Go.

### 4. Configure Database for Application
```LetsRide/php/_config.php``` needs to be modified to match your database configurations.
```
// Modify these values to your configuration.
$servername = 'localhost';
$port = '3306';
$dbname = 'LetsRideDB';
$username = 'root';
$password = '';
```

# Testing Application

## Requirements
* Environment and Application Setup completed
* Latest version of Chrome and/or Firefox web browser
* Internet connection
* Location services enabled
* Disable anti-virus software, adblockers, etc.

#### One User Per Browser Session Rule
* Only one user can be logged in per browser session.
* Incognito or Private mode of the browser can be used to have two different users logged into one browser.
(i.e. Rider logged in on Normal mode and Driver logged in on Incognito/Private mode)
* Therefore, at most, 2 different users can be logged in using the same browser (Normal + Incognito/Private).

__These requirements must be met before testing.__

## Components

The following components can be tested:
* Registration
* Login/Logout
* Profile
* Rider Actions
* Driver Actions
* Rating System
* Location Tracking
* Google Maps Route Display
* Find Closest Driver
* Calculate Ride Information

The following components can NOT be tested:
* Profile Picture
* Payment

## Login Credentials

The following are login credentials for test accounts:

### Rider Accounts
| Username      | Password      |
| ------------- |:-------------:|
| r1@r.com      | pass          |
| r2@r.com      | pass          |
| r3@r.com      | pass          |
| r4@r.com      | pass          |
| r5@r.com      | pass          |

### Driver Accounts
| Username      | Password      |
| ------------- |:-------------:|
| d1@d.com      | pass          |
| d2@d.com      | pass          |
| d3@d.com      | pass          |
| d4@d.com      | pass          |
| d5@d.com      | pass          |

## Spoofing Location
Since location is tracked real-time, location spoofing must be done to simulate movement.

* [Chrome Geolocation Sensor](https://developers.google.com/web/tools/chrome-devtools/device-mode/device-input-and-sensors) (_Recommended_)
* Firefox - No tested method.

# Troubleshooting

### Issues with XAMPP
* [XAMPP Mac FAQ](https://www.apachefriends.org/faq_osx.html)
* [XAMPP Windows FAQ](https://www.apachefriends.org/faq_windows.html)

### Other Issues 
Check for any error messages or the Console.

# Miscellaneous
### Development Stack

* __APIs__ - Google Fonts, Google Maps API

* __Languages__ - HTML, CSS, JavaScript, PHP, SQL

* __Libaries/Frameworks__ - Animate.css, Bootstrap, Font Awesome, jQuery

* __Tools__ - MySQL Workbench, phpMyAdmin, XAMPP

### Photo Credits

* __Let's Ride Logo__ - Designed by Robert Pendergrast

* __Home Background__ - Photo by why kei @ Unsplash

* __Register Background__ - Photo by Umer Sayyam @ Unsplash

* __Rating Emojis__ - Designed by Freepik @ Flaticon

* __Why Let's Ride Icons__ - Designed by Vectors Market @ Flaticon
