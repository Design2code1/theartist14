<?php
session_start();

// Check if logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Load files
$files = [];
$dataFile = '../data/files.json';

if (file_exists($dataFile)) {
    $files = json_decode(file_get_contents($dataFile), true) ?? [];
}

// Handle file operations
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // UPLOAD FILE
    if (isset($_POST['action']) && $_POST['action'] === 'upload') {
        $productName = trim($_POST['product_name'] ?? '');
        
        if (empty($productName)) {
            $message = 'Product name is required';
            $messageType = 'error';
        } elseif (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            
            // Create directories if they don't exist
            if (!is_dir('../uploads')) mkdir('../uploads', 0755, true);
            if (!is_dir('../data')) mkdir('../data', 0755, true);
            
            $fileExt = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $fileName = time() . '_' . uniqid() . '.' . $fileExt;
            $uploadPath = '../uploads/' . $fileName;
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath)) {
                $files[] = [
                    'id' => time() . rand(1000, 9999),
                    'product_name' => $productName,
                    'filename' => $fileName,
                    'upload_date' => date('Y-m-d'),
                    'file_type' => $fileExt,
                    'file_size' => round($_FILES['file']['size'] / 1024 / 1024, 2) . 'MB'
                ];
                
                file_put_contents($dataFile, json_encode($files, JSON_PRETTY_PRINT));
                $message = 'File filed to archives successfully!';
                $messageType = 'success';
            } else {
                $message = 'Failed to upload file to archives';
                $messageType = 'error';
            }
        } else {
            $message = 'Please select a manuscript/file';
            $messageType = 'error';
        }
    }
    
    // DELETE FILE
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $fileId = $_POST['file_id'] ?? '';
        
        foreach ($files as $key => $file) {
            if ($file['id'] == $fileId) {
                // Delete physical file
                $filePath = '../uploads/' . $file['filename'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                
                // Remove from array
                unset($files[$key]);
                $files = array_values($files);
                
                file_put_contents($dataFile, json_encode($files, JSON_PRETTY_PRINT));
                $message = 'Record redacted successfully!';
                $messageType = 'success';
                break;
            }
        }
    }
    
    // UPDATE FILE
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $fileId = $_POST['file_id'] ?? '';
        $newProductName = trim($_POST['product_name'] ?? '');
        
        if (!empty($newProductName)) {
            foreach ($files as $key => $file) {
                if ($file['id'] == $fileId) {
                    $files[$key]['product_name'] = $newProductName;
                    file_put_contents($dataFile, json_encode($files, JSON_PRETTY_PRINT));
                    $message = 'Record updated successfully!';
                    $messageType = 'success';
                    break;
                }
            }
        }
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editorial Desk - Laxit Thummar</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Old+Standard+TT:wght@400;700&family=Playfair+Display:wght@400;700;900&display=swap');

        /* RESET & BASE */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: #f5f1e8;
            color: #1a1a1a;
            font-family: 'Old Standard TT', serif;
            line-height: 1.6;
            min-height: 100vh;
        }

        /* TEXTURE OVERLAY */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(0,0,0,.03) 2px, rgba(0,0,0,.03) 4px);
            pointer-events: none;
            z-index: 9999;
        }

        /* LAYOUT CONTAINER */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* MASTHEAD (ADMIN VERSION) */
        .admin-masthead {
            border-bottom: 4px double #000;
            margin-bottom: 30px;
            padding-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 20px;
        }

        .masthead-title {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 900;
            text-transform: uppercase;
            line-height: 1;
        }

        .masthead-meta {
            font-size: 14px;
            font-style: italic;
            color: #666;
        }

        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #000;
            background: #fff;
            color: #000;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            text-transform: uppercase;
            text-decoration: none;
            font-size: 12px;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn:hover {
            background: #000;
            color: #fff;
        }

        .btn-logout {
            background: #000;
            color: #fff;
        }
        .btn-logout:hover {
            background: #333;
        }

        .btn-small {
            padding: 5px 10px;
            font-size: 10px;
            margin-right: 5px;
        }

        .btn-delete:hover {
            background: #8b0000; /* Dark red for delete */
            border-color: #8b0000;
        }

        /* ALERTS */
        .message-box {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
            font-style: italic;
        }
        .message-box.success { background-color: #d4edda; border-color: #155724; color: #155724; }
        .message-box.error { background-color: #f8d7da; border-color: #721c24; color: #721c24; }

        /* CONTENT GRID */
        .content-grid {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 30px;
            align-items: start;
        }

        /* FORM SECTION (LEFT) */
        .editor-desk {
            background: #e8dcc5;
            border: 3px solid #000;
            padding: 20px;
            box-shadow: 5px 5px 0 rgba(0,0,0,0.2);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 900;
            text-transform: uppercase;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            margin-bottom: 5px;
            font-family: 'Playfair Display', serif;
        }

        input[type="text"], 
        input[type="file"] {
            width: 100%;
            padding: 10px;
            background: #fff;
            border: 1px solid #000;
            border-radius: 0;
            font-family: 'Old Standard TT', serif;
            font-size: 16px;
            outline: none;
        }

        input[type="text"]:focus {
            background: #fffdf5;
            border-left: 5px solid #000;
        }

        /* TABLE SECTION (RIGHT) */
        .records-section {
            border: 1px solid #000;
            background: #fff;
            padding: 20px;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .records-table th {
            text-align: left;
            border-bottom: 3px double #000;
            padding: 10px;
            font-family: 'Playfair Display', serif;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 14px;
        }

        .records-table td {
            border-bottom: 1px solid #ccc;
            padding: 10px;
            font-size: 15px;
        }

        .records-table tr:last-child td {
            border-bottom: none;
        }

        .records-table tr:hover {
            background-color: #f9f9f9;
        }

        .file-meta {
            font-size: 12px;
            color: #666;
            font-style: italic;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            backdrop-filter: blur(2px);
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #f5f1e8;
            border: 4px double #000;
            width: 90%;
            max-width: 500px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            position: relative;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
        }

        /* NAVIGATION BACK */
        .nav-back {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 20px;
        }

        .nav-back a {
            color: #666;
            text-decoration: none;
            font-style: italic;
            border-bottom: 1px solid transparent;
        }
        .nav-back a:hover {
            border-bottom: 1px solid #000;
            color: #000;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .masthead-title {
                font-size: 32px;
            }
            .records-table th:nth-child(3), 
            .records-table th:nth-child(4), 
            .records-table td:nth-child(3), 
            .records-table td:nth-child(4) {
                display: none; /* Hide date/type on mobile */
            }
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <header class="admin-masthead">
            <div>
                <div class="masthead-title">The Editorial Desk</div>
                <div class="masthead-meta">Authorized Personnel Only | System Admin: Laxit Thummar</div>
            </div>
            <a href="?logout=1" class="btn btn-logout">Sign Out</a>
        </header>

        <?php if ($message): ?>
            <div class="message-box <?php echo $messageType; ?>">
                NEWS FLASH: <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="content-grid">
            
            <aside class="editor-desk">
                <h2 class="section-title">Submit New Record</h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload">
                    
                    <div class="form-group">
                        <label for="product_name">Headline / Product Name</label>
                        <input type="text" 
                               id="product_name" 
                               name="product_name" 
                               required 
                               placeholder="Ex: Project Alpha Design...">
                    </div>

                    <div class="form-group">
                        <label for="file">Attachment (PDF/IMG)</label>
                        <input type="file" 
                               id="file" 
                               name="file" 
                               required 
                               accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                    </div>

                    <button type="submit" class="btn" style="width: 100%;">Publish to Archives</button>
                </form>

                <div style="margin-top: 30px; border-top: 2px solid #000; padding-top: 15px;">
                    <p style="font-size: 12px; font-style: italic; text-align: justify;">
                        <strong>NOTICE:</strong> All submitted files are immediately available in the public archives. Ensure copyright compliance before publishing.
                    </p>
                </div>
            </aside>

            <main class="records-section">
                <h2 class="section-title">Current Archives (<?php echo count($files); ?>)</h2>
                
                <?php if (empty($files)): ?>
                    <div style="padding: 40px; text-align: center; color: #666; font-style: italic;">
                        📭 No records found in the filing cabinet.
                    </div>
                <?php else: ?>
                    <div style="overflow-x: auto;">
                        <table class="records-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>File</th>
                                    <th>Filed On</th>
                                    <th>Meta</th>
                                    <th style="text-align: right;">Editorial Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $file): ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($file['product_name']); ?></strong>
                                        </td>
                                        <td style="font-family: monospace; font-size: 12px;">
                                            <?php echo htmlspecialchars($file['filename']); ?>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($file['upload_date'])); ?></td>
                                        <td class="file-meta">
                                            <?php echo strtoupper($file['file_type']); ?><br>
                                            <?php echo $file['file_size'] ?? 'N/A'; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <button class="btn btn-small" 
                                                    onclick="openEditModal('<?php echo $file['id']; ?>', '<?php echo htmlspecialchars($file['product_name'], ENT_QUOTES); ?>')">
                                                Revise
                                            </button>
                                            <button class="btn btn-small btn-delete" 
                                                    onclick="deleteFile('<?php echo $file['id']; ?>', '<?php echo htmlspecialchars($file['product_name'], ENT_QUOTES); ?>')">
                                                Redact
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </main>

        </div>

        <div class="nav-back">
            <a href="../index.php">← Return to Front Page Edition</a>
        </div>

    </div>

    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="font-family: 'Playfair Display'; text-transform: uppercase;">Issue Correction</h3>
            </div>
            
            <form method="POST">
                <input type="hidden" name="action" value="update">
                <input type="hidden" id="edit_file_id" name="file_id">
                
                <div class="form-group">
                    <label for="edit_product_name">Revised Headline</label>
                    <input type="text" 
                           id="edit_product_name" 
                           name="product_name" 
                           required>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn" style="flex: 1;">Apply Correction</button>
                    <button type="button" class="btn" style="flex: 1; background: #ccc; border-color: #999;" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <form id="deleteForm" method="POST" style="display: none;">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" id="delete_file_id" name="file_id">
    </form>

    <script>
        function openEditModal(fileId, productName) {
            document.getElementById('edit_file_id').value = fileId;
            document.getElementById('edit_product_name').value = productName;
            document.getElementById('editModal').classList.add('active');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function deleteFile(fileId, productName) {
            if (confirm('CONFIRM REDACTION:\n\nAre you sure you want to permanently remove "' + productName + '" from the archives?\n\nThis action cannot be undone.')) {
                document.getElementById('delete_file_id').value = fileId;
                document.getElementById('deleteForm').submit();
            }
        }

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
</body>
</html>