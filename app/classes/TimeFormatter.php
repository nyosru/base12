<?php
namespace App\classes;


class TimeFormatter
{
  public static function dhm($delta)
  {
      $d = intval($delta / (24 * 3600));
      $h = intval($delta % (24 * 3600) / 3600);
      $m = intval($delta % (24 * 3600) % 3600 / 60);
      $s = intval($delta % (24 * 3600) % 3600 % 60);
      return sprintf('%sd %sh %sm', $d, $h, $m);
  }
}