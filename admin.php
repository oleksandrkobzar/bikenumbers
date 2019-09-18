<?php 
	function watchAll($table, $db, $count){
        $query ="SELECT * FROM " . $table . " order by id desc limit 0,". $count;
        $result = mysqli_query($db, $query) or die("NO SELECT 04 " . mysqli_error($db)); 
        $item = array();
        if($result)
        {
            $i = 0;
			while($row = $result->fetch_assoc()) {
				$item[$i]['id'] = $row['id'];
				$item[$i]['number'] = $row['number'];
				$item[$i]['password'] = $row['password'];
				$i++;
			}
			return $item;
        }
    }

    function countAll($table, $db){
        $query ="SELECT * FROM " . $table;
        $result = mysqli_query($db, $query) or die("NO SELECT 21 " . mysqli_error($db)); 
        $item = array();
        if($result)
        {
            $i = 0;
			while($row = $result->fetch_assoc()) {
				$item[$i]['id'] = $row['id'];
				$item[$i]['number'] = $row['number'];
				$item[$i]['password'] = $row['password'];
				$i++;
			}
			return $item;
        }
    }

    function add($table, $db, $number, $password){
        $result = $db->query("INSERT INTO " . $table . " (number, password) VALUES ('$number','$password')");
    	header("Location:/");
    }

    function delete($table, $db, $id){
    	$result = $db->query("DELETE FROM " . $table . " WHERE id= " . $id);
    	header("Location:/");
    }

    function search($table, $db, $number){
    	$result = $db->query("SELECT * FROM " . $table . " WHERE number LIKE '%". $number ."%'");
        $item = array();
        if($result)
        {
            $i = 0;
			while($row = $result->fetch_assoc()) {
				$item[$i]['id'] = $row['id'];
				$item[$i]['number'] = $row['number'];
				$item[$i]['password'] = $row['password'];
				$i++;
			}
			return $item;
        }
    }

    function checkAdmin($db, $table, $login, $password){
    	$result = $db->query("SELECT login, password FROM ". $table);
	    $i = 0;
	    $data = array();
		while($row = $result->fetch_assoc()) {
			$data[$i]['login'] = $row['login'];
			$data[$i]['password'] = $row['password'];
			$i++;
		}

	    if($login == $data["0"]['login'] || $login == $data["1"]['login']) {
	    	if($password == $data["0"]['login']) {
		    	$_SESSION['admin'] = "admin";
		    	return true;
		    } 
		    if($password == $data["1"]['login']) {
		    	$_SESSION['admin'] = "user";
		    	return true;
		    }
		    
	    }
    	return false;
    }

    function logout(){	
		unset($_SESSION['admin']);
		header("Location:/login.php");
		exit();
	}
?>