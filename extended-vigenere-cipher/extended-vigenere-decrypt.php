<?php

require './extended-vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['cipher']['error'] === UPLOAD_ERR_OK) {
    $tmp = explode('.', $_FILES['cipher']['name']);
    $ext = end($tmp);
    $key = $_POST['key'] ?? '';
    ExtendedVigenere::decrypt($_FILES['cipher'], $key);
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
  <h1>Decrypt Extended Vigenere Cipher with File</h1>
  <form method="post" enctype="multipart/form-data">
    <div>
      <label for="cipher">Encrypted file:</label>
      <input type="file" name="cipher" id="cipher">
    </div>
    <div>
      <label for="key">Key:</label>
      <input type="text" id="key" name="key">
    </div>
    <button type="submit" name="submit">Decrypt</button>
  </form>
  <?php if (isset($_FILES['cipher']['tmp_name'])) : ?>
    <p>
      <a href="/uploads/decrypt.<?= $ext ?>" download>Download file</a>
    </p>
  <?php else : ?>
    <p>
      <strong>Please upload a file</strong>
    </p>
  <?php endif ?>
</body>

</html>