<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/body.css">
    <link rel="stylesheet" href="/css/media.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="/js/main.js"></script>
</head>
<body>

<div class="logo"><a href="/">BRAND</a></div>

<input type="checkbox" name="checkbox">

<div class="burger-menu">
  <span></span>
  <span></span>
  <span></span>
</div>

<nav class="navigation"><?php echo app_get_navigation(0, '/', true); ?></nav>

<div id="particle-container">
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
  <div class="particle">B</div>
  <div class="particle">R</div>
  <div class="particle">A</div>
  <div class="particle">N</div>
  <div class="particle">D</div>
</div>