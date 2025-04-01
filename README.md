Smart Parking System

Overview

The Smart Parking System is a web-based application that streamlines the parking process by allowing users to book parking slots, verify entry, and exit seamlessly. It eliminates the need for manual parking management by integrating QR code-based authentication and real-time slot monitoring.

Features

Slot Booking: Users can check available slots and book them online.

QR Code Authentication: Entry and exit gates are managed via QR codes pasted at the gates.

Real-time Slot Monitoring: The system updates slot availability dynamically.

Payment Integration: Simulated payment options for slot booking.

Automated Slot Release: Slots are automatically released upon exit.

Technologies Used

Frontend: HTML, CSS, JavaScript

Backend: PHP

Database: MySQL

Hosting (For Deployment): InfinityFree / 000webhost / FreeHosting

Installation & Setup

Prerequisites

XAMPP or any local PHP server

MySQL Database

Steps to Run Locally

Clone the repository:

git clone https://github.com/yourusername/smart-parking-system.git

Start your local server (XAMPP, WAMP, or any other PHP server).

Import the database.sql file into your MySQL database.

Update the db.php file with your database credentials.

Run the project via localhost in your browser.

Deployment Instructions

Upload all project files to a PHP-supported hosting platform.

Import the database to the hosting provider's MySQL.

Configure db.php with the host’s database credentials.

Use Ngrok for temporary public access if needed.

Folder Structure

smart-parking-system/
│-- index.php           # Home Page (Slot Status)
│-- book_slot.php       # Slot Booking Page
│-- verify_entry.php    # Entry Verification Page
│-- exit_verification.php  # Exit Verification Page
│-- db.php              # Database Connection
│-- styles/             # CSS Files
│-- images/             # Image Assets
│-- scripts/            # JavaScript Files
│-- README.md           # Project Documentation

Future Enhancements

SMS/Email Notifications for Slot Booking

Mobile App for Easier Access

AI-based Parking Prediction System

Contributing

Contributions are welcome! Please follow these steps:

Fork the repository.

Create a new branch (feature-branch).

Commit your changes.

Submit a pull request.
