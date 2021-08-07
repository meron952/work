<?php
        $filename = "mission_3-5.txt";
        $items = file($filename,FILE_IGNORE_NEW_LINES);
        $name = $_POST["name"];
        $comment = $_POST["comment"];
        
        
        if(file_exists($filename)){
            $end = end($items); //配列の最後のデータを取り出す
            $lastnumber = explode("<>",$end);
            $num = $lastnumber[0] + 1;
        } else{
            $num = 1;
        }
        $date = date("Y/m/d H:i:s");
        
        
        $deletenumber = $_POST["deletenumber"];
        $edit = $_POST["edit"];
        $editnumber = $_POST["editnumber"];
        
        $pass = $_POST["pass"];
        $depass = $_POST["depass"];
        $editpass = $_POST["editpass"];
        
        
        
        $result = $num ."<>" .  $name . "<>" . $comment .  "<>" . $date . "<>" . $pass . "<>";
        
        
        if(!empty($deletenumber) ){ //消去番号を受け取ったとき
            $fp = fopen($filename,"w");
            for($i = 0; $i < count($items); $i++){
                $array = explode("<>",$items[$i]); //投稿番号を取得
                if($array[0] == $deletenumber && $array[4] == $depass){ //投稿番号と消去番号を比較 
                                                            //一致してるときは何もしない？　なぜこれで消去されるのか？
                    
                }    else{                       //どちらかでも一致しなければ元の行をそのまま描く
                    fwrite($fp,$items[$i] . PHP_EOL);
                }
                
            } 
            fclose($fp);//for文の外でファイルを開いてるから
                        //for文の外で閉じる
            
        }
        
        
        if(!empty($name) && !empty($comment)){ //名前とコメントが送信されて
            if(empty($editnumber) ){//編集番号がないとき
                $fp = fopen($filename,"a");
                fwrite($fp,$result . PHP_EOL);
                fclose($fp);
            }
        }
        
        
        
        
        if(!empty($edit)){ //編集番号が送信されて
            
            for($i = 0; $i < count($items); $i++) {
                $array = explode("<>",$items[$i]); //<>で分割
                if($edit == $array[0] && $editpass  == $array[4] ){ //投稿番号と編集対象番号を比較、パスワード確認
                    $editnumber = $array[0]; //投稿番号を取得
                    $editname = $array[1];//名前を取得
                    $editcomment = $array[2];//コメントを取得
                    
                    
                }   
            }
        } 
        
        
        
        if(!empty($name) && !empty($comment)){ //名前とコメントがあって
            if(!empty($editnumber)){ //編集番号があるとき
                    $num = $editnumber;//投稿番号を編集対象の番号にする
                    $result = $num ."<>" .  $name . "<>" . $comment .  "<>" . $date . "<>" . $pass . "<>";//上書きするからもう一度
                                                                                    //書き入れるものを定義する
                    $fp=fopen($filename, "w");
                        
                        for($i = 0 ; $i < count($items); $i++ ){
                            $array = explode ("<>", $items[$i]);
                            if($array[0] == $editnumber && $array[4] == $pass ){     //編集対象と投稿番号が一致してパスワードが正しいとき          
                                fwrite ($fp, $result . PHP_EOL);//先ほど定義したのを書き入れる               
                            }else{                                     
                                fwrite ($fp, $items[$i] . PHP_EOL );               
                            }
                        } fclose($fp);      
                
                       }
                    }    
                
        
        
        ?>
        <!DOCTYPE html>
       <html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_3-5</title>
    </head>
    <body>
        
         <form action = "" method = "post">
             
             <p>[投稿フォーム]</p>
             
            名前: <input type = "text" name = "name"  value = "<?php echo $editname?>"><br>
                 
            コメント: <input type = "text" name = "comment"  value = "<?php echo $editcomment;?>">
                     
             <input type = "hidden" name = "editnumber" value = "<?php echo $editnumber ?>" >
             <br>
             パスワード： <input type = "password" name = "pass" placeholder = "パスワードを入力">
             <input type = "submit" name = "submit">
             
             
             <p>[削除フォーム]</p>
            
             削除対象番号：<input type = "number" name = "deletenumber" placeholder = "削除番号を入力" ><br>
             
             パスワード：  <input type = "password" name = "depass" placeholder = "パスワードを入力">
             <input type = "submit" value = "削除">
             
             
             <p>[編集フォーム]</p>
             編集対象番号：<input type = "number" name = "edit" placeholder = "編集番号を入力"><br>
             
             パスワード：  <input type = "password" name = "editpass" placeholder = "パスワードを入力">
             <input type = "submit"  value = "編集">
                 
                
             
        </form>
        
        <br><br>
        <p>[投稿一覧]</p>
        
        <?php
        $items = file($filename); //編集や削除が終わった後のものを読み込むためもう一度ファイル関数を使う
        foreach($items as $item){//テキストファイルの内容を配列にする
            $array = explode("<>",$item);
            
            echo $array[0] ;
            echo $array[1] ;
            echo $array[2] ;
            echo $array[3] . "<br>" ;
        }
        ?>
        
    </body>
    
    
</html>