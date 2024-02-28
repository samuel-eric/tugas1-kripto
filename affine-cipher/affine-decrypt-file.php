<?php

require './affine-cipher.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  if ($_FILES['cipher']['error'] === UPLOAD_ERR_OK) {
    $fileLocation = $_FILES['cipher']['tmp_name'];
    $cipherText = file_get_contents($fileLocation);
    $slope = $_POST['slope'] ?? '';
    $intercept = $_POST['intercept'] ?? '';

    if (Affine::checkRelativePrime($slope)) {
      $plainText = Affine::decrypt($cipherText, $slope, $intercept);
      $filename = 'decrypt-' . uniqid() . '.txt';
      file_put_contents(__DIR__ . '/../uploads/' . $filename, $plainText);
    }
  }
}

?>

<?php include __DIR__ . '/../components/_header.php' ?>

<div class="card position-absolute top-50 start-50 translate-middle">
  <div class="card-body">
    <a href="/index.php" class="btn btn-secondary mb-3">Back to home</a>
    <h5 class="card-title fs-3 text-center">Decrypt Affine Cipher with Text File</h5>
    <hr>
    <form method="post" enctype="multipart/form-data">
      <div class="my-3">
        <label for="cipher" class="form-label"><strong>Cipher text file:</strong></label>
        <input type="file" name="cipher" id="cipher" accept=".txt" class="form-control" required>
      </div>
      <div class="my-3">
        <label for="slope" class="form-label"><strong>Slope:</strong></label>
        <input type="number" id="slope" name="slope" class="form-control" value="<?= htmlspecialchars($_POST['slope'] ?? '') ?>" min=1>
      </div>
      <div class="my-3">
        <label for="intercept" class="form-label"><strong>Intercept (pergeseran):</strong></label>
        <input type="number" id="intercept" name="intercept" class="form-control" value="<?= htmlspecialchars($_POST['intercept'] ?? '') ?>" required min=0>
      </div>
      <button type="submit" name="submit" class="btn btn-primary w-100 p-2">Decrypt</button>
    </form>
    <hr>
    <?php if (isset($plainText)) : ?>
      <p>
        <strong>Output:</strong> <?= $plainText ?>
      </p>
      <p>
        <a href="/uploads/<?= $filename ?>" download>Download decrypted text file</a>
      </p>
      <p>
        <strong>Output (base64):</strong> <?= base64_encode($plainText) ?>
      </p>
    <?php else : ?>
      <?php if (!empty($slope) && !Affine::checkRelativePrime($slope)) : ?>
        <div class="alert alert-danger text-center" role="alert">
          <?= $slope ?> is not relatively prime to 26!
        </div>
      <?php else : ?>
        <div class="alert alert-info text-center">
          <strong>Please input cipher text file, slope, intercept</strong>
        </div>
      <?php endif ?>
    <?php endif ?>
  </div>
</div>

<?php include __DIR__ . '/../components/_footer.php'; ?>