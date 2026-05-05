<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>Inventory MS - Smart Inventory Management System</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Crect width='100' height='100' fill='%232c6e62' rx='20'/%3E%3Crect x='25' y='30' width='50' height='40' fill='white' rx='5'/%3E%3Crect x='35' y='40' width='30' height='20' fill='%232c6e62' rx='3'/%3E%3C/svg%3E">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            overflow-x: hidden;
        }

        /* Navigation Bar */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(10, 30, 44) 100%);
            padding: 1rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .logo {
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding-bottom: 5px;
            position: relative;
            cursor: pointer;
        }
        
        .nav-links a.active {
            color: white;
        }
        
        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: white;
            border-radius: 2px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { width: 0; left: 50%; }
            to { width: 100%; left: 0; }
        }
        
        .nav-links a:hover {
            color: white;
        }
        
        .nav-links a:hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 2px;
        }

        .login-btn {
            background: linear-gradient(180deg, rgb(25, 110, 114) 0%, rgb(15, 43, 61) 100%);
            padding: 10px 28px;
            border-radius: 30px;
            color: white !important;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 110, 114, 0.4);
        }
        
        .login-btn::after {
            display: none !important;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 5% 60px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .hero-content {
            flex: 1;
            animation: fadeInUp 0.8s ease;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            padding: 14px 32px;
            border-radius: 40px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(25, 110, 114, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid rgb(25, 110, 114);
            padding: 12px 30px;
            border-radius: 40px;
            color: rgb(25, 110, 114);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: rgb(25, 110, 114);
            color: white;
            transform: translateY(-3px);
        }

        .hero-image {
            flex: 1;
            animation: fadeInRight 0.8s ease;
            text-align: center;
            padding: 20px;
        }

        .hero-image img {
            width: 100%;
            max-width: 650px;
            height: auto;
            border-radius: 24px;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hero-image img:hover {
            transform: translateY(-5px);
            box-shadow: 0 40px 60px rgba(0, 0, 0, 0.2);
        }

        /* Features Section */
        .features {
            padding: 80px 5%;
            background: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: rgb(15, 43, 61);
            margin-bottom: 15px;
        }

        .section-title p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            border-color: rgb(25, 110, 114);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 28px;
            color: white;
        }

        .feature-card h3 {
            font-size: 1.3rem;
            color: rgb(15, 43, 61);
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #6c757d;
            line-height: 1.6;
        }

        /* Stats Section */
        .stats-section {
            padding: 80px 5%;
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(10, 30, 44) 100%);
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            font-weight: 700;
            color: rgb(25, 110, 114);
            margin-bottom: 10px;
        }

        .stat-item p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* How It Works */
        .how-it-works {
            padding: 80px 5%;
            background: #f8fafc;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .step {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .step h4 {
            font-size: 1.2rem;
            color: rgb(15, 43, 61);
            margin-bottom: 10px;
        }

        .step p {
            color: #6c757d;
        }

        /* Pricing Section */
        .pricing {
            padding: 80px 5%;
            background: #e8f4f2;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .pricing-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
        }

        .pricing-card.popular {
            border: 2px solid rgb(25, 110, 114);
            transform: scale(1.02);
        }

        .popular-badge {
            position: absolute;
            top: -12px;
            right: 20px;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .pricing-card h3 {
            font-size: 1.5rem;
            color: rgb(15, 43, 61);
            margin-bottom: 20px;
        }

        .price {
            font-size: 3rem;
            font-weight: 700;
            color: rgb(25, 110, 114);
            margin-bottom: 20px;
        }

        .price span {
            font-size: 1rem;
            color: #6c757d;
        }

        .pricing-card ul {
            list-style: none;
            margin: 30px 0;
        }

        .pricing-card li {
            padding: 10px 0;
            color: #6c757d;
        }

        .pricing-card li i {
            color: rgb(25, 110, 114);
            margin-right: 10px;
        }

        /* CTA Section */
        .cta {
            padding: 80px 5%;
            background: linear-gradient(135deg, rgb(15, 43, 61) 0%, rgb(10, 30, 44) 100%);
            text-align: center;
            color: white;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .cta .btn-primary {
            background: white;
            color: rgb(15, 43, 61);
        }

        .cta .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.2);
        }

        /* Footer */
        .footer {
            background: #0f2b3d;
            color: white;
            padding: 50px 5% 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-section h4 {
            margin-bottom: 20px;
            font-size: 1.2rem;
        }

        .footer-section p {
            opacity: 0.8;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 10px;
        }

        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .footer-section ul li a:hover {
            color: white;
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: rgb(25, 110, 114);
            transform: translateY(-3px);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.7;
            font-size: 0.9rem;
        }

        /* Password Field with Eye Icon */
        .password-field {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .password-field input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 1.5px solid #e2e9f0;
            border-radius: 28px;
            font-size: 0.9rem;
            transition: all 0.2s;
            background: #ffffff;
            outline: none;
        }
        
        .password-field input:focus {
            border-color: #3a8f7e;
            box-shadow: 0 0 0 3px rgba(58, 143, 126, 0.1);
        }
        
        .password-field i:first-child {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9bb4c2;
            font-size: 1rem;
        }
        
        .toggle-password {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            transition: color 0.3s ease;
            font-size: 1rem;
            z-index: 10;
        }
        
        .toggle-password:hover {
            color: #2c6e62;
        }

        /* Login Modal Styles */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 2000;
        }

        .modal-container.show {
            visibility: visible;
            opacity: 1;
        }

        .login-modal {
            width: 90%;
            max-width: 800px;
            height: 550px;
            background: transparent;
            border-radius: 32px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-30px) scale(0.95);
                opacity: 0;
            }
            to {
                transform: translateY(0) scale(1);
                opacity: 1;
            }
        }

        .modal-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
        }

        /* Left Panel - Welcome Message Area */
        .welcome-panel {
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, #0f2b3d 0%, #0a1e2c 100%);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 2;
        }

        /* Right Panel - Form Area */
        .form-panel {
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, rgb(44, 110, 98) 0%, #144243 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 2;
        }

        /* Register Mode - Swap panels */
        .login-modal.register-mode .welcome-panel {
            transform: translateX(100%);
        }

        .login-modal.register-mode .form-panel {
            transform: translateX(-100%);
        }

        .welcome-content {
            max-width: 280px;
            margin: 0 auto;
        }

        .form-content {
            width: 100%;
            max-width: 320px;
            position: relative;
        }

        .form-wrapper {
            width: 100%;
            transition: all 0.4s ease;
        }

        .login-form-wrapper {
            display: block;
            animation: fadeInUp 0.4s ease;
        }

        .register-form-wrapper {
            display: none;
            animation: fadeInUp 0.4s ease;
        }

        .login-modal.register-mode .login-form-wrapper {
            display: none;
        }

        .login-modal.register-mode .register-form-wrapper {
            display: block;
        }

        .welcome-text-login,
        .welcome-text-register {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .welcome-text-register {
            display: none;
        }

        .login-modal.register-mode .welcome-text-login {
            display: none;
        }

        .login-modal.register-mode .welcome-text-register {
            display: block;
            animation: fadeInUp 0.4s ease;
        }

        .welcome-text-login {
            display: block;
            animation: fadeInUp 0.4s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .welcome-icon {
            width: 80px;
            height: 80px;
            background: rgba(58, 143, 126, 0.2);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: #3a8f7e;
            border: 2px solid rgba(58, 143, 126, 0.5);
        }

        .welcome-panel h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
        }

        .welcome-panel p {
            font-size: 0.9rem;
            line-height: 1.6;
            opacity: 0.85;
            margin-bottom: 2rem;
        }

        .switch-btn {
            background: linear-gradient(180deg, rgb(38, 76, 100) 0%, rgb(30, 157, 164) 100%);
            border: none;
            padding: 12px 32px;
            border-radius: 40px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .switch-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(58, 143, 126, 0.3);
        }

        .form-content h1 {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.8rem;
            text-align: center;
        }

        .input-box {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-box i:first-child {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9bb4c2;
            font-size: 1rem;
        }

        .input-box input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 1.5px solid #e2e9f0;
            border-radius: 28px;
            font-size: 0.9rem;
            transition: all 0.2s;
            background: #ffffff;
            outline: none;
        }

        .input-box input:focus {
            border-color: #3a8f7e;
            box-shadow: 0 0 0 3px rgba(58, 143, 126, 0.1);
        }

        .input-box input::placeholder {
            color: #98a5ad;
        }

        .btn {
            width: 100%;
            background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(25, 110, 114) 100%);
            border: none;
            padding: 14px;
            border-radius: 40px;
            color: white;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 43, 61, 0.3);
        }

        .role {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            gap: 30px;
        }

        .role label {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            cursor: pointer;
        }

        .role input[type="radio"] {
            width: auto;
            margin: 0;
            accent-color: #3a8f7e;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Alert Messages */
        .alert-message {
            position: fixed;
            top: 90px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 320px;
            max-width: 500px;
            padding: 16px 24px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 1001;
            animation: slideDown 0.3s ease;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        .alert-message-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
            color: #155724;
        }

        .alert-message-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .alert-message-info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }

        .alert-icon {
            font-size: 22px;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .alert-text {
            font-size: 13px;
            opacity: 0.9;
        }

        .alert-close {
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: inherit;
            opacity: 0.6;
            transition: opacity 0.3s ease;
            padding: 4px;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert-close:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.05);
        }

        /* Mobile Menu */
        .menu-toggle {
            display: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }
        /* Password match error */
        .password-match-error {
            display: none;
            align-items: center;
            gap: 6px;
            color: #dc3545;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 12px;
            padding: 6px 12px;
            background: rgba(220, 53, 69, 0.08);
            border-radius: 8px;
            border-left: 3px solid #dc3545;
            animation: fadeInUp 0.2s ease;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .hero-image img {
                max-width: 550px;
            }
            .hero-content h1 {
                font-size: 2.8rem;
            }
        }

        @media (max-width: 860px) {
            .menu-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 70px);
                background: linear-gradient(180deg, rgb(15, 43, 61) 0%, rgb(10, 30, 44) 100%);
                flex-direction: column;
                padding: 40px;
                transition: all 0.3s ease;
                gap: 25px;
            }

            .nav-links.active {
                left: 0;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 120px;
                gap: 40px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-image img {
                max-width: 450px;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .login-modal {
                height: auto;
                min-height: 600px;
            }

            .modal-wrapper {
                flex-direction: column;
            }

            .welcome-panel,
            .form-panel {
                width: 100%;
                min-height: 280px;
            }

            .login-modal.register-mode .welcome-panel {
                transform: translateX(0);
                order: 2;
            }

            .login-modal.register-mode .form-panel {
                transform: translateX(0);
                order: 1;
            }

            .welcome-content {
                max-width: 100%;
            }
            
            .alert-message {
                top: 80px;
                min-width: 280px;
                max-width: 90%;
                padding: 12px 18px;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 1.5rem;
            }

            .btn-primary, .btn-secondary {
                padding: 10px 20px;
                font-size: 14px;
            }

            .hero-image img {
                max-width: 100%;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .social-links {
                justify-content: center;
            }

            .welcome-panel h2 {
                font-size: 1.5rem;
            }

            .form-content h1 {
                font-size: 1.5rem;
            }

            .role {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }
            
            .alert-message {
                top: 75px;
                padding: 10px 14px;
            }
            
            .alert-icon {
                font-size: 18px;
            }
            
            .alert-title {
                font-size: 12px;
            }
            
            .alert-text {
                font-size: 11px;
            }
        }

        @media (min-width: 1400px) {
            .hero-image img {
                max-width: 750px;
            }
            .hero-content h1 {
                font-size: 4rem;
            }
            .hero-content p {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 380px) {
            .navbar {
                padding: 0.8rem 4%;
            }
            .logo-text {
                font-size: 18px;
            }
            .logo-icon {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
            .hero-content h1 {
                font-size: 1.3rem;
            }
            .btn-primary, .btn-secondary {
                padding: 8px 16px;
                font-size: 12px;
            }
            .pricing-card {
                padding: 30px 20px;
            }
            .price {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="logo">
            <div class="logo-icon">
                <i class="fa-solid fa-box"></i>
            </div>
            <span class="logo-text">Inventory MS</span>
        </div>
        <div class="menu-toggle" id="menuToggle">
            <i class="fas fa-bars"></i>
        </div>
        <div class="nav-links" id="navLinks">
            <a href="#home">Home</a>
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
            <a href="#pricing">Pricing</a>
            <a class="login-btn" onclick="openLoginModal()">
                <i class="fa-solid fa-right-to-bracket"></i><strong>  Login</strong>
            </a>
        </div>
    </nav>

    @if(session('error'))
        <div class="alert-message alert-message-error" id="alertMessage">
            <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class="alert-content">
                <div class="alert-title">Authentication Failed</div>
                <div class="alert-text">{{ session('error') }}</div>
            </div>
            <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert-message alert-message-success" id="alertMessage">
            <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
            <div class="alert-content">
                <div class="alert-title">Success!</div>
                <div class="alert-text">{{ session('success') }}</div>
            </div>
            <button class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content">
            <h1>Smart Inventory Management <br/>for Modern Business</h1>
            <p>Streamline your inventory, track sales in real-time, and make data-driven decisions with our powerful inventory management system. Perfect for retail stores, warehouses, and small businesses.</p>
            <div class="hero-buttons">
                <a onclick="openLoginModal()" class="btn-primary">
                    <i class="fas fa-rocket"></i> Get Started
                </a>
                <a href="#features" class="btn-secondary">
                    <i class="fas fa-play"></i> Learn More
                </a>
            </div>
        </div>
        <div class="hero-image">
            <img src="{{ asset('photos/Dashboard.png') }}" alt="Dashboard Preview" />
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="section-title">
            <h2>Powerful Features</h2>
            <p>Everything you need to manage your inventory efficiently</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Real-time Analytics</h3>
                <p>Track sales performance, monitor stock levels, and get instant insights with interactive charts and reports.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-boxes"></i></div>
                <h3>Stock Management</h3>
                <p>Manage products, categories, and suppliers. Set low stock alerts to never run out of popular items.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-shopping-cart"></i></div>
                <h3>Sales & Purchases</h3>
                <p>Record sales, process payments, manage purchase orders, and track all transactions in one place.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                <h3>Comprehensive Reports</h3>
                <p>Generate detailed sales reports, inventory valuation, and category analysis with date filtering.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-users"></i></div>
                <h3>User Management</h3>
                <p>Role-based access control with admin and user roles. Secure and organized team collaboration.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Responsive Design</h3>
                <p>Access your inventory system from any device - desktop, tablet, or mobile phone.</p>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item"><h3>500+</h3><p>Businesses Trust Us</p></div>
            <div class="stat-item"><h3>50K+</h3><p>Products Managed</p></div>
            <div class="stat-item"><h3>100K+</h3><p>Transactions Processed</p></div>
            <div class="stat-item"><h3>24/7</h3><p>Customer Support</p></div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="how-it-works">
        <div class="section-title">
            <h2>How It Works</h2>
            <p>Get started in 4 simple steps</p>
        </div>
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h4>Create Account</h4>
                <p>Sign up for an account and choose your plan</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h4>Add Products</h4>
                <p>Import your products or add them manually</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h4>Start Selling</h4>
                <p>Record sales and track inventory in real-time</p>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <h4>Analyze & Grow</h4>
                <p>Use insights to make better business decisions</p>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="pricing">
        <div class="section-title">
            <h2>Simple, Transparent Pricing</h2>
            <p>Choose the plan that works for your business</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Basic</h3>
                <div class="price">₱0<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> Up to 100 Products</li>
                    <li><i class="fas fa-check"></i> Basic Reports</li>
                    <li><i class="fas fa-check"></i> 1 User Account</li>
                    <li><i class="fas fa-check"></i> Email Support</li>
                </ul>
                <a onclick="openLoginModal()" class="btn-secondary">Get Started</a>
            </div>
            <div class="pricing-card popular">
                <div class="popular-badge">Most Popular</div>
                <h3>Professional</h3>
                <div class="price">₱499<span>/month</span></div>
                <ul>
                    <li><i class="fas fa-check"></i> Unlimited Products</li>
                    <li><i class="fas fa-check"></i> Advanced Reports</li>
                    <li><i class="fas fa-check"></i> 5 User Accounts</li>
                    <li><i class="fas fa-check"></i> Priority Support</li>
                    <li><i class="fas fa-check"></i> API Access</li>
                </ul>
                <a onclick="openLoginModal()" class="btn-primary">Get Started</a>
            </div>
            <div class="pricing-card">
                <h3>Enterprise</h3>
                <div class="price">Custom</div>
                <ul>
                    <li><i class="fas fa-check"></i> Unlimited Everything</li>
                    <li><i class="fas fa-check"></i> Custom Reports</li>
                    <li><i class="fas fa-check"></i> Unlimited Users</li>
                    <li><i class="fas fa-check"></i> 24/7 Phone Support</li>
                    <li><i class="fas fa-check"></i> Dedicated Account Manager</li>
                </ul>
                <a href="#" class="btn-secondary">Contact Sales</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <h2>Ready to Streamline Your Inventory?</h2>
        <p>Join thousands of businesses that trust Inventory MS for their inventory management needs.</p>
        <a onclick="openLoginModal()" class="btn-primary">
            <i class="fas fa-arrow-right"></i> Start Free Trial
        </a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Inventory MS</h4>
                <p>Smart inventory management solution for modern businesses. Track, manage, and grow with ease.</p>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#pricing">Pricing</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Connect With Us</h4>
                <div class="social-links">
                    <a href="https://www.facebook.com/ericdavecarnese" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://github.com/EricDaveCarnese" target="_blank"><i class="fa-brands fa-github"></i></a>
                    <a href="mailto:e.carnese.546950@umindanao.edu.ph"><i class="fa-solid fa-envelope"></i></a>
                    <a href="https://www.tiktok.com/@ericdave2003" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Inventory MS. All rights reserved.</p>
        </div>
    </footer>

    <!-- Login Modal -->
    <div class="modal-container" id="loginModal">
        <div class="login-modal" id="loginModalContainer">
            <button class="modal-close" onclick="closeLoginModal()">&times;</button>
            <div class="modal-wrapper">
                <!-- LEFT PANEL - Welcome Message Area -->
                <div class="welcome-panel">
                    <div class="welcome-content">
                        <div class="welcome-icon"><i class="fas fa-boxes"></i></div>
                        <div class="welcome-text-login">
                            <h2>Welcome Back!</h2>
                            <p>Sign in to access your inventory dashboard and manage your products efficiently.</p>
                        </div>
                        <div class="welcome-text-register">
                            <h2>Join Us!</h2>
                            <p>Create your account to start managing inventory, track sales, and streamline your business operations.</p>
                        </div>
                        <button class="switch-btn" id="modalSwitchBtn">Register Now</button>
                    </div>
                </div>

                <!-- RIGHT PANEL - Form Area -->
                <div class="form-panel">
                    <div class="form-content">
                        <!-- LOGIN FORM -->
                        <div class="form-wrapper login-form-wrapper">
                            <h1>Login</h1>
                            <form method="POST" action="{{ route('login') }}" id="loginForm">
                                @csrf
                                <div class="input-box">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="password-field">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" name="password" id="login_password" placeholder="Password" required>
                                    <i class="fas fa-eye-slash toggle-password" data-target="login_password"></i>
                                </div>
                                <button type="submit" class="btn">Login</button>
                            </form>
                        </div>

                        <!-- REGISTER FORM -->
                        <div class="form-wrapper register-form-wrapper">
                            <h1>Create Account</h1>
                            <form method="POST" action="{{ route('register') }}" id="registerForm" onsubmit="return validatePasswordMatch(event)">
                                @csrf
                                <div class="input-box">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="fullname" placeholder="Full Name" required>
                                </div>
                                <div class="input-box">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" name="email" placeholder="Email Address" required>
                                </div>
                                <div class="password-field">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" name="password" id="register_password" placeholder="Password" required>
                                    <i class="fas fa-eye-slash toggle-password" data-target="register_password"></i>
                                </div>
                                <div class="password-field">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <input type="password" name="password_confirmation" id="register_password_confirm" placeholder="Confirm Password" required>
                                    <i class="fas fa-eye-slash toggle-password" data-target="register_password_confirm"></i>
                                </div>
                                <div class="password-match-error" id="password-match-error">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>Passwords do not match</span>
                                </div>
                                <div class="role">
                                    <label>
                                        <input type="radio" name="role" value="admin" required>
                                        <i class="fa-solid fa-user-tie"></i> Admin
                                    </label>
                                    <label>
                                        <input type="radio" name="role" value="user" required>
                                        <i class="fa-solid fa-user"></i> User
                                    </label>
                                </div>
                                <button type="submit" class="btn">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Auto-hide alert message after 5 seconds
    setTimeout(function() {
        const alertMessage = document.getElementById('alertMessage');
        if (alertMessage) {
            alertMessage.style.animation = 'slideDown 0.3s ease reverse';
            setTimeout(function() { alertMessage.style.display = 'none'; }, 300);
        }
    }, 5000);
    
    // Get all sections and nav links
    const sections = document.querySelectorAll('section');
    const navLinks = document.querySelectorAll('.nav-links a:not(.login-btn)');
    
    function updateActiveLinkOnScroll() {
        let currentSection = '';
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.clientHeight;
            const scrollPosition = window.scrollY + 150;
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                currentSection = section.getAttribute('id');
            }
        });
        navLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');
            if (href === `#${currentSection}`) link.classList.add('active');
        });
        if (window.scrollY < 100) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#home') link.classList.add('active');
            });
        }
    }
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            if (targetSection) targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    });
    
    window.addEventListener('scroll', updateActiveLinkOnScroll);
    updateActiveLinkOnScroll();
    
    // Mobile Menu Toggle
    const menuToggle = document.getElementById('menuToggle');
    const navLinksContainer = document.getElementById('navLinks');
    if (menuToggle) {
        menuToggle.addEventListener('click', () => { navLinksContainer.classList.toggle('active'); });
    }
    document.querySelectorAll('.nav-links a').forEach(link => {
        link.addEventListener('click', () => { navLinksContainer.classList.remove('active'); });
    });

    //PASSWORD TOGGLE EYE 
    function initializePasswordToggles() {
        document.querySelectorAll('.toggle-password').forEach(function(eyeIcon) {
            eyeIcon.addEventListener('click', function() {
                var targetId = this.getAttribute('data-target');
                var passwordInput = document.getElementById(targetId);
                if (passwordInput) {
                    if (passwordInput.getAttribute('type') === 'password') {
                        passwordInput.setAttribute('type', 'text');
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                    } else {
                        passwordInput.setAttribute('type', 'password');
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                    }
                }
            });
        });
    }

    //INLINE PASSWORD MATCH VALIDATION 
    function initPasswordMatchValidation() {
        const passwordInput = document.getElementById('register_password');
        const confirmInput = document.getElementById('register_password_confirm');
        const errorDiv = document.getElementById('password-match-error');

        function checkMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (confirm.length === 0) {
                errorDiv.style.display = 'none';
                confirmInput.style.borderColor = '#e2e9f0';
                return;
            }

            if (password !== confirm) {
                errorDiv.style.display = 'flex';
                confirmInput.style.borderColor = '#dc3545';
                confirmInput.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.15)';
            } else {
                errorDiv.style.display = 'none';
                confirmInput.style.borderColor = '#28a745';
                confirmInput.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.15)';
            }
        }

        if (confirmInput) confirmInput.addEventListener('input', checkMatch);
        if (passwordInput) passwordInput.addEventListener('input', function() {
            if (confirmInput.value.length > 0) checkMatch();
        });
    }

    //FORM VALIDATION ON SUBMIT
    function validatePasswordMatch(event) {
        const password = document.getElementById('register_password').value;
        const confirmPassword = document.getElementById('register_password_confirm').value;
        const errorDiv = document.getElementById('password-match-error');
        
        if (password !== confirmPassword) {
            event.preventDefault();
            errorDiv.style.display = 'flex';
            document.getElementById('register_password_confirm').style.borderColor = '#dc3545';
            document.getElementById('register_password_confirm').style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.15)';
            document.getElementById('register_password_confirm').focus();
            return false;
        }
        return true;
    }

    //LOGIN MODAL FUNCTIONS 
    const loginModal = document.getElementById('loginModal');
    const loginModalContainer = document.getElementById('loginModalContainer');
    let isModalRegisterMode = false;

    function openLoginModal() {
        loginModal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeLoginModal() {
        loginModal.classList.remove('show');
        document.body.style.overflow = '';
        if (isModalRegisterMode) {
            isModalRegisterMode = false;
            loginModalContainer.classList.remove('register-mode');
            modalSwitchBtn.textContent = 'Register Now';
        }
    }

    function switchToRegister() {
        if (isModalRegisterMode) return;
        isModalRegisterMode = true;
        loginModalContainer.classList.add('register-mode');
        modalSwitchBtn.textContent = 'Back to Login';
    }

    function switchToLogin() {
        if (!isModalRegisterMode) return;
        isModalRegisterMode = false;
        loginModalContainer.classList.remove('register-mode');
        modalSwitchBtn.textContent = 'Register Now';
    }

    function toggleModalMode() {
        if (isModalRegisterMode) switchToLogin();
        else switchToRegister();
    }

    const modalSwitchBtn = document.getElementById('modalSwitchBtn');
    if (modalSwitchBtn) modalSwitchBtn.addEventListener('click', toggleModalMode);

    if (loginModal) {
        loginModal.addEventListener('click', function(e) {
            if (e.target === loginModal) closeLoginModal();
        });
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && loginModal && loginModal.classList.contains('show')) closeLoginModal();
    });

    document.getElementById('registerForm')?.addEventListener('submit', validatePasswordMatch);

    initializePasswordToggles();
    initPasswordMatchValidation();

    document.addEventListener('DOMContentLoaded', function() {
        var flags = document.getElementById('serverFlags');
        if (flags) {
            var hasErrors = flags.getAttribute('data-has-errors') === 'true';
            var hasPasswordError = flags.getAttribute('data-has-password-error') === 'true';
            var hasSessionError = flags.getAttribute('data-has-session-error') === 'true';

            if (hasErrors || hasSessionError) {
                openLoginModal();
                if (hasPasswordError) {
                    setTimeout(function() { switchToRegister(); }, 100);
                }
            }
        }
    });
    </script>
    <div id="serverFlags"
         data-has-errors="{{ $errors->any() ? 'true' : 'false' }}"
         data-has-password-error="{{ $errors->has('password') ? 'true' : 'false' }}"
         data-has-session-error="{{ session('error') ? 'true' : 'false' }}"
         style="display:none">
    </div>
</body>
</html>