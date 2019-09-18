<?php 
session_start();
if(isset($_SESSION['admin'])){header("Location:/");exit();}
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/database.php');
require_once (ROOT.'/admin.php');
$db = mysqli_connect($host, $user, $password, $database) or die("NO CONNECT WITH DATABASE" . mysqli_error($db));
if (isset($_POST['singin'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $result = checkAdmin($db, "admin", $login, $password);
    if($result){
        header("Location:/");
        exit();
    }
}
include("head.php");?>
<div class="container">
  <div class="row">
    <div class="col">
      <form class="form-signin text-center" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Bike</h1>
        <div class="form-group">
          <label for="inputEmail" class="sr-only">Login</label>
          <input type="text" id="inputLogin" name="login" class="form-control" placeholder="Login" required="" autofocus="">
        </div>
        <div class="form-group">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
        </div>
        <button class="btn btn-lg btn-primary btn-block" name="singin" type="submit">Sign in</button>
      </form>
      <?php 
      if(isset($_POST['singin']) && !$result)
      echo "<div class='alert alert-dismissible alert-danger notsingin'>Not sing in</div>";
      ?>
    </div>
  </div>
</div>

<?php include("footer.php");?>