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

        .register-container {
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

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            line-height: 1.3;
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

        .password-requirements {
            font-size: 12px;
            color: #ccc;
            margin-top: 5px;
        }

        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #555;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
        }

        .password-strength-bar.weak {
            width: 33%;
            background: #f44336;
        }

        .password-strength-bar.medium {
            width: 66%;
            background: #ff9800;
        }

        .password-strength-bar.strong {
            width: 100%;
            background: #4caf50;
        }

        .register-button {
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

        .register-button:hover {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(33, 150, 243, 0.4);
        }

        .register-button:active {
            transform: translateY(0);
        }

        .register-button:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            color: #ffffff;
            font-size: 14px;
        }

        .login-link a {
            color: #42a5f5;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #64b5f6;
            text-decoration: underline;
        }

        .error-message {
            color: #f44336;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 40px 30px;
                margin: 20px;
            }

            .register-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Silahkan Membuat<br>Akun Baru</h1>
        </div>
        
        <form id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <div class="error-message" id="usernameError"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password (Min 8 char, 1 angka, 1 simbol)" required>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strengthBar"></div>
                </div>
                <div class="error-message" id="passwordError"></div>
            </div>
            
            <button type="submit" class="register-button" id="registerBtn">Register</button>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strengthBar');
        const usernameInput = document.getElementById('username');
        const registerForm = document.getElementById('registerForm');
        const registerBtn = document.getElementById('registerBtn');
        const passwordError = document.getElementById('passwordError');
        const usernameError = document.getElementById('usernameError');

        // Password strength checker
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthBar.className = 'password-strength-bar';
            
            if (password.length === 0) {
                strengthBar.className = 'password-strength-bar';
            } else if (strength < 3) {
                strengthBar.classList.add('weak');
            } else if (strength < 5) {
                strengthBar.classList.add('medium');
            } else {
                strengthBar.classList.add('strong');
            }
            
            validatePassword();
        });

        function checkPasswordStrength(password) {
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;
            
            return strength;
        }

        function validatePassword() {
            const password = passwordInput.value;
            const hasMinLength = password.length >= 8;
            const hasNumber = /[0-9]/.test(password);
            const hasSymbol = /[^a-zA-Z0-9]/.test(password);
            
            if (password.length === 0) {
                passwordError.classList.remove('show');
                return false;
            }
            
            if (!hasMinLength || !hasNumber || !hasSymbol) {
                let errors = [];
                if (!hasMinLength) errors.push('minimal 8 karakter');
                if (!hasNumber) errors.push('1 angka');
                if (!hasSymbol) errors.push('1 simbol');
                
                passwordError.textContent = 'Password harus memiliki ' + errors.join(', ');
                passwordError.classList.add('show');
                return false;
            } else {
                passwordError.classList.remove('show');
                return true;
            }
        }

        function validateUsername() {
            const username = usernameInput.value;
            
            if (username.length === 0) {
                usernameError.classList.remove('show');
                return false;
            }
            
            if (username.length < 3) {
                usernameError.textContent = 'Username minimal 3 karakter';
                usernameError.classList.add('show');
                return false;
            } else {
                usernameError.classList.remove('show');
                return true;
            }
        }

        usernameInput.addEventListener('input', validateUsername);

        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const isUsernameValid = validateUsername();
            const isPasswordValid = validatePassword();
            
            if (!isUsernameValid || !isPasswordValid) {
                return;
            }
            
            const username = usernameInput.value;
            const password = passwordInput.value;
            
            // Di sini Anda bisa menambahkan logika register ke backend
            console.log('Username:', username);
            console.log('Password:', password);
            
            // Simulasi registrasi berhasil
            alert('Registrasi berhasil! Silakan login dengan akun baru Anda.');
            
            // Redirect ke halaman login (opsional)
            // window.location.href = 'cryptopedia-login.html';
        });
    </script>
</body>
</html>