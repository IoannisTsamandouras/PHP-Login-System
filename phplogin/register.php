<?php
require_once 'core/init.php';

if(Input::exists()){
  if(Token::check(Input::get('token'))){
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'username' => array(
        'required' =>true,
        'min' => 2,
        'max' => 20,
        'unique' => 'users'
      ),
      'password' => array(
        'required' => true,
        'min' => 6
      ),
      'password_again' => array(
        'required' => true,
        'matches' => 'password'
      ),
      'name' => array(
        'required' => true,
        'min' => 2,
        'max' => 50
        )
      ));

    if($validation->passed()){
      $user = new User();

      $salt = Hash::salt(32);
      
      try{
        $user->create(array(
          'username'=> Input::get('username'),
          'password' => Hash::make(Input::get('password'), $salt),
          'salt' => $salt,
          'name' => Input::get('name'),
          'joined' => date('Y-m-d H:i:s'),
          'groupno' => 1
          ));
        Session::flash('home', 'You have been registered and can now log in.');
        Redirect::to('index.php');

      }catch(Exception $e){
        die($e->getMessage());
      }
    }else{
      foreach($validation->errors() as $error){
        echo $error, '<br>';
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
   }

.front {
  background-color: #3b5998;
  height: 75pt;
  overflow: hidden;
}

table {
  position: relative;
  left: 800px;
  bottom: 87px;
}        
      
.logo {
  color: white;
  font-family: Helvetica;
  font-size: 38px;position: relative;
  bottom: : 10px;
  left: 100pt;
  font-stretch: ultra-condensed;
  overflow: hidden;
}      
      
.heading {
  color: white;
  font-family: Helvetica;
  font-size: 13px;
}      
         
.blue {
  font-family: Helvetica;
  color: navy;
  font-size: 13px;
}
      
.submit {
  font-size: 13px;
  font-weight: bold;
  color: white;
  background-color: #6d84b4;
  border:1px solid #3b5998;
  border-radius: 3px;
  padding: 2px 5px 2px 5px;
}

.right {
  background: linear-gradient(#ffffff, #d8dfea);
  height: 580pt;
}
       
.slider_img {
  font-family: Helvetica;
  font-size: 14px;
  width: 36%;
  margin-left: 130px;
  float: left;
}

.disclaimer {
  font-family: Helvetica;
  font-size: 10px;
  display: inline-block; 
  text-align: left;
  margin: 0 auto;
  position: relative;;
  right: 140px;
}
       
img {
  position: relative;
  left: 120px;
  top: -550px;
  padding: 0px;
  width: 400px;
  margin: 0px;
}
     
.form {
  text-align: right;
  position: relative;
  right: 110px;
  margin: 0px;
}  
      
.create {
  font-size: 40px;
  font-family: Helvetica;
  position: relative;
  right: 295px;
}  
        
.free {
  font-size: 20px;
  font-family: Helvetica;
  position: relative;
  right: 190px;
}      
     
.input {
  border-radius: 5px;
  height: 30px;
  border:1px solid #BBBBBB;
  padding: 4px;
}    
       
.h3 {    
  font-family: Helvetica;
  font-size: 20px;
  position: relative;
  right:  360px; 
} 
           
.inputextra {
  border-radius: 5px;
  height: 30px;
  border:1px solid #BBBBBB;
  padding: 5px;
  position: relative;
  right:294px;  
}                           

button {
  font-size: 18px;
  font-family: Tahoma;
  font-weight: bold;
  padding: 10px 20px 10px 20px;
  color: #ffffff;
  border-radius: 5px;
  background: linear-gradient(#64A852, #598C45);
  position: relative;
  right: 240px;
}           
    
.table{
  border-radius: 5px;
  height: 15px;
  border:1px solid #BBBBBB;
  padding: 5px;
}   

footer {
  font-size: 12px;  
  color: #d3d3d3;
  height: 77px;
}

.bottom {
  width: 850px;
  margin: 0 auto;
  text-align: left;
  padding: 10px 0;
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
    <div class="front">
        <h1 class="logo">Log In or Sign Up</h1>
        <table>
            <tr class="heading">
                <td>Username</td>
                <td>Password</td>
            </tr>
            <tr>
                <td><input class="table" type="text" name="username"></td>
                <td><input class="table" type="password" name="password"></td>
                <td><input type="submit" value="Log in" name="submit" size="12px" 
                  class="submit"></td>
            </tr>            
        </table>
      </div>

        <div class="slider_img">
           <h2 class="">Connect and share with the people<br/>in your life.</h2>
           <img src="\logo.png" alt="logo">
         </div>
    
    <div class="right">    
    <form class="form" action="index.php" method="post">
        <h1 class="create" >Sign Up</h1>
        <h2 class="free">It's free and always will be.</h2> 
        <div class="field">      
        <p>
          <label for="username"></label>
            <input class="input" type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" size="57px" placeholder="Username">                    
        </p>
      </div>
      <div class="field">
        <p>
          <label for="name"></label>
           <input class="input" type="text" name="name" size="57px" value="<?php echo escape(Input::get('name')); ?>" id="name" placeholder="Your name">           
       </p>      
     </div>
     <div class="field">
       <p>
        <label for="password"></label>
          <input class="input" type="password" name="password" size="57px" id="password" placeholder="Choose a password"> 
       </p>
       </div>       
       <div class="field">
       <p>
        <label for="password_again"></label>
        <input class="input" type="password" name="password_again" size="57px" id="password_again" placeholder="Enter your password again">  
        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
       </p> 
     </div>
       <p class="disclaimer">By clicking Create an account, you agree to our Terms and 
        <br/>confirm that you have read our Data Policy, including our Cookie 
        <br/>Use Policy. You may receive SMS message notifications and 
        <br/>can opt out at any time.        
       </p>
       <p><button value="Register">Create an acount</button></p>
     </form>       
</div>  
<footer>
    <div class="bottom">Login Page &copy; 2017
      <hr class="style-one">
    </div>
  </footer>
</body>
</html>
