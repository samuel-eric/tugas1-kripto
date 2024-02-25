<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $plainText = $_POST['plain'] ?? '';
  $slope = $_POST['slope'] ?? '';
  $intercept = $_POST['intercept'] ?? '';
  $cipherText = Affine::encrypt($plainText, $slope, $intercept);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Affine Cipher</title>
</head>

<body>
  <div>
    <a href="/index.php">Back to home</a>
  </div>
  <h1>Encrypt Affine Cipher</h1>
  <form method="post">
    <div>
      <label for="plain">Plain text:</label>
      <input type="text" id="plain" name="plain">
    </div>
    <div>
      <label for="slope">Slope: </label>
      <select name="slope" id="slope">
        <option value="1">1</option>
        <option value="3">3</option>
        <option value="5">5</option>
        <option value="7">7</option>
        <option value="9">9</option>
        <option value="11">11</option>
        <option value="15">15</option>
        <option value="17">17</option>
        <option value="19">19</option>
        <option value="21">21</option>
      </select>
    </div>
    <div>
      <label for="intercept">Intercept (pergeseran):</label>
      <input type="number" id="intercept" name="intercept">
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