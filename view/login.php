<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login cafe</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* Center the content */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Card styling */
        .card {
            background-color: #fff;
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .card-header h3 {
            margin: 0;
            color: #333;
        }

        /* Form label styling */
        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Input field styling */
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: #007BFF;
            outline: none;
        }

        /* Button styling */
        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Center the text and provide spacing for the signup link */
        .text-center {
            text-align: center;
        }

        .text-center a {
            color: #007BFF;
            text-decoration: none;
        }

        .text-center a:hover {
            text-decoration: underline;
        }

        /* Margin for bottom text */
        .mt-3 {
            margin-top: 15px;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <!-- Login Form -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>Login</h3>
            </div>
            <div class="card-body">
                <form action="../process/login_process.php" method="POST">
                    <div class="mb-3">
                        <label for="identifier" class="form-label">Username/Email</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" placeholder="Enter username/email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <div>
                        <button type="submit" class="btn">Login</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
