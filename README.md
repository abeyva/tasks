<p align="center">
  <img src="https://blogger.googleusercontent.com/img/a/AVvXsEgWkSdis_Pm-ZIFjsEkrr3sxBbrr-h_gZn-GI82BnX7VHsF7x2mK2r7KYg8QNEZrQQmTp_4EV047A-U0UIezRLEqw0DIRsA1pxdKCnPxIoZRj7OVyWJXbPI7pAfxF3p09LaBqaqEtj1uHDBztmhh_a0yG59npNyoJQLicAKoWNWMF3m-Zgi2NMjvKOooQg" width="150" alt="NotesWrittenIn Logo">
</p>

<h1 align="center" style="color:#05d26f">📝 Task Management Web Application</h1>

A **PHP-based task management system** hosted on [NotesWrittenIn](https://notes.written.in), offering personalized task control, friend-based collaboration, and all-new UI enhancements.

---

## 🚀 New in This Version

- ✨ **AI Description Generator** for tasks (based on your note content).
- ✅ **Email Verification** during user registration.
- 🎨 **Material 3 Expressive Design Principles** applied.
- 🌿 **New Tree-Inspired Logo**.
- 📱 **All-New Shadow Bar**: A dynamic bottom navigation that adapts to your current page.
- 🔐 **Updated Privacy Notice**:
  > We prioritize your privacy. Don't share personal data beyond your email. Your email isn't connected to external services, and we don't share data with third parties. There might be a delay in loading time due to shared server hosting. It is recommended to access the NotesWrittenIn site from within India. This is a very early version of the system. Feel free to share any feedback or suggestions for improvement.

---

## 🌟 Features  

### 🔑 User Authentication  
- Register and **log in securely**.  
- **Email verification** enabled for added security.  
- Session control to restrict access.

### 📋 Task Management  
- Add **personal tasks**.  
- Assign tasks to **friends**.  
- Generate task descriptions using AI.  
- Mark tasks as **completed** (moved to task history).  
- **Animated and responsive UI** using Material 3.

### 👥 Connections (Friends System)  
- Send and receive **friend requests**.  
- Manage your **connections list**.  
- Assign tasks to your connections.  

### ⚙️ User Settings  
- View your **email and username**.  
- Change password.  
- **Clear task history**.  
- Permanently **delete your account and all data**.

---

## 🔍 Preview Screenshots

### Dashboard View  
![Dashboard Screenshot](https://blogger.googleusercontent.com/img/a/AVvXsEijsHKfD7enRLVXyvW4eYd6vwJJRQNsPYr2a09J-8dvv-58fyiuFZR8QL6MLTRizYFomhj1altJXF9-z9QRqwNwAUMi-yEPCq40WU1so86ant9ryOc4SnA4k7u9SnNvZ6Vke8VlNXvJw9HvWYx7Yq2MKHP_WSwCTzzqAEOiw2hc0Xp0V1dII9Sq9SvnAoQ)

### Task Assignment View  
![Task Assignment Screenshot](https://blogger.googleusercontent.com/img/a/AVvXsEiuYTgNvq55tZmTb3d49Mh5fCwKcNeXJtw1v-abUWqNzW-UF53SOOwPdfMx8r-HIvKN9DG9JozDv9a6ND8yIRFnzb1tedSNGdI6p8PW580ZYKWwEjvhBfwxzgwafm6YpdeL2uf5nP8nsEhU34RCzHHOcNI1jPqYeSOawX_hcan_AmqDROMKFCV3P0cd5D4)

---

## 📁 Project Structure  



## 📁 Project Structure  
```bash
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
```

🛠️ Installation & Setup
Clone the repository:
git clone https://github.com/abeyva/tasks.git

🔒 Security Measures
Hashed passwords using password_hash().
Prepared statements to prevent SQL injection.
Session management to restrict unauthorized access.


📜 License
This project is open-source under the GNU General Public License (GPL) AND MIT License.

