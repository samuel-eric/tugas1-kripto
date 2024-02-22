<?php

require './vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $fileLocation = $_FILES['plain']['tmp_name'];
    $plainText = file_get_contents($fileLocation);
    $key = $_POST['key'] ?? '';
    $cipherText = Vigenere::encrypt($plainText, $key);
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vigenere Cipher</title>
</head>

<body>
  <div>
    <a href="/index.php">Back to home</a>
  </div>
  <h1>Encrypt Vigenere Cipher with File</h1>
  <form method="post" enctype="multipart/form-data">
    <div>
      <label for="plain">Plain text file:</label>
      <input type="file" name="plain" id="plain" accept=".txt">
    </div>
    <div>
      <label for="key">Key:</label>
      <input type="text" id="key" name="key">
    </div>
    <button type="submit" name="submit">Encrypt</button>
  </form>
  <?php if (isset($cipherText)) : ?>
    <p>
      <strong><?= $cipherText ?></strong>
    </p>
  <?php else : ?>
    <p>
      <strong>Please input some text</strong>
    </p>
  <?php endif ?>
</body>

</html>