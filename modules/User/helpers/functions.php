<?php
function showMessage($msg, $type = '')
{

  if ($msg) {
    return '<div class="alert alert-' . ($type != '' ? $type : 'success') . '">' . $msg . ' </div>';
  }
  return '';
}