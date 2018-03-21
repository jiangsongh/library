<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>登录</title>
    <link rel="stylesheet" href="lib/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/login.css"/>
</head> 
<body>
    <?php 
        if(array_key_exists("Current",$_COOKIE)){
            header("location:index.php");
            exit;
        }

        require_once("services/userService.php");

        $msg = "";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
          $phone = $_POST["phone"];
          $pwd = $_POST["password"];

          $user = login($phone , $pwd);

          if(!is_null($user)){
            if(array_key_exists("checked",$_POST)){
                  setcookie("Current",$phone,time()+60*24*60*7);
              }else{
                  setcookie("Current",$phone);
              }
              // setcookie("Current" , $user[0]["id"]);

            header("location:index.php");
            exit;
          }

          $msg = "用户信息不正确";

        }
     ?> 
    <div class="head">
        <a href="index.php">
            <img src="image/index.png">
        </a>
        <div class="logo-name">
            <a href="index.php">
                <p>www.dangdang.com.cn</p>
                <p>当当图书网上官方商城</p>
            </a>
        </div>
    </div>
    <div class="login-container">
    <div>
      <img src="image/login.jpg" alt=""/>
    </div>
    <div class="login-main">

      <form method="post">
        <p>密码登录</p>
        <hr/>
        <p>账号</p>
        <p>
          <input type="text" name="phone" class="p-user userName" placeholder="账号" value="18852923032"/>
          <span><?php echo $msg; ?></span>
        </p>
        <p>密码</p>
        <p>
          <input type="password" name="password" class="p-user password" placeholder="密码" value="1234"/>
        </p>
        <p><label><input type="checkbox" name="checked" />一周内无须登录</label></p>
        <p><button class="loginBtn login" type="submit" >登录</button><button class="loginBtn back" type="button" onclick="history.back();">返回</button></p>
      </form>
    </div>


<script type="text/javascript" src="lib/js/jquery.min.js"></script>
<script type="text/javascript" src="lib/js/bootstrap.min.js"></script>
</body>
</html>