<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Connexion - TPI Sidi Bennour')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Google Fonts - Poppins --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #1e3a5f;
            --primary-dark: #152942;
            --secondary: #c9a227;
            --secondary-light: #e8d5a3;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(5, 10, 25, 0.95) 0%, rgba(15, 30, 60, 0.90) 100%),
                        url('{{ asset("images/tribunal-bg.jpg") }}') center/cover no-repeat fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        /* ===== LOGIN CARD ===== */
        .login-wrapper {
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(201, 162, 39, 0.2);
            border-radius: 24px;
            padding: 50px 45px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.5);
        }

        /* Logo / Header */
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-logo {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--secondary) 0%, #b8941f 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #0a0e1a;
            box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3);
        }

        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px 20px 16px 50px;
            font-size: 0.95rem;
            color: #fff;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--secondary);
            box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15);
            color: #fff;
            outline: none;
        }

        .input-icon-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            font-size: 1.1rem;
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--secondary);
        }

        /* Remember & Forgot */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--secondary);
            cursor: pointer;
        }

        .forgot-password {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: var(--secondary-light);
        }

        /* Submit Button */
        .btn-login-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--secondary) 0%, #b8941f 100%);
            color: #0a0e1a;
            padding: 16px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: 'Poppins', sans-serif;
            letter-spacing: 0.5px;
            box-shadow: 0 10px 30px rgba(201, 162, 39, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login-submit:hover {
            background: linear-gradient(135deg, var(--secondary-light) 0%, var(--secondary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(201, 162, 39, 0.35);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 30px 0;
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Back to home */
        .back-home {
            text-align: center;
            margin-top: 25px;
        }

        .back-home a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: color 0.3s;
        }

        .back-home a:hover {
            color: var(--secondary);
        }

        /* Error Alert */
        .alert-error {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #f5c2c7;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 35px 25px;
            }

            .login-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>