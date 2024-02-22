<?php

require './extended-vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $tmp = explode('.', $_FILES['plain']['name']);
    $ext = end($tmp);
    $key = $_POST['key'] ?? '';
    ExtendedVigenere::encrypt($_FILES['plain'], $key);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Extended Vigenere Cipher</title>
</head>

<body>
  <div>
    <a href="/index.php">Back to home</a>
  </div>
  <h1>Encrypt Extended Vigenere Cipher with File</h1>
  <form method="post" enctype="multipart/form-data">
    <div>
      <label for="plain">Plain file:</label>
      <input type="file" name="plain" id="plain">
    </div>
    <div>
      <label for="key">Key:</label>
      <input type="text" id="key" name="key">
    </div>
    <button type="submit" name="submit">Encrypt</button>
  </form>
  <?php if (isset($_FILES['plain']['tmp_name'])) : ?>
    <p>
      <a href="/uploads/encrypt.<?= $ext ?>" download>Download file</a>
    </p>
  <?php else : ?>
    <p>
      <strong>Please upload a file</strong>
    </p>
  <?php endif ?>
</body>

</html>