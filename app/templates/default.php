<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Neza Technologies</title>
<link rel="shortcut icon" href="<?php echo $app->link('img/favicon.ico'); ?>" />
<link rel="stylesheet" href="<?php echo $app->link('css/font-awesome.min.css'); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $app->link('css/style.css'); ?>" />
<script type="text/javascript" src=""></script>
</head>
<body>
	<header id="topheader">
		<a id="title" href="#home"> <img alt="Neza Tech"
			src="<?php echo $app->link('img/nezatech.png'); ?>" />
		</a>
		<div id="userwrapper">
			<div id="userheader">
				<?php
				if (isset ( $user ) && isset ( $user->login ) && $user->login) {
					?>
						<i id="usericon" class="fa fa-user"></i> <label class="userinfo">
					Hello <b>John Doe</b>
				</label> | 
					<?php
				}
				?>
				<a href="#settings">Settings</a> | 
				<?php
				if (isset ( $user ) && isset ( $user->login ) && $user->login) {
					?>
						<a href="#logout">Logout</a>
					<?php
				} else {
					?>
						<a href="#login">Login</a>
					<?php
				}
				?>
				
			</div>
			<?php
			if (isset ( $user ) && isset ( $user->login ) && $user->login) {
				?>
					<h5 class="lastlogin">Last Login: 12 May 2016</h5>
				<?php
			}
			?>			
		</div>
	</header>
	<header id="navbar">
		<!-- div id="nav-search">
			<div id="searchbox">
				<i class="searchicon fa fa-search" aria-hidden="true"></i> <input
					type="search" name="search" value="" placeholder="Search ..." />
			</div>
		</div-->
		<nav>
			<a href="#" id="menu-icon"></a>
			<ul class="mainmenu">
				<li class="current"><a href="#">Dashboard</a></li>
				<li><a href="#services">Our Services</a>
					<ul class="submenu">
						<li><a href="#">ICT Consultation</a></li>
						<li><a href="#">Software Development</a></li>
						<li><a href="#">Systems Integration</a></li>
						<li><a href="#">Payment Services Integration</a></li>
						<li><a href="#"> Programming Lessons </a></li>
						<li><a href="#">CMS Extensions</a></li>
					</ul></li>
				<li><a href="#aboutus">About Us</a></li>
				<li><a href="#cms">Neza CMS</a></li>
			</ul>
		</nav>
	</header>	
	<section id="content-wrapper" class="clearfix">
		<aside>
			<form method="post" action="<?php echo $app->formAction('default/index');?>" id="login">
				<h3>Login</h3>
				<fieldset>
					<legend></legend>
					<label for="username">Username</label> <input name="username" id="username" autofocus /> <label
						for="password">Password</label> <input name="password" id="password"
						type="password" />
					<button type="submit" name="cmd" value="login">Submit</button>
				</fieldset>
			</form>
		</aside>
		<article>
			<p>
				<?php
			print_r ( $app->inputs );
			?>
			</p>
		</article>
	</section>
	<div id="footer" class="clearfix">
		<footer>
			<ul class="social">
				<li><a href="https://www.facebook.com/w3newbie" target="_blank"><i
						class="fa fa-facebook"></i></a></li>
				<li><a href="https://plus.google.com/+DrewRyan_w3/posts"
					target="_blank"><i class="fa fa-google-plus"></i></a></li>
				<li><a href="https://twitter.com/DrewOnCue" target="_blank"><i
						class="fa fa-twitter"></i></a></li>
				<li><a href="https://youtube.com/DrewOnCue" target="_blank"><i
						class="fa fa-youtube"></i></a></li>
				<li><a href="https://www.instagram.com/drew_ryan_/" target="_blank"><i
						class="fa fa-instagram"></i></a></li>
			</ul>
		</footer>
		<footer class="second">
			<p>&copy; Neza Technologies</p>
		</footer>
	</div>
</body>
</html>