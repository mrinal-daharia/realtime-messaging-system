# Chatroom Web Application

This is a real-time chatroom web application built using PHP, MySQL, JavaScript (AJAX), HTML, and CSS. It enables users to register, log in, send and receive messages, and track the online/offline status of other users.

## Features

- User registration with profile picture upload
- Secure login and session handling
- Real-time chat functionality using AJAX (no page reload)
- Display of messages with username and profile image
- Active and inactive user tracking system
- Clean, responsive interface with modern UI design

## How It Works

- When a user signs in, their status is marked as **active**.
- When a user leaves or closes the tab, their status automatically updates to **inactive**.
- Messages are stored in a MySQL database and loaded dynamically without refreshing the page.
- The chatroom interface automatically shows which users are currently active or inactive.
- User sessions manage authentication and restrict access to the chatroom only to logged-in users.

## Setup Instructions

1. **Clone the repository** and place it in your web server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).

2. **Import the database:**
   - Create a database named `chatroom`.
   - Create the required `users` and `messages` tables.

3. **Configure Database Connection:**
   - Update your database connection credentials in all `.php` files handling data (`signup.php`, `signin.php`, `sendmessage.php`, etc.).

4. **Start Localhost Server:**
   - Run Apache and MySQL from XAMPP or WAMP.
   - Visit `http://localhost/chatroom/index.html`.

5. **Test the App:**
   - Register a user, log in, and begin chatting.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL

## User Status System

- Users appear with a **green dot** when online and a **red dot** when offline.
- The chatroom fetches updated user status and messages periodically using JavaScript (AJAX).
- User status is updated on window unload using JavaScript to call `update_status.php`.

## License

This project is available for educational and personal use. You are free to modify and build upon it as needed.

## Author

Developed by Mrinal Daharia. Contributions, suggestions, and improvements are welcome.
