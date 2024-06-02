<?php session_start(); ?>
<header>
	<nav>
		<a href="#promo"><div class="logo"><?php echo $config['title']; ?></div></a>
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<ul class="menu">
						<li><a href="#categories" class="menu_link">категории</a></li>
						<li><a href="#courts" class="menu_link">корты</a></li>
						<li><a href="#history" class="menu_link">история</a></li>
						<li><a href="#sing" class="menu_link">тренировки</a></li>
						<li><a href="#footer" class="menu_link">контакты</a></li>
					</ul>
					<ul class="menu_sm">
						<li><a href="#categories_sm" class="menu_sm_link">категории</a></li>
						<li><a href="#courts" class="menu_sm_link">корты</a></li>
						<li><a href="#history_sm" class="menu_sm_link">история</a></li>
						<li><a href="#sing" class="menu_sm_link">тренировки</a></li>
						<li><a href="#footer" class="menu_sm_link">контакты</a></li>
					</ul>
				</div>
				<div class="col-lg-2 offset-lg-1 col-md-2 col-sm-3 offset-sm-8 col-5 offset-7">
					<?php
						switch($case){
						case 1: ?>
						<ul>
							<li><a class="active" href="basketball.php">баскетбол</a>
								<ul>
									<li><a href="hockey.php">хоккей</a></li>
									<li><a href="ski.php">лыжи</a></li>
									<li><a href="tennis.php">теннис</a></li>
								</ul>
							</li>
						</ul>
						<?php break; case 2:?>
						<ul>
							<li><a class="active" href="hockey.php">хоккей</a>
								<ul>
									<li><a href="basketball.php">баскет</a></li>
									<li><a href="ski.php">лыжи</a></li>
									<li><a href="tennis.php">теннис</a></li>
								</ul>
							</li>
						</ul>
						<?php break; case 3:?>
						<ul>
							<li><a class="active" href="ski.php">лыжи</a>
								<ul>
									<li><a href="basketball.php">баскет</a></li>
									<li><a href="hockey.php">хоккей</a></li>
									<li><a href="tennis.php">теннис</a></li>
								</ul>
							</li>
						</ul>
						<?php break; case 4:?>
						<ul>
							<li><a class="active" href="tennis.php">теннис</a>
								<ul>
									<li><a href="basketball.php">баскет</a></li>
									<li><a href="hockey.php">хоккей</a></li>
									<li><a href="ski.php">лыжи</a></li>
								</ul>
							</li>
						</ul>
					<?php break; }?>
				</div>
				<div class="col-1">
					<div class="profile_img">
						<?php 
							if(isset($_SESSION['authenticadet']))
						{ ?>
							<a href="../../profile/profile.php"><img src="../../icons/profile/user.png" alt=""></a>
							<a href="../../profile/logout.php"><img src="../../icons/profile/logout.png" alt=""></a>
						<?php } else {?>
							<a href="../../profile/login.php"><img src="../../icons/profile/user.png" alt=""></a>
						<?php }?>
					</div>
				</div>
				<div class="hamburger">
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
	</nav>
</header>