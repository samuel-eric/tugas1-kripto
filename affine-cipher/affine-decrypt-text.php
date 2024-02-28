<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $cipherText = $_POST['cipher'] ?? '';
  $slope = $_POST['slope'] ?? '';
  $intercept = $_POST['intercept'] ?? '';
  $plainText = Affine::decrypt($cipherText, $slope, $intercept);

  $filename = 'decrypt-' . uniqid() . '.txt';
  file_put_contents(__DIR__ . '/../uploads/' . $filename, $plainText);
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Decrypt Affine Cipher</h5>
    <hr>
    <form method="post">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Cipher text:</strong></label>
        <textarea id="cipher" name="cipher" class="form-control" required><?= htmlspecialchars($_POST['cipher'] ?? '') ?></textarea>
      </div>
      <div class="my-3">
        <label for="slope" class="form-label"><strong>Slope:</strong></label>
        <select name="slope" id="slope" class="form-select" required>
          <?php foreach (Affine::$slopeOption as $slope) : ?>
            <option value="<?= $slope ?>" <?= isset($_POST['slope']) && $slope == $_POST['slope'] ? 'selected' : '' ?>><?= $slope ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="my-3">
        <label for="intercept" class="form-label"><strong>Intercept (pergeseran):</strong></label>
        <input type="text" id="intercept" name="intercept" value="<?= htmlspecialchars($_POST['intercept'] ?? '') ?>" class="form-control" required>
      </div>
      <button type="submit" name="submit" class="btn btn-primary">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($plainText)) : ?>
      <p>
        <strong><?= $plainText ?></strong>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download decrypted text file</a>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input cipher text, slope, and intercept</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>