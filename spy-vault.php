<?php
session_start();

// --- CONFIGURATION ---
$timeout_duration = 120; // 2 Minutes (in seconds)

// --- SECURITY CHECK 1: DIRECT ACCESS ---
// If the spy_access flag isn't set, kick them to the interrogation room immediately.
if (!isset($_SESSION['spy_access']) || $_SESSION['spy_access'] !== true) {
    header('Location: login2.php');
    exit;
}

// --- SECURITY CHECK 2: SESSION TIMEOUT ---
// Check if "last_activity" is set and if 2 minutes have passed
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // Session expired
    session_unset();     
    session_destroy();   
    header('Location: index.php'); // Kick back to cover page
    exit;
}

// Update last activity time stamp
$_SESSION['last_activity'] = time();


// --- DATA LOADING LOGIC ---
$dataFile = 'data/spy_data.json';
$data = json_decode(file_get_contents($dataFile), true);

// HANDLE UPDATES
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_intel'])) {
    $newData = [
        'profile' => [
            'name' => $_POST['name'],
            'alias' => $_POST['alias'],
            'dob' => $_POST['dob'],
            'age' => $_POST['age'],
            'location' => $_POST['location'],
            'occupation' => $_POST['occupation'],
            'education' => $_POST['education']
        ],
        'missions' => array_filter(explode("\n", $_POST['missions']))
    ];
    
    // Handle Photo Upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = 'spy_profile.' . $ext;
        move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $filename);
        $newData['photo'] = $filename;
    } else {
        $newData['photo'] = $data['photo'] ?? 'laxit.png';
    }

    file_put_contents($dataFile, json_encode($newData, JSON_PRETTY_PRINT));
    
    // Update activity time on save so we don't get kicked out immediately
    $_SESSION['last_activity'] = time();
    
    header("Refresh:0");
}

$photo = isset($data['photo']) ? 'images/'.$data['photo'] : 'images/laxit.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CLASSIFIED: CASE #000000</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&display=swap');

        /* RESET */
        * { box-sizing: border-box; }

        body {
            /* Tactical Grid Background */
            background-color: #1a1a1a;
            background-image: 
                linear-gradient(rgba(0, 255, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 255, 0, 0.03) 1px, transparent 1px);
            background-size: 20px 20px;
            
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Courier Prime', monospace;
            padding: 20px;
            overflow-x: hidden;
        }

        /* ------------------------------------------- */
        /* HACKER INTRO ANIMATION */
        /* ------------------------------------------- */
        #hacker-intro {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: #000;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: 'Courier Prime', monospace;
            color: #0f0;
        }

        .terminal-text {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .loading-bar {
            width: 300px;
            height: 4px;
            background: #111;
            margin-top: 20px;
            position: relative;
        }
        .progress {
            position: absolute;
            left: 0; top: 0; height: 100%;
            background: #0f0;
            width: 0%;
            animation: loadProgress 2.5s forwards;
        }

        @keyframes loadProgress {
            0% { width: 0%; }
            40% { width: 30%; }
            70% { width: 80%; }
            100% { width: 100%; }
        }

        /* ------------------------------------------- */
        /* THE CASE FILE */
        /* ------------------------------------------- */
        .case-file {
            background: #fdf5e6; /* Manila */
            width: 800px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.8);
            position: relative;
            transform: rotate(-1deg);
            opacity: 0; /* Hidden initially for animation */
            animation: revealFile 1s ease-out 2.8s forwards; /* Starts after hacker intro */
        }

        @keyframes revealFile {
            0% { opacity: 0; transform: scale(0.9) rotate(-1deg); }
            100% { opacity: 1; transform: scale(1) rotate(-1deg); }
        }

        /* Top Tab */
        .case-file::before {
            content: 'TOP SECRET // LVL 5';
            position: absolute;
            top: -35px;
            right: 20px;
            background: #fdf5e6;
            padding: 10px 30px;
            border-radius: 8px 8px 0 0;
            font-weight: bold;
            color: #d00;
            border: 1px solid rgba(0,0,0,0.1);
            border-bottom: none;
        }

        /* The Red Stamp Image */
        .stamp-mark {
            position: absolute;
            top: 150px;
            left: 50%;
            transform: translateX(-50%) rotate(-15deg);
            width: 250px;
            opacity: 0.2;
            pointer-events: none;
            z-index: 0;
        }

        .header-stamp {
            border-bottom: 2px solid #555;
            padding-bottom: 20px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }

        .case-number {
            font-size: 22px;
            font-weight: bold;
            background: #fff;
            padding: 8px 15px;
            border: 2px dashed #333;
            letter-spacing: 1px;
        }

        /* ------------------------------------------- */
        /* POLAROID PHOTO (Updated Size) */
        /* ------------------------------------------- */
        .polaroid {
            background: #fff;
            padding: 10px 10px 35px 10px;
            box-shadow: 2px 4px 15px rgba(0,0,0,0.3);
            transform: rotate(2deg);
            width: 160px; /* Smaller size */
            position: absolute;
            top: 110px;
            right: 40px;
            z-index: 5;
            transition: transform 0.3s;
        }
        
        .polaroid:hover {
            transform: scale(1.1) rotate(0deg);
            z-index: 10;
        }

        .polaroid img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            filter: grayscale(100%) contrast(1.1) sepia(20%);
            border: 1px solid #ddd;
        }

        /* Paperclip */
        .paperclip {
            position: absolute;
            top: -12px;
            right: 40%;
            width: 25px;
            height: 50px;
            border: 3px solid #444;
            border-radius: 15px;
            z-index: 6;
        }

        /* ------------------------------------------- */
        /* DATA GRID */
        /* ------------------------------------------- */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 180px; /* Reserve space for photo */
            gap: 20px;
            position: relative;
            z-index: 1;
        }

        .row { 
            margin-bottom: 12px; 
            border-bottom: 1px dotted #999; 
            padding-bottom: 4px;
            display: flex;
            align-items: baseline;
        }

        .data-label { 
            font-weight: bold; 
            color: #444; 
            margin-right: 15px; 
            min-width: 100px;
        }
        
        .data-value { 
            font-weight: bold; 
            color: #000; 
            text-transform: uppercase; 
            letter-spacing: 0.5px;
            font-size: 15px;
        }

        /* ------------------------------------------- */
        /* MISSIONS BOX */
        /* ------------------------------------------- */
        .missions-box {
            margin-top: 50px;
            border: 2px solid #333;
            padding: 25px;
            background: #fff;
            position: relative;
            background-image: radial-gradient(#ccc 1px, transparent 1px);
            background-size: 10px 10px;
        }
        
        .missions-title {
            position: absolute;
            top: -14px;
            left: 20px;
            background: #fff;
            padding: 0 10px;
            font-weight: bold;
            border: 2px solid #333;
            font-size: 14px;
        }

        /* ------------------------------------------- */
        /* ADMIN PANEL (Fixed Scrolling) */
        /* ------------------------------------------- */
        .admin-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #000;
            color: #0f0;
            border: 1px solid #0f0;
            padding: 10px 20px;
            cursor: pointer;
            font-family: 'Courier Prime';
            letter-spacing: 1px;
            transition: all 0.3s;
            z-index: 50;
        }
        .admin-toggle:hover {
            background: #0f0; color: #000;
            box-shadow: 0 0 15px #0f0;
        }

        #admin-panel {
            display: none;
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: #111;
            color: #fff;
            padding: 30px;
            border: 2px solid #0f0;
            z-index: 100;
            width: 500px;
            box-shadow: 0 0 50px rgba(0,255,0,0.2);
            max-height: 85vh;
            overflow-y: auto;
        }
        
        /* Custom Scrollbar */
        #admin-panel::-webkit-scrollbar { width: 8px; }
        #admin-panel::-webkit-scrollbar-track { background: #000; }
        #admin-panel::-webkit-scrollbar-thumb { background: #0f0; }

        #admin-panel input, #admin-panel textarea {
            width: 100%;
            margin-bottom: 15px;
            background: #000;
            border: 1px solid #333;
            border-bottom: 1px solid #0f0;
            color: #0f0;
            padding: 10px;
            font-family: 'Courier Prime';
            font-size: 14px;
        }
        #admin-panel input:focus, #admin-panel textarea:focus {
            outline: none;
            box-shadow: 0 0 10px rgba(0,255,0,0.2);
        }

    </style>
</head>
<body>

    <div id="hacker-intro">
        <div class="terminal-text">> ESTABLISHING SECURE LINK...</div>
        <div class="terminal-text" id="status-text">> DECRYPTING FILE...</div>
        <div class="loading-bar"><div class="progress"></div></div>
    </div>

    <div class="case-file">
        
        <img src="images/stamp.png" class="stamp-mark" alt="CONFIDENTIAL" onerror="this.style.display='none'">

        <div class="header-stamp">
            <div class="case-number">CASE NO#: 77-BABA-YAGA</div>
            <div style="text-align: right; font-size: 11px; line-height: 1.4;">
                OFFICER: CLASSIFIED<br>
                DATE: <?php echo date('d M Y'); ?><br>
                LOCATION: DESIGN WEB<br>
                CLEARANCE: OMEGA
            </div>
        </div>

        <div class="profile-grid">
            <div class="stats-col">
                <h3 style="border-bottom: 3px double #000; display: inline-block; padding-bottom: 5px;">AGENT PROFILE</h3>
                <br><br>
                
                <div class="row"><span class="data-label">LAST NAME:</span> <span class="data-value"><?php echo explode(' ', $data['profile']['name'])[1]; ?></span></div>
                <div class="row"><span class="data-label">FIRST NAME:</span> <span class="data-value"><?php echo explode(' ', $data['profile']['name'])[0]; ?></span></div>
                <div class="row"><span class="data-label">CODENAME:</span> <span class="data-value" style="color:#d00"><?php echo $data['profile']['alias']; ?></span></div>
                <div class="row"><span class="data-label">AGE:</span> <span class="data-value"><?php echo $data['profile']['age']; ?></span></div>
                <div class="row"><span class="data-label">D.O.B:</span> <span class="data-value"><?php echo $data['profile']['dob']; ?></span></div>
                <div class="row"><span class="data-label">ORIGIN:</span> <span class="data-value"><?php echo $data['profile']['location']; ?></span></div>
                <div class="row"><span class="data-label">ROLE:</span> <span class="data-value"><?php echo $data['profile']['occupation']; ?></span></div>
                <div class="row"><span class="data-label">TRAINING:</span> <span class="data-value"><?php echo $data['profile']['education']; ?></span></div>
            </div>

            <div></div> 
        </div>

        <div class="polaroid">
            <div class="paperclip"></div>
            <img src="<?php echo $photo; ?>" alt="Suspect Photo">
            <div style="text-align:center; font-size:10px; margin-top:5px; color:#666;">SUBJ: <?php echo $data['profile']['alias']; ?></div>
        </div>

        <div class="missions-box">
            <div class="missions-title">ACTIVE MISSIONS / NEXT TARGETS</div>
            <ul style="list-style-type: square; margin-left: 20px; line-height: 1.6;">
                <?php foreach($data['missions'] as $mission): ?>
                    <li style="margin-bottom: 5px;"><?php echo htmlspecialchars($mission); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #d00; border-top: 1px solid #ccc; padding-top: 10px;">
            *** TOP SECRET // EYES ONLY // BURN AFTER READING ***
        </div>

    </div>

    <button class="admin-toggle" onclick="document.getElementById('admin-panel').style.display = 'block'">[ UPDATE INTEL ]</button>

    <div id="admin-panel">
        <h3 style="color: #0f0; border-bottom: 1px solid #0f0; padding-bottom: 10px; margin-bottom: 20px;">UPDATE SPY DATABASE</h3>
        <form method="POST" enctype="multipart/form-data">
            <label>Full Name:</label>
            <input type="text" name="name" value="<?php echo $data['profile']['name']; ?>">
            
            <label>Alias (Code Name):</label>
            <input type="text" name="alias" value="<?php echo $data['profile']['alias']; ?>">
            
            <label>Age:</label>
            <input type="text" name="age" value="<?php echo $data['profile']['age']; ?>">
            
            <label>D.O.B:</label>
            <input type="text" name="dob" value="<?php echo $data['profile']['dob']; ?>">
            
            <label>Location:</label>
            <input type="text" name="location" value="<?php echo $data['profile']['location']; ?>">
            
            <label>Occupation:</label>
            <input type="text" name="occupation" value="<?php echo $data['profile']['occupation']; ?>">
            
            <label>Education:</label>
            <input type="text" name="education" value="<?php echo $data['profile']['education']; ?>">

            <label>Update Photo:</label>
            <input type="file" name="photo" style="border: 1px dashed #0f0; padding: 20px;">

            <label>Missions (One per line):</label>
            <textarea name="missions" rows="5"><?php echo implode("\n", $data['missions']); ?></textarea>

            <button type="submit" name="update_intel" style="background: #0f0; color: #000; border: none; padding: 15px; width: 100%; cursor: pointer; font-weight: bold; font-size: 16px; margin-top: 10px;">SAVE NEW INTEL</button>
            <button type="button" onclick="document.getElementById('admin-panel').style.display = 'none'" style="background: transparent; color: #d00; border: 1px solid #d00; padding: 10px; width: 100%; margin-top: 10px; cursor: pointer;">CLOSE TERMINAL</button>
        </form>
    </div>

    <script>
        // -------------------------------------------
        // AUTO-LOGOUT TIMER (2 Minutes)
        // -------------------------------------------
        const timeoutDuration = 120000; // 120 seconds * 1000 ms

        setTimeout(function() {
            alert("SESSION EXPIRED: SECURITY PROTOCOL INITIATED.");
            window.location.href = 'index.php';
        }, timeoutDuration);

        // -------------------------------------------
        // HACKER INTRO ANIMATION
        // -------------------------------------------
        setTimeout(() => { document.getElementById('status-text').innerText = "> ACCESS GRANTED."; }, 1500);
        setTimeout(() => { document.getElementById('status-text').innerText = "> LOADING PROFILE..."; }, 2200);
        
        // Remove Intro Layer
        setTimeout(() => {
            document.getElementById('hacker-intro').style.transition = 'opacity 0.5s ease';
            document.getElementById('hacker-intro').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('hacker-intro').style.display = 'none';
            }, 500);
        }, 2800);
    </script>

</body>
</html>