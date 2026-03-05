<?php
session_start();

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Check which stage of the interrogation we are at
    if ($data['step'] === 1 && strtolower(trim($data['answer'])) === 'baba yaga') {
        echo json_encode(['success' => true, 'next' => 'harry']);
    } 
    elseif ($data['step'] === 2 && strtolower(trim($data['answer'])) === 'emma watson') {
        echo json_encode(['success' => true, 'next' => 'time']);
    } 
    elseif ($data['step'] === 3 && strtolower(trim($data['answer'])) === 'fuck the time') {
        $_SESSION['spy_access'] = true; // Grant Access
        echo json_encode(['success' => true, 'redirect' => 'spy-vault.php']);
    } 
    else {
        echo json_encode(['success' => false]);
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Protocol Omega</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');
        
        body {
            background-color: #111;
            color: #d00; /* Red for danger/spy vibe */
            font-family: 'Courier Prime', monospace;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .interrogation-room {
            width: 600px;
            text-align: center;
        }

        .question {
            font-size: 24px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        input {
            background: transparent;
            border: none;
            border-bottom: 2px solid #d00;
            color: #fff;
            font-family: 'Courier Prime', monospace;
            font-size: 30px;
            text-align: center;
            width: 100%;
            outline: none;
            text-transform: uppercase;
        }

        .hidden { display: none; }
        
        .shake { animation: shake 0.5s; }
        @keyframes shake { 0% { transform: translateX(0); } 25% { transform: translateX(-10px); } 75% { transform: translateX(10px); } 100% { transform: translateX(0); } }
    </style>
</head>
<body>

    <div class="interrogation-room">
        <div id="q1-container">
            <div class="question">Identify Agent Name:</div>
            <input type="text" id="input1" autofocus autocomplete="off">
        </div>

        <div id="q2-container" class="hidden">
            <div class="question">Target Code: harry</div>
            <input type="text" id="input2" autocomplete="off">
        </div>

        <div id="q3-container" class="hidden">
            <div class="question">Sync Check: What time is it?</div>
            <input type="text" id="input3" autocomplete="off">
        </div>
    </div>

    <script>
        function checkAnswer(step, inputId, nextContainerId) {
            const input = document.getElementById(inputId);
            const val = input.value;

            fetch('login2.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ step: step, answer: val })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        document.getElementById(inputId).parentElement.classList.add('hidden');
                        const next = document.getElementById(nextContainerId);
                        next.classList.remove('hidden');
                        next.querySelector('input').focus();
                    }
                } else {
                    document.body.classList.add('shake');
                    input.value = '';
                    setTimeout(() => document.body.classList.remove('shake'), 500);
                }
            });
        }

        document.getElementById('input1').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') checkAnswer(1, 'input1', 'q2-container');
        });
        document.getElementById('input2').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') checkAnswer(2, 'input2', 'q3-container');
        });
        document.getElementById('input3').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') checkAnswer(3, 'input3', null);
        });
    </script>
</body>
</html>