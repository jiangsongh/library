<?php 


require_once("dbHelper.php");

/*
	功能描述：用户登录
	参数列表：
	返 回 值：false:操作失败
			  null:用户信息不正确
			  array:登录成功
*/

function login($phone , $password){
	$con = mysqli_connect(DB_HOST ,DB_USER_NAME ,DB_PASSWORD , DB_NAME);

	if(mysqli_connect_errno()){
		return false;
	}

	$phone = mysqli_real_escape_string($con , $phone);
	$password = mysqli_real_escape_string($con ,$password);


	$sql = "select id,name,Phone,CardId,Address,State , Header from members where phone='{$phone}' and password=password('{$password}')";
	

	// $result = mysqli_query($con , $sql);

	// if($result){
	// 	$user = null;
	// 	if($row = mysqli_fetch_assoc($result)){
	// 		$user = $row;
	// 	}
	// 	mysqli_close($con);
	// 	return $user;

	// }
	// return false;

	$list = executeQuery($sql);

	if(is_bool($list))
		return false;

	$user = null;

	if($list){
		$user = [
			"id" => $list[0][0],
			"phone" => $list[0][2],
			"name" => $list[0][1]
		];
	}

	return $user;

}

/*
	

*/
function register($phone , $password , $name){
	$password = md5($password);
	$sql = "insert into users(phone , password , name) values('{$phone}' , '{$password}' , '{$name}')";
	return executeNonQuery($sql);
}