📝 Task Management Web Application

A PHP-based task management web app that allows users to create tasks, assign them to connections, and manage their task history. The app also includes user authentication, a settings page, and account management.

🚀 Features

🔑 User Authentication

Users can register and log in securely.

Sessions are managed to prevent unauthorized access.

📋 Task Management

Create personal tasks and manage them.

Assign tasks to connections (friends).

View all self-created and assigned tasks.

Mark tasks as completed (moved to history).

Responsive dashboard for task overview.

👥 Connections (Friends System)

Search for users and send friend requests.

Accept or reject connection requests.

Assign tasks to connected users.

⚙️ User Settings (Newly Added)

View account details (username & email).

Reset password securely.

Clear completed task history.

Delete account (removes all associated data).

📁 Project Structure

/ (Root)
│── index.php          # Login Page
│── register.php       # User Registration
│── dashboard.php      # Task Dashboard
│── settings.php       # User Settings Page (New)
│── connections.php    # Manage Friend Requests
│── tasks.php          # Task Operations
│── config.php         # Database Configuration
│── logout.php         # User Logout
│── assets/            # CSS & Images
│── db/                # Database Scripts
│── README.md          # Project Documentation

🛠️ Installation & Setup

Clone the repository:

git clone https://github.com/your-username/task-manager.git

Navigate to the project folder:

cd task-manager

Set up the database:

Import the database.sql file from the db/ directory.

Update config.php with your database credentials.

Run the application on localhost using a local PHP server:

php -S localhost:8000

🔒 Security Measures

Hashed passwords using password_hash().

Prepared statements to prevent SQL injection.

Session management to restrict unauthorized access.

📜 License

This project is open-source under the MIT License.

📬 Contact

For any issues or feature requests, feel free to open an issue or contribute to the repository. 🚀
