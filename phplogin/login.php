<?php
require_once 'core/init.php';

if(Input::exists()){
	if(Token::check(Input::get('token'))){

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array('required' => true),
			'password' => array('required' => true)
			));
		
		if($validation->passed()){
			$user = new User();
			$login = $user->login(Input::get('username'), Input::get('password'));

			if($validation->passed()){
				$user = new User();

				$remember = (Input::get('remember') === 'on') ? true : false;
				$login = $user->login(Input::get('username'), Input::get('password'), $remember);

				if($login){
					Redirect::to('index.php');
				}else{
					echo '<p>Sorry, logging in failed</p>';
				}
			}else{
				foreach($validation->errors() as $error){
					echo $error, '<br>';
				}
			}
		}
	}
}
?>

<!DOCTYPE html>
<head>
<title>Login Page</title>
<style type="text/css">
* {
	margin: 0px; padding: 0px;
}

body{
	background: #ffff; 
	font-family: Arial;
	font-size: 14px;
}

header{
	background: #3a5795;
	color: #fff;
	padding: 18px 5px;
}

.top h2{
	font-size: 40px;
}

.top{
	width: 850px;
	margin: 0px auto;
}

a,
a:hover,
a:visited,
a:active{
	color: #3a5795;
	text-decoration: none;
}

a:hover{
	text-decoration: underline;
}

.btn{
	padding: 3px;
	color: #fff;
	font-weight: bold;
	border-radius: 4px;
}

.btn-signup{
	background: #6bb933;
	border-color: #60a62e #519f18 #409701;
	height:30px;
    width:75px;
}

.btn-login{
	width: 300px;
	height: 43px;
	background: #3a5795;
	border: none;
	padding: 8px;
	margin: 10px auto;
}

section{
	padding: 10px;
	background: #e9eaed;
}

.center{
	border: 1px solid #ccc;
	border-radius: 5px;
	background: #fff;
	padding: 20px;
	height:280px;
	width: 600px;
	margin: 100px auto;
}

.input-group{
	margin-top:10px;
    width:60%;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
}

p{
	display: block;
	font-size: 14px;
}

.example{
	font-size: 18px;
	text-align: center;
}

label {
	display: inline;
	float: left;
}

.recall{
	display: block;
  	padding-left: 170px;
  	text-indent: -15px;
}

div .rem{
	font-size: 14px;
	display: block;
}

input{
	display: block;
	width: 280px;
	height: 20px;
	margin: 10px auto;
	padding: 5px;
}

.chkbx{
	display: inline;
	width: 14px;
  	height: 13px;
  
  	vertical-align: bottom;
  	position: relative;
  	top: -1px;
  	*overflow: hidden; 	
  	margin: 0 auto;
}

footer{
	font-size: 12px;	
	color: #d3d3d3;
}

.bottom{
	width: 850px;
	margin: 0 auto;
	text-align: left;
	padding: 10px 0;
}

p{
	padding: 8px 0;
	color: #808080;
}

hr.style-one {
border: 0;
height: 0;
border-top: 1px solid rgba(0, 0, 0, 0.1);
border-bottom: 1px solid rgba(255, 255, 255, 0.3);
}
</style>
</head>
<body>
	<header>
		<div class="top">
			<h2>login template <button class="btn btn-signup">Sign up</button></h2>
		</div>
	</header>
	<section>
		<form action="" method="post">
			<div class="center">
				<div class="example">User Login
				<div class="field">
					<input type="text" name="username" id="username" placeholder="Username"autocomplete="off">
				</div>
				<div class="field">
					<input type="password" name="password" id="password" placeholder="Password" autocomplete="off">
				</div>
				<div class="field"><p>
				<label for="remember" class="recall">						
				<input type="checkbox" name="remember" id="remember" class="chkbx">
				Remember me</label></p>
			</div>
			<div class="field">
				<p><input type="submit" value="Log in" class="btn btn-login"></p>
					<p><a href="register.php">Sign up here</a></p>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				</div>
			</div>
		</form>
	</section>
	<footer>
		<div class="bottom">Login Page &copy; 2017
			<hr class="style-one">
		</div>
	</footer>
