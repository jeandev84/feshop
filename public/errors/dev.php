<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <link rel="stylesheet" href="/errors/css/error.css">
</head>
<body>
   <h1>Error</h1>
   <p><b>Code:</b> <?= $errno ?></p>
   <p><b>Message:</b> <?= $errstr ?></p>
   <p><b>File:</b> <?= $errfile ?></p>
   <p><b>Line:</b><?= $errline ?></p>
</body>
</html>