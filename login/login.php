<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTS 4.0 - Asal Penumpang</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('https://i.pinimg.com/736x/a8/c8/55/a8c8553ab374d67003f12555734c04db.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
        }

        .login-container {
            position: relative;
            z-index: 1;
            background: rgba(50, 50, 50, 0.95);
            padding: 50px 60px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 450px;
            backdrop-filter: blur(10px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 5px;
            letter-spacing: 2px;
        }

        .login-header h2 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 300;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            font-size: 14px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            background: #ffffff;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(100, 181, 246, 0.3);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #42a5f5 0%, #2196f3 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .login-button:hover {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(33, 150, 243, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 25px;
            color: #ffffff;
            font-size: 14px;
        }

        .register-link a {
            color: #42a5f5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #64b5f6;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 40px 30px;
                margin: 20px;
            }

            .login-header h1 {
                font-size: 28px;
            }

            .login-header h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>LOGIN</h1>
        </div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>
        
        <div class="register-link">
            Belum punya akun? <a href="register.php">Register</a>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Di sini Anda bisa menambahkan logika login
            console.log('Username:', username);
            console.log('Password:', password);
            
            // Contoh alert
            alert('Login functionality akan diimplementasikan sesuai kebutuhan backend Anda');
        });
    </script>
</body>
</html>