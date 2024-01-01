<?php

$breadcrumbs = [];
function getBreadcrumbs () {
  global $breadcrumbs;
  return $breadcrumbs;
}

function addBreadcrumb($title, $url)
{
  global $breadcrumbs;
  $breadcrumbs[$title] = $url;
}