<?php

namespace App;

class CaesarCipher
{

  public static function enkripsi($data)
  {
    // Memecah kata menjadi array
    $data_arr = str_split($data);

    $i = 1;
    // Fungsi enkripsi
    $cipherText = '';
    foreach ($data_arr as $isi) {
      if ($i % 2 == 0) {
        $cipherText .= CaesarCipher::geserteks($isi, -$i);
        $i++;
      } else {
        $cipherText .= CaesarCipher::geserteks($isi, $i);
        $i++;
      }
    }

    return $cipherText;
  }

  public static function geserteks($string, $key)
  {
    return implode('', array_map(function ($char) use ($key) {
      return CaesarCipher::geserkarakter($char, $key);
    }, str_split($string)));
  }

  public static function geserkarakter($char, $shift)
  {
    $shift = $shift % 25;
    $ascii = ord($char);
    $shifted = $ascii + $shift;

    if ($ascii >= 65 && $ascii <= 90) {
      return chr(CaesarCipher::geserhurufbesar($shifted));
    }

    if ($ascii >= 97 && $ascii <= 122) {
      return chr(CaesarCipher::geserhurufkecil($shifted));
    }

    if ($ascii >= 33 && $ascii <= 58) {
      return chr(CaesarCipher::geserangka($shifted));
    }

    return chr($ascii);
  }

  public static function geserangka($ascii)
  {
    if ($ascii < 33) {
      $ascii = 59 - (33 - $ascii);
    }

    if ($ascii > 58) {
      $ascii = ($ascii - 58) + 32;
    }
    return $ascii;
  }

  public static function geserhurufbesar($ascii)
  {
    if ($ascii < 65) {
      $ascii = 91 - (65 - $ascii);
    }

    if ($ascii > 90) {
      $ascii = ($ascii - 90) + 64;
    }

    return $ascii;
  }

  public static function geserhurufkecil($ascii)
  {
    if ($ascii < 97) {
      $ascii = 123 - (97 - $ascii);
    }

    if ($ascii > 122) {
      $ascii = ($ascii - 122) + 96;
    }

    return $ascii;
  }
}
