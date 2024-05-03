Simulated Marketplace Application
This repository hosts the code for a fully simulated marketplace application designed to demonstrate full-stack web development skills including HTML, CSS, JavaScript, AJAX, PHP, and MySQL. The application features a robust user login system and the capability to handle item uploads, managing data storage on a local database.

Features
User Authentication: Utilizes AJAX for a smooth, asynchronous user login experience.
Item Uploads: Allows users to upload items with details which are then stored in a local database.
Interactive UI: Built with HTML, CSS, and JavaScript to create a responsive and intuitive user interface.
Dynamic Content: JavaScript and AJAX are used to ensure dynamic interaction without needing to reload the page.
Installation
To set up this project locally, follow these steps:

Clone the repository:
bash
Copy code
git clone https://github.com/yourusername/simulated-marketplace.git
Import the marketplace_db.sql file into your MySQL database to create and populate the necessary tables.
Update the database connection settings in db_config.php to reflect your local or remote MySQL server credentials.
Place all files into your web server's root or public HTML directory.
Usage
Navigate to your deployment URL, which might look something like http://localhost/simulated-marketplace/. Here's how to get started:

Login/Register: Access the system by logging in or registering a new account through the AJAX-enabled form.
Upload Items: After logging in, go to the 'Upload Items' section to add new items to the marketplace.
Browse Items: Explore items uploaded by other users, with real-time updates.
Development
This project uses:

HTML/CSS for layout and styling.
JavaScript for frontend dynamics.
AJAX for asynchronous server communication.
PHP as the backend scripting language.
MySQL for database management.
