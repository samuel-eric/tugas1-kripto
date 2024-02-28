<?php

require __DIR__ . '/../vigenere-cipher/vigenere-cipher.php';

class ProductCipher
{
  private static function getShiftIndexes($key)
  {
    $keyLength = strlen($key);
    $indexes = array();
    $sortedKey = array();

    for ($i = 0; $i < $keyLength; ++$i) {
      $pair = new KeyValuePair();
      $pair->Key = $i;
      $pair->Value = $key[$i];
      $sortedKey[] = $pair;
    }

    usort($sortedKey, 'compare');
    $i = 0;

    for ($i = 0; $i < $keyLength; ++$i)
      $indexes[$sortedKey[$i]->Key] = $i;

    return $indexes;
  }


  private static function encipher($input, $key, $padChar)
  {
    $output = "";
    $totalChars = strlen($input);
    $keyLength = strlen($key);
    $input = ($totalChars % $keyLength == 0) ? $input : str_pad($input, $totalChars - ($totalChars % $keyLength) + $keyLength, $padChar, STR_PAD_RIGHT);
    $totalChars = strlen($input);
    $totalColumns = $keyLength;
    $totalRows = ceil($totalChars / $totalColumns);
    $rowChars = array(array());
    $colChars = array(array());
    $sortedColChars = array(array());
    $currentRow = 0;
    $currentColumn = 0;
    $i = 0;
    $j = 0;
    $shiftIndexes = ProductCipher::getShiftIndexes($key);

    for ($i = 0; $i < $totalChars; ++$i) {
      $currentRow = $i / $totalColumns;
      $currentColumn = $i % $totalColumns;
      $rowChars[$currentRow][$currentColumn] = $input[$i];
    }

    for ($i = 0; $i < $totalRows; ++$i)
      for ($j = 0; $j < $totalColumns; ++$j)
        $colChars[$j][$i] = $rowChars[$i][$j];

    for ($i = 0; $i < $totalColumns; ++$i)
      for ($j = 0; $j < $totalRows; ++$j)
        $sortedColChars[$shiftIndexes[$i]][$j] = $colChars[$i][$j];

    for ($i = 0; $i < $totalChars; ++$i) {
      $currentRow = $i / $totalRows;
      $currentColumn = $i % $totalRows;
      $output .= $sortedColChars[$currentRow][$currentColumn];
    }

    return $output;
  }

  private static function transposeencrypt($text, $key)
  {
    // Memanggil fungsi Encipher dengan teks dan kunci yang diberikan
    return ProductCipher::encipher($text, $key, ' ');
  }

  public static function encrypt($plainText, $key)
  {
    $cipherText = Vigenere::encrypt($plainText, $key);
    $cipherText = ProductCipher::transposeencrypt($cipherText, $key);
    return $cipherText;
  }

  public static function decrypt($cipherText, $key)
  {
    $plainText = ProductCipher::transposedecrypt($cipherText, $key);
    $plainText = Vigenere::decrypt($plainText, $key);
    return $plainText;
  }

  private static function decipher($input, $key)
  {
    $output = "";
    $keyLength = strlen($key);
    $totalChars = strlen($input);
    $totalColumns = ceil($totalChars / $keyLength);
    $totalRows = $keyLength;
    $rowChars = array(array());
    $colChars = array(array());
    $unsortedColChars = array(array());
    $currentRow = 0;
    $currentColumn = 0;
    $i = 0;
    $j = 0;
    $shiftIndexes = ProductCipher::GetShiftIndexes($key);

    for ($i = 0; $i < $totalChars; ++$i) {
      $currentRow = $i / $totalColumns;
      $currentColumn = $i % $totalColumns;
      $rowChars[$currentRow][$currentColumn] = $input[$i];
    }

    for ($i = 0; $i < $totalRows; ++$i)
      for ($j = 0; $j < $totalColumns; ++$j)
        $colChars[$j][$i] = $rowChars[$i][$j];

    for ($i = 0; $i < $totalColumns; ++$i)
      for ($j = 0; $j < $totalRows; ++$j)
        $unsortedColChars[$i][$j] = $colChars[$i][$shiftIndexes[$j]];

    for ($i = 0; $i < $totalChars; ++$i) {
      $currentRow = $i / $totalRows;
      $currentColumn = $i % $totalRows;
      $output .= $unsortedColChars[$currentRow][$currentColumn];
    }

    return $output;
  }

  private static function transposedecrypt($text, $key)
  {
    // Memanggil fungsi Encipher dengan teks dan kunci yang diberikan
    return ProductCipher::decipher($text, $key, ' ');
  }
}

function compare($first, $second)
{
  return strcmp($first->Value, $second->Value);
}

class KeyValuePair
{
  public $Key;
  public $Value;
}
