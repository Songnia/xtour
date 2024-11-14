<?php

  // Definir le chemin de base du projet
  define("BASE_URL", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/");

  // Definir le chemin absolut des pages
  define("PAGES_URL", BASE_URL . "pages/" );
  define("INCLUDES_URL", BASE_URL ."includes/");
  define("ASSETS_URL", BASE_URL ."assets/");
?>