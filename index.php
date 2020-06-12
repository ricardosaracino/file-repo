<?php

require 'Upload.class.php';

$path = 'storage';

if (isset($_REQUEST['action'])) {

	switch ($_REQUEST['action']) {

		case 'upload':
			if (!empty($_FILES['file'])) {
				$upload = Upload::factory($path);
				$upload->file($_FILES['file']);
				$results = $upload->upload($_FILES['file']['name']);
			}
			break;

		case 'download':
			$fileName = basename($_GET['fileName']);
			$filePath = sprintf('%s/%s', $path, $fileName);
			if (is_file($filePath)) {
				header("Content-Disposition: attachment; filename=\"$fileName\"");
				print(readfile($filePath));
			}
			break;

		case 'delete':
			$fileName = basename($_GET['fileName']);
			$filePath = sprintf('%s/%s', $path, $fileName);
			if (is_file($filePath)) {
				unlink($filePath);
			}
			break;
	}


}

$ls = array_diff(scandir($path), ['.', '..']);

?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>File Repo</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body>

<div class="card-body">

    <form class="p-2" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" value="Upload">
        <input type="hidden" name="action" value="upload">
    </form>

    <br>

	<? array_walk($ls, function ($fileName) {
		printf(
			'<div class="p-2"><a class="btn btn-outline-primary" href="?action=download&fileName=%s" target="_blank">%s</a> <a class="btn btn-danger" href="?action=delete&fileName=%s"><i class="fa fa-close"></i></a></div>',
			$fileName, $fileName, $fileName);
	}) ?>

</div>
</body>
</html>
