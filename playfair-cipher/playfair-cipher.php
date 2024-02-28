<?php

class PlayfairCipher
{
  private static function generateMatrix($key)
  {
    // Buat alfabet yang unik dari kunci
    $keyAlphabet = str_replace('j', '', $key); // hilangkan 'j'
    $keyAlphabet = array_unique(str_split(str_replace(' ', '', strtolower($keyAlphabet))));
    $alphabet = array_merge($keyAlphabet, array_diff(range('a', 'z'), $keyAlphabet));

    // Bentuk matriks 5x5
    $matrix = array_chunk($alphabet, 5);

    return $matrix;
  }

  private static function preparePlainText($plainText)
  {
    // Ubah teks input menjadi huruf kecil dan hilangkan karakter yang tidak diinginkan
    $plainText = preg_replace("/[^a-z]/", "", strtolower($plainText));
    // Ubah 'j' menjadi 'i'
    $plainText = str_replace('j', 'i', $plainText);
    // Pisahkan teks menjadi pasangan huruf
    $pairs = str_split($plainText, 2);
    // Jika panjang terakhir ganjil, tambahkan 'x' pada akhir
    if (strlen(end($pairs)) == 1) {
      $pairs[count($pairs) - 1] .= 'x';
    }

    return $pairs;
  }

  private static function findCharIndex($char, $matrix)
  {
    foreach ($matrix as $rowIndex => $row) {
      foreach ($row as $colIndex => $value) {
        if ($value == $char) {
          return ['row' => $rowIndex, 'col' => $colIndex];
        }
      }
    }
    return null;
  }

  private static function encryptPair($pair, $matrix)
  {
    // Pisahkan pasangan huruf menjadi dua karakter
    $char1 = $pair[0];
    $char2 = $pair[1];

    // Temukan indeks baris dan kolom dari setiap karakter
    $char1Index = PlayfairCipher::findCharIndex($char1, $matrix);
    $char2Index = PlayfairCipher::findCharIndex($char2, $matrix);

    // Jika keduanya berada di baris yang sama, geser ke kanan 1 langkah
    if ($char1Index['row'] == $char2Index['row']) {
      $char1Index['col'] = ($char1Index['col'] + 1) % 5;
      $char2Index['col'] = ($char2Index['col'] + 1) % 5;
    }
    // Jika keduanya berada di kolom yang sama, geser ke bawah 1 langkah
    elseif ($char1Index['col'] == $char2Index['col']) {
      $char1Index['row'] = ($char1Index['row'] + 1) % 5;
      $char2Index['row'] = ($char2Index['row'] + 1) % 5;
    }
    // Jika keduanya tidak berada di baris atau kolom yang sama, bentuk persegi dan ambil karakter yang berada di sudut berlawanan
    else {
      $temp = $char1Index['col'];
      $char1Index['col'] = $char2Index['col'];
      $char2Index['col'] = $temp;
    }

    // Ambil karakter terenkripsi
    $cipherChar1 = $matrix[$char1Index['row']][$char1Index['col']];
    $cipherChar2 = $matrix[$char2Index['row']][$char2Index['col']];

    // Kembalikan pasangan karakter terenkripsi
    return $cipherChar1 . $cipherChar2;
  }

  public static function encrypt($plainText, $key)
  {
    // Generate Playfair matrix
    $matrix = PlayfairCipher::generateMatrix($key);

    // Prepare plaintext
    $pairs = PlayfairCipher::preparePlainText($plainText);

    // Encrypt plaintext
    $cipherText = '';
    foreach ($pairs as $pair) {
      $cipherText .= PlayfairCipher::encryptPair($pair, $matrix);
    }

    return $cipherText;
  }

  private static function prepareCipherText($cipherText)
  {
    // Ubah teks sandi menjadi huruf kecil dan hilangkan karakter yang tidak diinginkan
    $cipherText = preg_replace("/[^a-z]/", "", strtolower($cipherText));
    // Ubah 'j' menjadi 'i'
    $cipherText = str_replace('j', 'i', $cipherText);
    // Pisahkan teks menjadi pasangan huruf
    $pairs = str_split($cipherText, 2);

    return $pairs;
  }

  private static function decryptPair($pair, $matrix)
  {
    // Periksa panjang string
    if (strlen($pair) < 2) {
      // Handle error jika panjang string kurang dari 2 karakter
      return 'X'; // Atau apa pun yang sesuai dengan logika aplikasi Anda
    }

    // Pisahkan pasangan huruf menjadi dua karakter
    $char1 = $pair[0];
    $char2 = $pair[1];

    // Temukan indeks baris dan kolom dari setiap karakter
    $char1Index = PlayfairCipher::findCharIndex($char1, $matrix);
    $char2Index = PlayfairCipher::findCharIndex($char2, $matrix);

    // Check if either character wasn't found in the matrix
    if ($char1Index === false || $char2Index === false) {
      // Handle the case when either character isn't found
      // You can return an error message or any default character here
      return 'X'; // For example, returning 'X' as a placeholder
    }

    // Jika keduanya berada di baris yang sama, geser ke kiri 1 langkah
    if ($char1Index['row'] == $char2Index['row']) {
      $char1Index['col'] = ($char1Index['col'] + 4) % 5;
      $char2Index['col'] = ($char2Index['col'] + 4) % 5;
    }
    // Jika keduanya berada di kolom yang sama, geser ke atas 1 langkah
    elseif ($char1Index['col'] == $char2Index['col']) {
      $char1Index['row'] = ($char1Index['row'] + 4) % 5;
      $char2Index['row'] = ($char2Index['row'] + 4) % 5;
    }
    // Jika keduanya tidak berada di baris atau kolom yang sama, bentuk persegi dan ambil karakter yang berada di sudut berlawanan
    else {
      $temp = $char1Index['col'];
      $char1Index['col'] = $char2Index['col'];
      $char2Index['col'] = $temp;
    }

    // Ambil karakter terdekripsi
    $plainChar1 = $matrix[$char1Index['row']][$char1Index['col']];
    $plainChar2 = $matrix[$char2Index['row']][$char2Index['col']];

    // Kembalikan pasangan karakter terdekripsi
    return $plainChar1 . $plainChar2;
  }

  public static function decrypt($cipherText, $key)
  {
    // Generate Playfair matrix
    $matrix = PlayfairCipher::generateMatrix($key);

    // Prepare ciphertext
    $pairs = PlayfairCipher::prepareCipherText($cipherText);

    // Decrypt ciphertext
    $plainText = '';
    foreach ($pairs as $pair) {
      $plainText .= PlayfairCipher::decryptPair($pair, $matrix);
    }

    return $plainText;
  }
}
