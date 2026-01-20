<?php

require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Publication;

$publications = Publication::orderBy('id')->get();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Publication Images - HLI Green Power</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: #4D9F95;
            margin-bottom: 30px;
        }
        .publications-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .publication-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .publication-card:hover {
            transform: translateY(-5px);
        }
        .publication-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .publication-info {
            padding: 15px;
        }
        .publication-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 8px;
        }
        .publication-id {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .publication-url {
            font-size: 11px;
            color: #888;
            word-break: break-all;
        }
        .stats {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .stats h2 {
            color: #4D9F95;
            margin: 0 0 10px 0;
        }
        .stats p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📸 All Publication Images</h1>
        
        <div class="stats">
            <h2>Publication Statistics</h2>
            <p><strong>Total Publications:</strong> <?= $publications->count() ?></p>
            <p><strong>Publications with Images:</strong> <?= $publications->whereNotNull('image')->count() ?></p>
            <p><strong>Publications without Images:</strong> <?= $publications->whereNull('image')->count() ?></p>
        </div>

        <div class="publications-grid">
            <?php foreach ($publications as $publication): ?>
                <div class="publication-card">
                    <img 
                        src="<?= $publication->image_url ?>" 
                        alt="<?= htmlspecialchars($publication->title) ?>"
                        class="publication-image"
                        onerror="this.src='https://via.placeholder.com/400x300/4D9F95/FFFFFF?text=Image+Not+Found'"
                    >
                    <div class="publication-info">
                        <div class="publication-id">ID: <?= $publication->id ?></div>
                        <div class="publication-title"><?= htmlspecialchars($publication->title) ?></div>
                        <div class="publication-url"><?= htmlspecialchars($publication->image_url) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
