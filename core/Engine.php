<?php

class Engine
{
  // Engine Settings
  private $setThemesConstruct;

  // Engine Public Config
  public $themes = "themes";
  public $config_file = "config.json";
  public $config = [];

  function __construct($themes_path = "") {
    // Set Themes Path
    if ($themes_path) $this->themes .= "/$themes_path"; $this->setThemesConstruct = true;
    // Import Config File
    if (file_exists($this->themes.SLASH.$this->config_file)) {
      $config_file_open = file_get_contents($this->themes.SLASH.$this->config_file);
      if ($config_file_open) {
        $config_file_array = json_decode($config_file_open, true);
        if (is_array($config_file_array)) $this->config = $config_file_array;
      }
    }
  }

  /**
   * Set Theme Path
   * @param string $themes_path
   */
  public function setTheme($themes_path = "") {
    if (!$this->setThemesConstruct && $themes_path) $this->themes .= "/$themes_path";
  }

  /**
   * Minify Assets File
   * @param array $array
   * @param string $type
   */
  public function minify($array, $type = "script") {
    if (is_array($array)) {
      $fileData = "";
      foreach ($array as $file) {
        if (file_exists($file)) $fileData .= str_replace(["\n", "  "], "", @file_get_contents($file))."\n";
      }
      $cacheTime = strtotime("-1 day 00:00");
      if ($type === "script") list($file, $html) = array("app.js", "<script src='core/assets/app.js?v=$cacheTime'></script>");
      if ($type === "style") list($file, $html) = array("style.css", "<link rel='stylesheet' href='core/assets/style.css?v=$cacheTime'>");
      if (!file_exists('core/assets/'.$file)) fopen('core/assets/'.$file, "w");
      $minifyFile = fopen('core/assets/'.$file, 'w');
      fwrite($minifyFile, $fileData);
      fclose($minifyFile);
      return $html;
    }
  }

  public function loadJS($minifyFileList = []) {
    if (is_array($minifyFileList)) {
      if ($this->config["scripts"]) {
        foreach ($this->config["scripts"] as $localFileDir) {
          if (!in_array($this->themes.SLASH.$localFileDir, $minifyFileList))
            array_push($minifyFileList, $this->themes.SLASH.$localFileDir);
        }
      }
      return $this->minify($minifyFileList, "script");
    }
  }

  public function layout() {

  }
}