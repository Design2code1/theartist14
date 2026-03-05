<?php
session_start();

$ADMIN_USERNAME = 'legobatman';
$ADMIN_PASSWORD = 'catwomen@123';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Access Denied: Invalid Credentials';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Access - Laxit Thummar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Playfair+Display:wght@400;700;900&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f5f1e8; /* Default Newspaper BG */
            color: #1a1a1a;
            font-family: 'Playfair Display', serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* ------------------------------------------------ */
        /* SPY OVERLAY (The Animation Layer) */
        /* ------------------------------------------------ */
        #spy-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: #000;
            color: #0f0; /* Matrix Green */
            font-family: 'Courier Prime', monospace;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .terminal-text {
            font-size: 18px;
            margin-bottom: 20px;
            text-align: left;
            width: 100%;
            max-width: 600px;
            line-height: 1.5;
            min-height: 60px; /* Prevent jump */
        }

        .cursor {
            display: inline-block;
            width: 10px;
            height: 18px;
            background: #0f0;
            animation: blink 1s infinite;
        }

        @keyframes blink { 0%, 100% { opacity: 1; } 50% { opacity: 0; } }

        .spy-input-area {
            display: none; /* Hidden initially */
            width: 100%;
            max-width: 600px;
        }

        .spy-input {
            background: transparent;
            border: none;
            border-bottom: 2px solid #0f0;
            color: #0f0;
            font-family: 'Courier Prime', monospace;
            font-size: 24px;
            width: 100%;
            padding: 10px 0;
            outline: none;
            text-transform: uppercase;
        }

        .spy-input::placeholder { color: rgba(0, 255, 0, 0.3); }

        .access-granted {
            color: #000;
            background: #0f0;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 24px;
            display: none;
            margin-top: 20px;
        }

        .access-denied {
            color: red;
            margin-top: 10px;
            display: none;
        }

        /* ------------------------------------------------ */
        /* LOGIN FORM (Hidden initially) */
        /* ------------------------------------------------ */
        .login-wrapper {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
            padding: 20px;
            opacity: 0; /* Hidden */
            transition: opacity 2s ease-in;
        }

        .login-wrapper.visible {
            opacity: 1;
        }

        /* The "Press Pass" Card Styles (Same as before) */
        .press-pass {
            background: #fff;
            border: 4px double #000;
            padding: 40px;
            box-shadow: 10px 10px 0 rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
        }
        
        .press-pass::after {
            content: ''; position: absolute; top: -15px; left: 50%; transform: translateX(-50%);
            width: 100px; height: 20px; background: rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.2);
        }

        .headline { font-size: 32px; font-weight: 900; text-transform: uppercase; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 5px; }
        .subhead { font-size: 12px; font-style: italic; color: #666; margin-bottom: 30px; letter-spacing: 1px; text-transform: uppercase; }
        .form-group { margin-bottom: 20px; text-align: left; }
        .form-group label { display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; border: 2px solid #000; background: #f9f9f9; font-family: 'Playfair Display', serif; font-size: 16px; outline: none; }
        .btn-login { width: 100%; padding: 12px; background: #000; color: #fff; border: 2px solid #000; text-transform: uppercase; font-weight: 700; font-size: 14px; letter-spacing: 2px; cursor: pointer; transition: all 0.3s; }
        .btn-login:hover { background: #fff; color: #000; }
        .error-stamp { color: #b00; border: 2px solid #b00; padding: 10px; margin-bottom: 15px; display: inline-block; transform: rotate(-2deg); font-weight: bold; }

    </style>
</head>
<body>

    <div id="spy-overlay">
        <div class="terminal-text" id="terminal-output"></div>
        <div class="spy-input-area" id="input-area">
            <input type="text" id="spy-input" autocomplete="off" autofocus>
            <div class="access-denied" id="error-msg">INCORRECT. ACCESS DENIED.</div>
        </div>
        <div class="access-granted" id="success-msg">ACCESS GRANTED</div>
    </div>

    <div class="login-wrapper" id="login-form-container">
        <div class="press-pass">
            <h1 class="headline">Restricted Area</h1>
            <p class="subhead">Editorial Staff Login Only</p>

            <?php if ($error): ?>
                <div class="error-stamp">⚠️ <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="username">Badge ID (Username)</label>
                    <input type="text" id="username" name="username" required autocomplete="username">
                </div>
                <div class="form-group">
                    <label for="password">Security Code (Password)</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-login">Verify Credentials</button>
            </form>
            
            <div style="margin-top: 20px; font-size: 12px; font-style: italic;">
                <a href="../index.php" style="color:#666; text-decoration:none;">← Abort Mission</a>
            </div>
        </div>
    </div>

    <script>
        // ----------------------------------------------------
        // SPY CONFIGURATION (CHANGE THESE ANSWERS!)
        // ----------------------------------------------------
        const AGENT_NAME = "baba yaga"; // Answer 1 (Case insensitive)
        const SPY_CODE = "pencil";  // Answer 2 (Case insensitive)

        // ----------------------------------------------------
        // SYSTEM LOGIC
        // ----------------------------------------------------
        const terminal = document.getElementById('terminal-output');
        const inputArea = document.getElementById('input-area');
        const inputField = document.getElementById('spy-input');
        const errorMsg = document.getElementById('error-msg');
        const successMsg = document.getElementById('success-msg');
        const overlay = document.getElementById('spy-overlay');
        const loginForm = document.getElementById('login-form-container');

        let step = 0;

        // Typewriter Effect Function
        function typeWriter(text, callback) {
            terminal.innerHTML = "";
            inputArea.style.display = "none";
            let i = 0;
            const speed = 30; // Typing speed

            function type() {
                if (i < text.length) {
                    terminal.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                } else {
                    terminal.innerHTML += '<span class="cursor"></span>';
                    if (callback) callback();
                }
            }
            type();
        }

        // Sequence Controller
        function startSequence() {
            // Step 1: Intro
            typeWriter("> ESTABLISHING SECURE CONNECTION... \n> ENCRYPTION: ACTIVE.\n> WELCOME TO THE DESIGNER SPY WORLD.\n\n> IDENTIFY YOURSELF, AGENT:", function() {
                showInput("ENTER NAME");
                step = 1;
            });
        }

        function showInput(placeholder) {
            inputArea.style.display = "block";
            inputField.value = "";
            inputField.placeholder = placeholder;
            inputField.focus();
            errorMsg.style.display = "none";
        }

        // Input Handler
        inputField.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                const val = inputField.value.trim().toLowerCase();

                if (step === 1) {
                    // Validate Name
                    if (val === AGENT_NAME.toLowerCase()) {
                        step = 2;
                        typeWriter("> IDENTITY CONFIRMED: AGENT " + AGENT_NAME.toUpperCase() + ".\n\n> SECURITY QUESTION ALPHA:\n> WHAT IS YOUR WEAPON OF CHOICE?", function() {
                            showInput("ANSWER...");
                        });
                    } else {
                        showError();
                    }
                } else if (step === 2) {
                    // Validate Code
                    if (val === SPY_CODE.toLowerCase()) {
                        grantAccess();
                    } else {
                        showError();
                    }
                }
            }
        });

        function showError() {
            errorMsg.style.display = "block";
            inputField.value = "";
            // Shake effect
            inputArea.style.transform = "translateX(10px)";
            setTimeout(() => { inputArea.style.transform = "translateX(-10px)"; }, 100);
            setTimeout(() => { inputArea.style.transform = "translateX(0)"; }, 200);
        }

        function grantAccess() {
            inputArea.style.display = "none";
            terminal.innerHTML = "> SECURITY CLEARANCE: VERIFIED.\n> WELCOME HOME, AGENT.";
            successMsg.style.display = "block";
            
            setTimeout(() => {
                // Fade out overlay
                overlay.style.transition = "opacity 1s ease";
                overlay.style.opacity = "0";
                setTimeout(() => {
                    overlay.style.display = "none";
                    loginForm.classList.add('visible');
                }, 1000);
            }, 1500);
        }

        // Start immediately
        window.onload = startSequence;

        // Keep focus on input
        document.addEventListener('click', function() {
            if(inputArea.style.display === 'block') inputField.focus();
        });

    </script>
</body>
</html>