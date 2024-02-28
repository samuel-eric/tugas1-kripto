<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['plain']['error'] === UPLOAD_ERR_OK) {
    $fileLocation = $_FILES['plain']['tmp_name'];
    $plainText = file_get_contents($fileLocation);
    $slope = $_POST['slope'] ?? '';
    $intercept = $_POST['intercept'] ?? '';
    $cipherText = Affine::encrypt($plainText, $slope, $intercept);

    $filename = 'encrypt-' . uniqid() . '.txt';
    file_put_contents(__DIR__ . '/../uploads/' . $filename, $cipherText);
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3">Encrypt Affine Cipher with Text File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="plain" class="form-label"><strong>Plain text file:</strong></label>
        <input type="file" name="plain" id="plain" accept=".txt" class="form-control" required>
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
      <button type="submit" name="submit" class="btn btn-primary">Encrypt</button>
    </form>
    <hr>
    <?php if (isset($cipherText)) : ?>
      <p>
        <strong>Output:</strong> <?= $cipherText ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download encrypted text file</a>
      </p>
      <p>
        <strong>Output (base64):</strong> <?= base64_encode($cipherText) ?>
      </p>
    <?php else : ?>
      <p>
        <strong>Please input plain text file, slope, and intercept</strong>
      </p>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>