<?php 

define("DB_HOST" , "127.0.0.1");
define("DB_USER_NAME" , "root");
define("DB_PASSWORD" , "jiangsh");
define("DB_NAME" , "librarydb");


function executeNonQuery($sql){ // dml
	@$con = mysqli_connect(DB_HOST ,DB_USER_NAME , DB_PASSWORD ,DB_NAME);
	if(mysqli_connect_errno())
		return false;

	$val = mysqli_query($con , $sql);

	mysqli_close($con);

	return $val;
}


/*
	功能描述：专门执行单条select语句

	SELECT ID ,NAME,AGE FROM STUDENTS;

	SELECT AVG(age) , COUNT(*) FROM STUDENTS;

*/
function executeQuery($sql){	// DQL
	@$con = mysqli_connect(DB_HOST ,DB_USER_NAME , DB_PASSWORD ,DB_NAME);
	if(mysqli_connect_errno())
		return false;

	$result = mysqli_query($con , $sql);
	if($result){
		// 
		$rows = mysqli_fetch_all($result , MYSQLI_BOTH);

		mysqli_free_result($result);
		mysqli_close($con);

		return $rows;
	}

	return false;
}


/*
	
*/

function executeMultiQuery($sql){
	@$con = mysqli_connect(DB_HOST ,DB_USER_NAME , DB_PASSWORD ,DB_NAME);
	if(mysqli_connect_errno())
		return false;

	$flag = mysqli_multi_query($con , $sql);

	if($flag){
		$list = [];
		do{
			$result = mysqli_store_result($con);
			$list[] = mysqli_fetch_all($result , MYSQLI_BOTH);
		}while(mysqli_more_results($con) && mysqli_next_result($con));

		mysqli_close($con);
		return $list;

	}

	return false;
}

function executeMultiNonQuery($sqlList){
	@$con = mysqli_connect(DB_HOST ,DB_USER_NAME , DB_PASSWORD ,DB_NAME);
	if(mysqli_connect_errno())
		return false;

	// 设置事务处理，从自动方式改为手动
	mysqli_autocommit($con , false);

	foreach($sqlList as $sql){
		$result = mysqli_query($con , $sql);
		// 检查每条SQL执行结果，如果失败，回滚所有操作，并终止执行
		if(!$result){
			// 
			// echo "错误描述：" . mysqli_error($con);
			// echo "<hr />";
			mysqli_rollback($con);
			mysqli_close($con);
			return false;
		}
	}
	// 所有SQL语句执行成功，手工提交
	mysqli_commit($con);
	mysqli_close($con);
	return true;


}