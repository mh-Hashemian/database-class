<?php

function redirect($url)
{
  header("Location: " . $url);
}

function base_path($path)
{
  return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
  extract($attributes);

  require base_path('views/' . $path);
}

function convertToPersianNumber($input)
{
  $persianDigits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
  $englishDigits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

  return str_replace($englishDigits, $persianDigits, $input);
}

$formatter = new IntlDateFormatter(
  "fa_IR@calendar=persian",
  IntlDateFormatter::FULL,
  IntlDateFormatter::FULL,
  'Asia/Tehran',
  IntlDateFormatter::TRADITIONAL,
  "yyyy/MM/dd");
$formatter->setPattern("yyyy/MM/dd");

function formatDate($date) {
  global $formatter;
  return $formatter->format(date_create($date));
}
