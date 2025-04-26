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

Access the system via http://localhost/your-project-folder/.

API Usage:

Access client data using a simple GET request:

bash
Copy
Edit
http://localhost/your-project-folder/api/client.php?id=CLIENT_ID
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
