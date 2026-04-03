<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            margin: 0;
        }

        .navbar {
            background: #2196F3;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: white;
            margin: 0;
            font-size: 20px;
        }

        .logout-btn {
            background: #e53935;
            color: white;
            padding: 8px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        .container {
            max-width: 700px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .container h2 {
            color: #333;
        }

        .container p {
            color: #666;
            font-size: 16px;
        }

        @if (session('success'))
            .success {
                color: green;
            }

        @endif
    </style>
</head>

<body>

    <div class="navbar">
        <h1>My Dashboard</h1>
        <a href="/logout" class="logout-btn">Logout</a>
    </div>

    <div class="container">
        <h2>Welcome, {{ $user->name }}! 👋</h2>
        <p>You are successfully logged in.</p>
        <p>Email: {{ $user->email }}</p>
        <p>Phone: {{ $user->phone }}</p>
    </div>

</body>

</html>