<?php
// --- CONFIGURATION ---
$dir = 'book/'; // The folder where your books are

// --- DOWNLOAD HANDLER ---
// This part runs if you click a download link.
// It grabs the file directly from the disk, bypassing URL path issues.
if (isset($_GET['download'])) {
    // 1. Security: Clean the filename to prevent hacking (directory traversal)
    $fileRequested = basename($_GET['download']);
    $filePath = $dir . $fileRequested;

    // 2. Check if file exists
    if (file_exists($filePath)) {
        // 3. Define headers to force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileRequested . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        // 4. Clear output buffer so the file doesn't get corrupted
        if (ob_get_level()) ob_end_clean();
        flush();

        // 5. Send the file
        readfile($filePath);
        exit;
    } else {
        die("Error: File not found on server.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Digital Library</title>
    <style>
        /* --- STYLES (Kept your Classic Library Theme) --- */
        :root {
            --text-color: #f4e4bc;
            --card-bg: rgba(20, 15, 10, 0.85);
            --card-border: rgba(184, 134, 11, 0.4);
            --highlight-gold: #ffd700;
            --muted-gold: #c5a55d;
        }

        body {
            font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif;
            margin: 0;
            padding: 20px;
            color: var(--text-color);
            background-image: url('book/image_0.jpg'); /* Ensure this image is in the folder! */
            background-repeat: repeat;
            background-position: center top;
            min-height: 100vh;
        }

        /* Dark overlay for readability */
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: -1;
        }

        h1 {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 2rem;
            font-weight: normal;
            color: var(--highlight-gold);
            text-shadow: 0 2px 5px rgba(0,0,0,1);
            border-bottom: 2px solid rgba(184, 134, 11, 0.3);
            display: inline-block;
            position: relative;
            left: 50%;
            transform: translateX(-50%);
            padding-bottom: 10px;
        }

        .library-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .book-card {
            width: 180px;
            height: 230px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.6);
            transition: all 0.3s ease;
            position: relative;
            top: 0;
        }

        .book-card:hover {
            top: -10px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.8);
            border-color: var(--highlight-gold);
        }

        .icon {
            font-size: 3rem;
            text-align: center;
            color: var(--muted-gold);
            text-shadow: 0 2px 3px rgba(0,0,0,0.5);
        }

        .title {
            font-weight: bold;
            font-size: 1rem;
            text-align: center;
            color: var(--text-color);
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .meta {
            font-size: 0.75rem;
            color: #a89f91;
            text-align: center;
            font-style: italic;
            margin-bottom: 10px;
        }

        .download-btn {
            display: block;
            text-align: center;
            text-decoration: none;
            background: linear-gradient(to bottom, #b8860b 0%, #8b4513 100%);
            color: #fff;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #5e300d;
        }

        .download-btn:hover {
            background: linear-gradient(to bottom, #c79210 0%, #a05016 100%);
        }
    </style>
</head>
<body>

<h1>My Digital Collection</h1>

<div class="library-container">
    <?php
    if (!is_dir($dir)) {
        echo "<p style='background:rgba(0,0,0,0.8); padding:20px;'>Directory <strong>'book/'</strong> not found.</p>";
    } else {
        $files = glob($dir . '*.{pdf,epub,PDF,EPUB}', GLOB_BRACE);

        if (empty($files)) {
            echo "<p style='background:rgba(0,0,0,0.8); padding:20px;'>No books found.</p>";
        } else {
            foreach ($files as $file) {
                $filename = basename($file);

                // Pretty Title & Size
                $ext = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
                $prettyTitle = preg_replace('/[_-]/', ' ', pathinfo($filename, PATHINFO_FILENAME));
                $filesize = round(filesize($file) / 1024 / 1024, 2) . ' MB';
                $icon = ($ext === 'PDF') ? '📜' : '📕';

                // --- THE FIX ---
                // We create a link back to THIS page with a ?download= parameter.
                // urlencode ensures spaces/symbols don't break the query string.
                $downloadLink = "?download=" . urlencode($filename);

                echo '<div class="book-card">';
                echo '  <div>';
                echo '    <div class="icon">' . $icon . '</div>';
                echo '    <div class="title" title="'.htmlspecialchars($prettyTitle).'">' . htmlspecialchars($prettyTitle) . '</div>';
                echo '    <div class="meta">' . $ext . ' • ' . $filesize . '</div>';
                echo '  </div>';
                echo '  <a href="' . $downloadLink . '" class="download-btn">Retrieve</a>';
                echo '</div>';
            }
        }
    }
    ?>
</div>

</body>
</html>
