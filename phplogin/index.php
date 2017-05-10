<?php
require_once 'core/init.php';

if(Session::exists('home')){
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User();
if($user->isLoggedIn()){

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In or Sign Up Page</title>
    <style>
body{
  margin: 0;
  padding: 0;
  background: linear-gradient(#ffffff, #d8dfea);
}

.inner-addon {
  position: relative; 
}

.inner-addon .glyphicon {
  position: absolute;
  padding: 5px;
  pointer-events: none;
}

.right-addon .glyphicon { 
  right: 12px;
}

.right-addon input { 
  padding-right: 30px; 
}

input.form-control {
   height:26px !important;
}

#this{
  margin: 8px;
  padding-left: 190px;
}

.front {
  background-color: #3b5998;
  height: 32pt;
  overflow: hidden;
}

.right {  
  height: 450pt;
  margin: 15px 0 0 0;
}

#inner{
  font-size: 16px;
  font-family: Arial;
  padding: 30px;
  height: 580px;
  width: 480px;
  margin-left: 300px;
  background: #ffffff;
  border: 1px solid #efefef;
}

.dist{
  margin: 5px;
}
</style> 
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <header class="front">
    <div id="this" class="form-group col-xs-6">
        <div class="inner-addon right-addon">
          <i class="glyphicon glyphicon-search"></i>
          <input type="text" class="form-control" placeholder="Search" />
        </div>
      </div>
 </header>

 <div class="right">
  <div id="inner">
    <div><strong>Welcome,  <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->username); ?>!</a></div></strong>
    <hr>
    <div class="dist"><a href="update.php">Update profile</a></div>
    <div class="dist"><a href="changepassword.php">Change password</a></div>
    <div class="dist"><a href="logout.php">Log out</a></div>
  </div>
</div>
</body>
</html>
    
<?php
	
	if($user->hasPermission('admin')){
		echo '<p>You are an administrator.</p>';
	}

}else{
	echo '<p>you need to <a href="login.php">log in</a> or <a href="register.php">register</a></p>';
}
