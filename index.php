<?php  
    session_start();
    if(!isset($_SESSION['admin'])){header("Location:/login.php");exit();}
    define('ROOT', dirname(__FILE__));
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once (ROOT.'/database.php');
    require_once (ROOT.'/admin.php');
    $table = "bike";
    $count = 10;
    $db = mysqli_connect($host, $user, $password, $database) or die("NO CONNECT WITH DATABASE" . mysqli_error($db));
    $allData = watchAll($table, $db, $count);
    if (isset($_POST['number']) && isset($_POST['password'])){
        $number = $_POST['number'];
        $password = $_POST['password'];
        $addItem = add($table, $db, $number, $password);
    }
    if (isset($_POST['delete'])){
        delete($table, $db, $_POST['id']);
    }
    if (isset($_POST['search'])){
        $searchData = search($table, $db, $_POST['searchNumber']);
    }
    if (isset($_POST['logout'])){
        logout();
    }
    include(ROOT."/head.php");
?>
<div class="container">
    <div class="row">
        <div class="col">
            <header>
                <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                    <a class="navbar-brand" href="/">Bike</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <button class="btn btn-secondary disabled" type="button">
                        <?php echo count(countAll($table, $db));?>
                    </button>
                    
                    <div class="collapse navbar-collapse" id="navbarCollapse"> 
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <?php if($_SESSION['admin'] == 'admin'){?>
                                <button type="button" class="btn btn-primary btn-add" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <?php }?>
                            </li>
                        </ul>
                        <form method="POST" class="form-inline mt-2 mt-md-0">
                            <input class="form-control mr-sm-2" type="number" pattern="[0-9]{1,5}" placeholder="Number" name="searchNumber" aria-label="Search"  autofocus="" required>
                            <button class="btn btn-outline-success my-2 my-sm-0" name="search" type="submit">Search</button>
                        </form>
                        <form method="POST" class="form-inline mt-2 mt-md-0">
                            <button class="btn btn-danger my-2 my-sm-0 logout" name="logout" type="submit">Log out</button>
                        </form>
                    </div>
                </nav>
            </header>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <?php  if(isset($_POST['search'])){
                    if(count($searchData) > 0){?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Number</th>
                        <th scope="col">Password</th>
                        <?php if($_SESSION['admin'] == 'admin'){?><th scope="col">Delete</th><?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php if(true){foreach($searchData as $item):?>
                    <tr>
                        <th scope="row"><?php echo $item['id'];?></th>
                        <td><?php echo $item['number'];?></td>
                        <td><?php echo $item['password'];?></td>
                        <?php if($_SESSION['admin'] == 'admin'){?><td><form method="POST" action=""><input type="text" name="id" value="<?php echo $item['id'];?>" hidden><button type="submin" name="delete" class="btn btn-danger"><i class="fas fa-times"></i></button></form></td><?php }?>
                    </tr>
                    <?php endforeach;}?> 
                </tbody>
            </table>
            <?php }
            else echo "<div class='alert alert-dismissible alert-success'>Not results <a href='/'> Home</a></div>";}
            else{?>
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Number</th>
                        <th scope="col">Password</th>
                        <?php if($_SESSION['admin'] == 'admin'){?><th scope="col">Delete</th><?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($allData as $itemNum):?>
                    <tr>
                        <th scope="row"><?php echo $itemNum['id'];?></th>
                        <td><?php echo $itemNum['number'];?></td>
                        <td><?php echo $itemNum['password'];?></td>
                        <?php if($_SESSION['admin'] == 'admin'){?><td><form method="POST" action=""><input type="text" name="id" value="<?php echo $itemNum['id'];?>" hidden><button type="submin" name="delete" class="btn btn-danger"><i class="fas fa-times"></i></button></form></td><?php }?>
                    </tr>
                    <?php endforeach;?> 
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form">
                    <div class="form-group">
                        <label for="exampleInputNumber">Number: </label>
                        <input type="number" name="number" pattern="[0-9]{5,5}" class="form-control" id="numer" aria-describedby="numerHelp" placeholder="Enter number" autofocus="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword">Password: </label>
                        <input type="number" name="password" pattern="[0-9]{4,4}" class="form-control" id="password" aria-describedby="numerPassword" placeholder="Enter password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="form" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>
<?php 
    include(ROOT."/footer.php");
    mysqli_close($db);
?>