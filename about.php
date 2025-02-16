<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="/images/twi.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Written.in | About</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Register Service Worker -->
    <script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/sw.js")
        .then(() => console.log("Service Worker Registered"))
        .catch((error) => console.log("Service Worker Registration Failed", error));
    }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        body {
            background: #121212;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        .navbar {
            width: 100%;
            background: #1e1e1e;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar h1 {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
        }
        .container {
            max-width: 800px;
            margin: 80px auto 20px;
            padding: 20px;
            background: #1e1e1e;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.15);
        }
        h2 {
            margin-bottom: 10px;
        }
        p {
            line-height: 1.6;
            margin-bottom: 15px;
        }
        .author-section {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #444;
        }
        .linkedin {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background: #0077B5;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .linkedin:hover {
            background: #005582;
        }
    </style>
</head>
<body>

<div class="navbar">
    <h1 onclick="window.location.href='dashboard.php'"><img src="/images/twih.png" alt="Written.in" style="height: 40px;"></h1>
</div>

<div class="container">
    <h2>📌 About TΛSKS</h2>
    <p><strong>TΛSKS</strong> is a simple and efficient task management web app designed to help you keep track of your personal and assigned tasks.</p>
    
    <h2>📖 How to Use</h2>
    <p>🔹 <strong>Create Tasks</strong>: Add tasks with a title and description.</p>
    <p>🔹 <strong>Manage Connections</strong>: Connect with other users to assign tasks.</p>
    <p>🔹 <strong>View Assigned Tasks</strong>: Check the tasks you need to complete.</p>
    <p>🔹 <strong>Mark as Completed</strong>: Keep track of finished tasks.</p>
    
    <div class="author-section">
        <h2>👋 A Message from the Author</h2>
        <p>Hi, I'm Abey Mathew! I built TΛSKS to help people stay productive and organized in a simple and intuitive way. Feel free to reach out and connect with me!</p>
        <a href="https://www.linkedin.com/in/abeyva" target="_blank" class="linkedin">🔗 Connect on LinkedIn</a>
    </div>
</div>

</body>
</html>
