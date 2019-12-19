<?php
  function checkParameter($var, $type)
  {
    return isset($var) && gettype($var)==$type;
  }
?>