<?php

require './vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $cipherText = $_POST['cipher'] ?? '';
  $key = $_POST['key'] ?? '';
  $plainText = Vigenere::decrypt($cipherText, $key);
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
  <h1>Decrypt Vigenere Cipher</h1>
  <form method="post">
    <div>
      <label for="cipher">Cipher text:</label>
      <input type="text" id="cipher" name="cipher" value="<?= $_POST['cipher'] ?? '' ?>">
    </div>
    <div>
      <label for="key">Key:</label>
      <input type="text" id="key" name="key" value="<?= $_POST['key'] ?? '' ?>">
    </div>
    <button type="submit" name="submit">Decrypt</button>
  </form>
  <?php if (isset($plainText)) : ?>
    <p>
      <strong><?= $plainText ?></strong>
    </p>
  <?php else : ?>
    <p>
      <strong>Please input some text</strong>
    </p>
  <?php endif ?>
</body>

</html>