<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Redacted | The Times of Designer</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@900&family=Old+Standard+TT&display=swap');
        
        body {
            background-color: #f5f1e8;
            color: #1a1a1a;
            font-family: 'Old Standard TT', serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            overflow: hidden;
        }

        /* Paper Texture */
        body::before {
            content: ''; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,.03) 2px, rgba(0,0,0,.03) 4px);
            pointer-events: none;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 120px;
            margin: 0;
            line-height: 1;
            border-bottom: 4px double #000;
        }

        .error-msg {
            font-size: 24px;
            font-style: italic;
            margin-top: 20px;
        }

        .stamp {
            border: 3px solid #d00;
            color: #d00;
            padding: 10px 20px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            margin: 30px 0;
            transform: rotate(-10deg);
            font-family: 'Courier New', monospace;
            font-size: 30px;
        }

        .btn {
            text-decoration: none;
            color: #fff;
            background: #000;
            padding: 15px 30px;
            font-family: 'Playfair Display', serif;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn:hover { background: #333; }
    </style>
</head>
<body>
    <h1>404</h1>
    <div class="stamp">REDACTED</div>
    <p class="error-msg">"We apologize to our readers. The story you are looking for has been removed by the authorities."</p>
    
    <a href="index.php" class="btn">Return to Front Page</a>
</body>
</html>