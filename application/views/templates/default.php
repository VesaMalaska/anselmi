<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="fi">
<head>
	<meta charset="utf-8">

  <!-- BOOTSTRAP CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <!-- FONTAWESOME CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <!-- SITE STYLESHEET CSS -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">

	<!-- FONTS -->

	<!-- LOGO FONT -->
	<link href="https://fonts.googleapis.com/css?family=Barlow+Condensed" rel="stylesheet">

  <!-- PAGE HEADING FONT -->
  <link href="https://fonts.googleapis.com/css?family=Cantata+One" rel="stylesheet">

	<title>Anselmi</title>

</head>
<body>

<!-- -->


<div class="row p-0 m-0 h-100">

  <!-- LEFT SIDEBAR -->
  <div class="left-sidebar">

		<!-- LOGO -->
    <div class="logo-wrapper">
      <a class="logo" href="<?php echo base_url(); ?>">Anselmi</a>
    </div>

    <!-- OPERATOR CONTROLS -->
    <div class="operator-controls-wrapper">
      <li class="nav-item dropdown">
        <a class="" href="user" role="button">
          <img src="<?php echo base_url(); ?>assets/images/default-user.png" alt="<?php echo $username; ?>" class="rounded-circle user-pic-small">
          <?php echo $username; ?>

        </a>
        <div class="operator-online-status-controls">

          <div class="dropdown-divider"></div>
          <div class="row mx-0">
            <div class="col-3 pr-0 pt-1"><i class="fas fa-sign-out-alt"></i></div>
            <div class="col px-0"><a class="dropdown-item px-1" href="<?php echo base_url(); ?>auth/logout"> Log out</a></div>
            <div class="col-2 pl-0 pt-1"></div>
          </div>
        </div>
      </li>
    </div> <!-- END OF OPERATOR CONTROLS -->

    <div class="left-sidebar-divider"></div>

    <!-- CHAT SESSIONS CONTAINER, CONTENT CREATED DYNAMICALLY WITH JS -->
    <div id="incoming_chat_requests"></div>

		<div class="left-sidebar-divider"></div>

    <!-- CHAT SESSIONS CONTAINER, CONTENT CREATED DYNAMICALLY WITH JS -->
    <div id="ongoing_chat_sessions"></div>

  </div> <!-- END OF LEFT SIDEBAR -->

  <div class="vertical-navbar-wrapper">
    <nav class="vertical-nav" style="z-index:1;">
      <ul class="nav flex-column text-center">
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url(); ?>" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Dashboard</em>"><i class="fas fa-tachometer-alt"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>users" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>K&auml;ytt&auml;j&auml;t</em>"><i class="fas fa-user-cog"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>chat_session" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Chat-keskustelut</em>"><i class="far fa-comments"></i></a>
        </li>
				<li class="nav-item">
          <a class="nav-link" href="<?php echo base_url(); ?>newsletter" data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Uutiskirjeiden l&auml;hetys</em>"><i class="fas fa-mail-bulk"></i></a>
        </li>
      </ul>
    </nav>
  </div>

  <div class="col p-0">

		<?php	if(isset($page_title)) { ?>
    <!-- PAGE HEADING -->
    <div class="container-fluid page-heading">
      <h2><?php echo $page_title; ?></h2>
    </div>
		<?php	} ?>

    <div class="container-fluid py-3">
      <?php echo $body; ?>
    </div>

  </div>
</div>

<!-- -->


	<!-- CKEDITOR JS -->
  <script src="http://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

  <!-- JQUERY -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

  <!-- BOOTSTRAP JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>

	<!-- MAIN JS -->
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>

  <!-- Replace the textareas with id editor1 with the CKEditor -->
  <script>CKEDITOR.replace( 'editor1' );</script>
</body>
</html>
