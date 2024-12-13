<?php
if (!function_exists('showMessage')) {
  function showMessage($msg, $type = 'success')
  {
    if ($msg) {
      return '<div class="alert alert-' . ($type != '' ? $type : 'success') . '">' . $msg . ' </div>';
    }
    return '';
  }
}
