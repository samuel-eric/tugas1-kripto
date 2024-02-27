<?php

require './vigenere-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $plainText = $_POST['plain'] ?? '';
  $key = $_POST['key'] ?? '';
  $cipherText = Vigenere::encrypt($plainText, $key);

  file_put_contents(__DIR__ . '/../uploads/encrypt.txt', $cipherText);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Encrypt Vigenere Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain text:</strong></label>
        <input type="text" id="plain" name="plain" value="<?= htmlspecialchars($_POST['plain'] ?? '') ?>" class="form-control">
      </div>
      <div class="my-3">
        <label for="key" class="form-label"><strong>Key:</strong></label>
        <input type="text" id="key" name="key" value="<?= htmlspecialchars($_POST['key'] ?? '') ?>" class="form-control">
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($cipherText)) : ?>
      <p>
        <strong><?= $cipherText ?></strong>
      </p>
      <p>
        <a href="/uploads/encrypt.txt" download>Download encrypted text file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input some text</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>