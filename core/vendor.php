<?php
  /*
  |----------------------------------------------
  | Themes Sub Path
  |----------------------------------------------
  | If you are using a multi-theme system,
  | set the theme you want to be active.
  |
  */
  define('ACTIVE_THEME', '');


  /*
  |----------------------------------------------
  | Vendor Config
  |----------------------------------------------
  */
  require_once "Engine.php";
  $engine = new Engine(ACTIVE_THEME);