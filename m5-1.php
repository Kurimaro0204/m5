<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    
    
    <?php
    //DB接続

    $dsn='mysql:dbname=tb250141db;host=localhost';
    $user='tb-250141';
    $password='a8P3VBYbPg';
    $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //table作成
    $sql="CREATE TABLE IF NOT EXISTS mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    ."password TEXT,"
    ."date TEXT"
    .");";
    
    $stmt=$pdo->query($sql);
    
    
    if(!empty($_POST)){
        
        //$date=date('Y年m月d日H時i分s秒');
        
        //編集投稿
        if(!empty($_POST["name"]&&$_POST["comment"]&&$_POST["editnumber"]&&$_POST["password"])){
            
            $pass=$_POST["password"];
            $id=$_POST["editnumber"];
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $date=date('Y年m月d日H時i分s秒');

            $sql="UPDATE mission5 SET name=:name,comment=:comment,password=:password, date=:date where id=:id";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->bindParam(":name",$name,PDO::PARAM_STR);
            $stmt->bindParam(":comment",$comment,PDO::PARAM_STR);
            $stmt->bindParam(":password",$pass,PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            
        }
        //新規投稿
        elseif(!empty($_POST["name"]&&$_POST["comment"]&&$_POST["password"])){
            
            $date=date('Y年m月d日H時i分s秒');
            $sql="INSERT INTO mission5 (name,comment,password,date) VALUES (:name,:comment,:password,:date)";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(":password",$pass,PDO::PARAM_STR);
            $stmt->bindParam(':date', $date, PDO::PARAM_STR);
            $name=$_POST["name"];
            $comment=$_POST["comment"]; 
            $pass=$_POST["password"];
            
            $stmt->execute();
            
        }
        //投稿削除
        elseif(!empty($_POST["num_del"]&&$_POST["pass_del"])){
            
            $id=$_POST["num_del"];
            $pass_del=$_POST["pass_del"];
            $sql="delete from mission5 where id=:id and password=:password";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->bindParam(":password",$pass_del,PDO::PARAM_INT);
            $stmt->execute();
            
            
            
        }
        //編集番号と内容の取得
        elseif(!empty($_POST["num_edit"]&&$_POST["pass_edit"])){
            
            $id=$_POST["num_edit"];
            $edit_pass=$_POST["pass_edit"];
            $sql="SELECT*FROM mission5 where id=:id and password=:password";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":id",$id,PDO::PARAM_INT);
            $stmt->bindParam(":password",$edit_pass,PDO::PARAM_INT);
            $stmt->execute();
            $result=$stmt->fetchAll();
            foreach($result as $wrd){
                $edit_id=$wrd["id"];
                $edit_name=$wrd["name"];
                $edit_com=$wrd["comment"];
            }

            
            
        }
        
        
    }
    
    ?>
    
    <form action=""method="post">
        <input type="text" name="name" placeholder="名前" value="<?php if(!empty($edit_name)){echo$edit_name;} ?>" >
        <br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($edit_com)){echo$edit_com;} ?>" >
        <br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="submit" name="submit">
        <br>
        <input type="hidden" name="editnumber" value="<?php if(!empty($edit_id)){echo$edit_id;} ?>"> 
        <br>
        <input type="number" name="num_del" placeholder="削除番号"  >
        <br>
        <input type="text" name="pass_del" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
        <br>
        <br>
        <input type="number" name="num_edit" placeholder="編集番号"  >
        <br>
        <input type="text" name="pass_edit" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
    </form>
    
    <?php
    
    
    //データ表示

    $sql="SELECT*FROM mission5";
    $stmt=$pdo->query($sql);
    $result=$stmt->fetchAll();
    foreach($result as $wrd){
        
        echo$wrd["id"]."<br>";
        echo$wrd["name"]."<br>";
        echo$wrd["comment"]."<br>";
        echo$wrd["password"]."<br>";
        echo$wrd["date"]."<br>";
        echo"<hr>";
        
}
    
    ?>
    
</body>