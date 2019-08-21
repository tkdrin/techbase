<?php


//データベース設定
	$dsn='tb210196db';
	$user='tb-210196';
	$password='cJDUd52dVw';
	$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));



//4-2よりテーブル作成(テーブル名はreina)
	$sql = "CREATE TABLE IF NOT EXISTS reina"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "password char(32)"
	.");";
	$stmt = $pdo->query($sql);

$name = "名前";
$comment = "コメント";
$pass="";
$edit_number="";





//編集番号の受け取り
	if(isset($_POST["edit"])&&ctype_digit($_POST["edit"])&&!empty($_POST["edit"])&&isset($_POST["password_e"])&&!empty($_POST["password_e"])){

		$sql = sprintf('SELECT * FROM reina WHERE id=%d', $_POST['edit']) ;//該当番号の1行を取り出す
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if($row['password']==$_POST["password_e"]){//passwordが一致しているか
			$edit_number=$row['id'];
			$name=$row['name'];
			$comment=$row['comment'];
			}
		}
		
	}
//編集又は新規投稿スタート
	elseif(isset($_POST["comment"])&&!empty($_POST["comment"])&&isset($_POST["name"])&&!empty($_POST["name"])&&isset($_POST["password_nc"])&&!empty($_POST["password_nc"])){
	//編集スタート
		if(isset($_POST["editnumber"])&&!empty($_POST["editnumber"])){

			$sql = sprintf('SELECT * FROM reina WHERE id=%d', $_POST['editnumber']) ;
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				//$rowの中にはテーブルのカラム名が入る
				if($row['password']==$_POST["password_nc"]){
					$id =$_POST["editnumber"]; //変更する投稿番号
					$name =$_POST["name"] ;
					$comment =$_POST["comment"] ; //変更したい名前、変更したいコメントは自分で決めること
					$sql = 'update reina set name=:name,comment=:comment where id=:id';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':name', $name, PDO::PARAM_STR);
					$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();


					$sql = 'SELECT * FROM reina';
					$stmt = $pdo->query($sql);
					$results = $stmt->fetchAll();
					foreach ($results as $row){
						//$rowの中にはテーブルのカラム名が入る
						echo $row['id'].',';
						echo $row['name'].',';
						echo $row['comment'].'<br>';
					}
					echo "<hr>";
					
				}
			}
	//編集スタート
	/*	if(isset($_POST["editnumber"])&&!empty($_POST["editnumber"])){
			$id =$_POST["editnumber"]; //変更する投稿番号
			$name =$_POST["name"] ;
			$comment =$_POST["comment"] ; //変更したい名前、変更したいコメントは自分で決めること
			$sql = 'update reina set name=:name,comment=:comment where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();

	//編集結果表示
			$sql = 'SELECT * FROM reina';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				//$rowの中にはテーブルのカラム名が入る
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].'<br>';
			}
			echo "<hr>"; 
	*/ 
		}else{
	//新規投稿
		

		//$sql = $pdo -> prepare("INSERT INTO reina (name, comment,password) VALUES (:name, :comment,:password)");
		$sql = $pdo -> prepare("INSERT INTO reina (name, comment, password) VALUES (:name, :comment, :password)");
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':password', $pass, PDO::PARAM_STR);
		$name = $_POST["name"];
		$comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
		$pass=$_POST["password_nc"];
		$sql -> execute();

	//新規投稿結果の表示
		$sql = 'SELECT * FROM reina';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
		}
		echo "<hr>";
		}
	$name = "名前";
	$comment = "コメント";
	}

//削除スタート
	elseif(isset($_POST["delete"])&&ctype_digit($_POST["delete"])&&!empty($_POST["delete"])&&isset($_POST["password_d"])&&!empty($_POST["password_d"])){
		
		$sql = sprintf('SELECT * FROM reina WHERE id=%d', $_POST['delete']) ;
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			if($row['password']==$_POST["password_d"]){//passwordが一致しているか
		
				$id = $_POST["delete"];
				$sql = 'delete from reina where id=:id';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $id, PDO::PARAM_INT);
				$stmt->execute();

				$sql = 'SELECT * FROM reina';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
					echo $row['id'].',';
					echo $row['name'].',';
					echo $row['comment'].'<br>';
				}
				echo "<hr>";
			}
		}
		
	}
	else{	
		$name = "名前";
		$comment = "コメント";
		$pass="";
	}

$pass="";

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8"> <!-- <meta 属性＝"属性値"> 
			    charset:head要素内に記述することで、文書の文字コードを指定 -->
</head>	
<body>
	
	<form action="mission_5.php" method="POST"><!-- <form 属性="属性値"></form>
						          action:入力されたデータの送信先をURLで指定
						          method:データを送信する方式を指定 -->
	名前:	<input type="text" value="<?php echo $name; ?>" name="name"><br>
	コメント:	<input type="text" value="<?php echo $comment; ?>" name="comment"><br>
<!--	<input type="text" value="<?php echo $edit_number; ?>" name="editnumber"<br> -->
		<input type="hidden" value="<?php echo $edit_number; ?>" name="editnumber"<br>
	password: <input type="password" value="<?php echo $pass; ?>" name="password_nc"><br> 
		<input type="submit" value="送信"><br><br>
	</form>
	
	
	<form action="mission_5.php" method="POST">
	削除番号:	<input type="text" value="" name="delete"><br>
	password: <input type="password" value="<?php echo $pass; ?>" name="password_d"><br> 
		<input type="submit" value="削除"><br><br>

	</form>
	<form action="mission_5.php" method="POST">
	編集番号:	<input type="text"  value="" name="edit"><br>
	password:	<input type="password" value="<?php echo $pass; ?>" name="password_e"><br> 
		<input type="submit" value="編集"><br>
	
	</form>


</body>
</html>
