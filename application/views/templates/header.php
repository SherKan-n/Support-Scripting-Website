<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="author" content="SherKan">
		<title>Extended Support Scripting</title>
		<meta http-equiv="refresh" content="1000; url=logout">
		<!-- meta name="google-signin-scope" content="profile email" -->
		<link rel="icon" type="image/png" href="assets/img/logo.png">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<!--meta name="google-signin-client_id" content="923946516065-u6he46kcomibm38n0vfsgkurlqgf0ob8.apps.googleusercontent.com"-->
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.css">
		<link rel="stylesheet" href="assets/css/paper_dashboard.css">
		<link rel="stylesheet" href="assets/css/animate.css">
		<link rel="stylesheet" href="assets/css/styles.css">
		<!-- JS -->
		<!--script src="https://apis.google.com/js/platform.js" async defer></script-->
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
		<script src="https://kit.fontawesome.com/4bd747b15e.js" crossorigin="anonymous"></script>

		
	</head>
<body>
	<div class="wrapper">
		<?=$this->session->flashdata('messageError');?>
		<div class="sidebar" data-color="dark" data-active-color="danger">
			<div class="logo">
				<a href="home" class="simple-text"><i class="fas fa-chess-pawn" style="font-size: 30px; margin-right: 20px; margin-left: 14px;"></i>Support Scripting</a>
			</div>
			<div class="sidebar-wrapper">
				<ul class="nav">
				<?php if($this->session->page == 'Home') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="home">
						<i class="fas fa-home"></i>
						<p>Home</p>
					</a>
				</li>
				<?php if($this->session->logged == 1):
					if($this->session->page == 'Profile') echo "<li class=\"active\">"; else echo "<li>"; ?>
						<a href="profile">
							<i class="fas fa-user"></i>
							<p>Profile</p>
						</a>
					</li>
				<?php endif; ?>
				<?php if($this->session->admin > 0):
					if($this->session->page == 'Admin Panel') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="<?=current_url();?>">
						<i class="fas fa-shield-alt"></i>
						<p>Admin Panel</p>
					</a>
					<ul class="submenu">
						<li><a href="punish_user">Punish User</a></li>
						<li><a href="edit_user">Edit User</a></li>
						<li><a href="manager_admins">Manager Admins</a></li>
						<li><a href="manager_helpers">Manager Helpers</a></li>
					</ul>
				</li>
				<?php endif; ?>
				<?php if($this->session->page == 'Staff') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="staff">
						<i class="fas fa-user-shield"></i>
						<p>Staff</p>
					</a>
				</li>
				<?php if($this->session->page == 'Ban List') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="banlist">
						<i class="fas fa-user-lock"></i>
						<p>Ban List</p>
					</a>
				</li>
				<?php if($this->session->page == 'Search') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="search">
						<i class="fas fa-search"></i>
						<p>Search</p>
					</a>
				</li>
				<?php if($this->session->page == 'Tops') echo "<li class=\"active\">"; else echo "<li>"; ?>
					<a href="tops">
						<i class="fas fa-sitemap"></i>
						<p>Tops</p>
					</a>
				</li>
				<li>
					<a href="minigames">
						<i class="far fa-compass"></i>
						<p>More</p>
					</a>
				</li>
				<?php if($this->session->has_userdata('username')):
					if(($this->user_model->extract_data($this->session->username))->premium == 0): ?>
					<li class="active-pro">
						<a href="upgrade">
							<i class="fas fa-rocket" style="color:#0cb300"></i>
							<p>Upgrade to PRO</p>
						</a>
					</li>
				<?php endif; endif; ?>
				</ul>
			</div>
		</div>
		<div class="main-panel">
			<nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
				<div class="container-fluid">
					<div class="navbar-wrapper">
						<div class="navbar-toggle">
							<button class="navbar-toggler">
								<span class="navbar-toggler-bar bar1"></span>
								<span class="navbar-toggler-bar bar2"></span>
								<span class="navbar-toggler-bar bar3"></span>
							</button>
						</div>
						<a class="navbar-brand"><strong>Beta Project</strong></a>
					</div>
					<button class="navbar-toggler" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-bar navbar-kebab"></span>
						<span class="navbar-toggler-bar navbar-kebab"></span>
						<span class="navbar-toggler-bar navbar-kebab"></span>
					</button>
					<div class="collapse navbar-collapse justify-content-end" id="navigation">
						<?php echo form_open('functions/search_player'); ?>
							<div class="input-group no-border">
								<input type="text" name="username" class="form-control" type="submit" placeholder="Search" autocomplete="off" minlength="3" required>
								<div class="input-group-append">
									<div class="input-group-text">
										<i class="fas fa-search"></i>
									</div>
								</div>
							</div>
						<?php echo form_close(); ?>
						<ul class="navbar-nav">
						<?php if($this->session->logged == 1): $query_rows = $this->db->query("SELECT * FROM `notifications` WHERE `name`='".$this->session->username."' AND `status`='0'")->num_rows(); ?>
							<li class="nav-item btn-rotate dropdown">
								<a class="nav-link dropdown-toggle" style="cursor: pointer;" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="far fa-bell" <?=($query_rows > 0)?('id="notifications"'):('');?>></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
									<a class="dropdown-item" href="#">Inventory</a>
									<a class="dropdown-item" href="#">Achievements</a>
									<hr style="margin:-1px 0 -1px 0; background-color:lightsteelblue;">
									<a class="dropdown-item" href="notifications" <?=($query_rows > 0)?('id="notifications1"'):('');?>><b><?=($query_rows != 0)?($query_rows):('');?></b> Notifications</a>
								</div>
							</li>
							<li class="nav-item btn-magnify dropdown">
								<a class="nav-link btn-magnify" style="cursor: pointer;" href="logout">Logout</a>
							</li>
						<?php else:	?>
							<li class="nav-item btn-magnify dropdown">
								<a class="nav-link btn-magnify" style="cursor: pointer;" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Account</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
									<button class="dropdown-item" onclick="$('#login').show(0);" style="cursor:pointer;">Login</button>
									<a class="dropdown-item" href="register">Register</a>
								</div>
								<div id="login" class="modal">
									<?php $this->session->flashdata('messageError'); ?>
									<?php echo form_open('functions/process_login', array('class'=>'modal-content animate')); ?>
										<h3 style="text-align: center; margin-top:10%;">Login Panel</h3>
										<div class="container-login">
											<b>E-mail address:</b>
											<?php
												$data = array('class'=>'input-login', 'type'=>'email', 'name'=>'email', 'id'=>'email');
												echo form_input($data, get_cookie('email'), 'required');
											?>
											<b>Password:</b>
											<?php
												$data = array('class'=>'input-login', 'id'=>'password', 'name'=>'password');
												echo form_password($data, get_cookie('password'), 'required');
											?>
											<center>
											<div class="g-recaptcha" data-sitekey="6LfLdt0UAAAAAAqY_eZR1Tj7fJNtMtnQnCIiZ7hh" style="transform:scale(0.88);-webkit-transform:scale(0.88);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>
											<?php
												$data = array('class'=>'btn btn-primary', 'style'=>'width:70%; border-radius:7px;');
												echo form_submit($data, 'Login');
											?>
											<span id="show_google_login"></span>
											<!--div class="g-signin2" data-onsuccess="onSignIn"></div-->
											</center>
										</div>
										<div class="container-login" style="background-color:#f1f1f1;">
											<button type="button" onclick="$('#login').hide(0);" class="btn btn-danger">Cancel</button>
											<span class="psw"><a href="forgot">Forgot password?</a></span>
										</div>
									<?php echo form_close(); ?>
								</div>
							</li>
						<?php endif; ?>
						</ul>
					</div>
				</div>
			</nav>
