# health-information-system
The system is designed in such a way is easy to use and user friendly for creating a health program, registering new clients, enrolling clients into the programs, search and viewing clients
 Health Information System
Overview
This is a simple Health Information System developed to allow doctors to manage health programs and client information efficiently. It includes features for creating health programs, registering and enrolling clients, searching client records, viewing profiles, and exposing client data via an API.

Features
Health Program Management: Create and manage different health programs (e.g., TB, Malaria, HIV).

Client Registration: Add new clients to the system.

Client Enrollment: Enroll clients into one or more health programs.

Client Search: Easily find clients from the list of registered users.

Profile Viewing: View detailed client profiles, including their enrolled programs.

API Exposure: Retrieve client profiles through a simple API.

Technology Stack
Frontend: HTML, Bootstrap, JavaScript

Backend: PHP

Database: MySQL

Setup Instructions
Clone the repository:

bash
Copy
Edit
git clone <your-repo-link>
Set up the Database:

Import the provided SQL file into your MySQL server.

Update the database connection details in the project configuration file (e.g., config.php).

Run the Application:

Place the project files in your web server directory (e.g., htdocs for XAMPP).

Start your Apache and MySQL services.

Access the system via http://localhost/healthmanagement system/.

API Usage:

Access client data using a simple GET request:

bash
Copy
Edit
http://localhost/healthmanagement system/api/client.php?id=CLIENT_ID
Folder Structure
bash
Copy
Edit
/css        -> Stylesheets
/js         -> JavaScript files
/api        -> API endpoints
/config     -> Database configuration
/views      -> HTML templates
/controllers-> Business logic
/index.php  -> Entry point


Future Enhancements
Application tests (Unit and API tests)

API-first redesign

Security improvements (input sanitization, authentication)

Deployment to a cloud server

Role-based access control (doctor, admin)

Notes
Code is clean, modular, and well-documented.

Designed with scalability and maintainability in mind.

Best practices followed for basic data security.

License
This project is for demonstration purposes and is open for further development and improvement.

**Prototype Demonstration (System Walkthrough)** 
1. System Start 
Launch XAMPP. 
Start Apache and MySQL services. 
Open phpMyAdmin. 
Import the provided database SQL file (health_info_system.sql). 
Open the project folder in Visual Studio Code. 
Access the system by going to http://localhost/healthmanagement system/. 
2. Home / Dashboard (index.html) 
Display system introduction (optional basic welcome page). 
3. Create Health Programs (programs.php) 
Navigate to programs.php. 
Fill in the form: 
Program Name: e.g., Tuberculosis Treatment Program 
Description: Details about the program. 
Submit to create a new health program. 
Programs are stored in the programs table. 
4. Register New Clients (clients.php) 
Navigate to clients.php. 
Fill the form with: 
Full Name 
Email Address 
Phone Number 
Submit to register a new client. 
Clients are stored in the clients table. 
5. Enroll Clients into Programs (enrollments.php) 
Navigate to enrollments.php. 
Choose an existing client and a program. 
Optionally add enrollment notes. 
Submit to enroll client into the selected program. 
Enrollment data saved into the enrollments table. 
6. View Clients and Profiles 
Navigate to the "View Clients" page (clients.php). 
Search clients by name or email. 
Click on a client to view their full profile, including enrolled programs. 
7. API Access (external systems) 
Access client data through exposed API: 
Example: GET http://localhost/healthmanagement system/client.php?id=1 
Returns JSON formatted profile details and enrollments. 
8. Summary 
System fully working with backend + frontend. 
Database relationships correctly maintained. 
API endpoints ready for real-world integration. 
Given more Time and resources I could make the system more responsive functionalities
