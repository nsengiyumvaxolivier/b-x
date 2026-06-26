<?php

$page = $_GET['url'] ?? "login";

$file = $page.".php";
if (file_exists($file)) {
   include($file);
}


?>