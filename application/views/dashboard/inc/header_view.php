<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TweetNote Build</title>
    <link href="<?=base_url()?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url()?>public/css/style.css" rel="stylesheet">
    <script src="<?=base_url()?>public/js/jquery.js"></script>
    <script src="<?=base_url()?>public/js/bootstrap.min.js"></script>
    <script src="<?=base_url()?>public/js/tweetnote/dashboard/event.js"></script>
    <script src="<?=base_url()?>public/js/tweetnote/dashboard/result.js"></script>
    <script src="<?=base_url()?>public/js/tweetnote/dashboard/template.js"></script>
    <script src="<?=base_url()?>public/js/tweetnote/dashboard.js"></script>
    <script src='https://cdn.firebase.com/v0/firebase.js'></script>
    <script type='text/javascript' src='https://cdn.firebase.com/js/simple-login/1.3.0/firebase-simple-login.js'></script>
    <script>$(function() { var dashboard = new Dashboard(); });</script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <div class="wrapper">

  <nav>
    <ul class="nav nav-pills">
      <li class="active"><a href="#">Dashboard</a></li>
      <li><a href="#">User</a></li>
      <li><a href="<?=site_url('dashboard/logout')?>">Logout</a></li>
    </ul>
  </nav>

  <div id="error" class="bg-danger hide"></div>
  <div id="success" class="bg-success hide"></div>