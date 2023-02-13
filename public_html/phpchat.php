<form action="" method="post" onsubmit="return validate()" name="form">
        名前
        <div><input type="text" name="n"></div>
        メッセージ
        <div><textarea name="m"></textarea></div>
        <div class="chat-submit">
        <input type="submit" value="送信" name="submit">
        </div>
</form>
<!-----------DBに書き込み--------------->
    <?php
    if(isset($_POST['n'])) {
        
$my_nam=htmlspecialchars($_POST["n"], ENT_QUOTES);//名前を$my_namに代入
$my_mes=htmlspecialchars($_POST["m"], ENT_QUOTES);//メッセージを$my_mesに代入
$host="localhost";
$dbname="chatdb.chattb";
$char="utf8";
$dsn= "mysql:host=$host;dbname=$dbname;charset=$char"; 
$user="user";
$pass="";
    
    try{
        
$db = new PDO($dsn,$user,$pass);
$db->query("INSERT INTO `chat-tb` (ban,nam,mes,dat)
            VALUES (NULL,'$my_nam','$my_mes',NOW())");//テーブルに値を入れる（Mysqlのqueryを実行）
               //SQL文で'chat-tb'テーブルに番号・名前・メッセージ・日付の内容を取得して保存していく
        }catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;//エラーが出たときの処理
}
              
header("Location: {$_SERVER['PHP_SELF']}");//このページに戻ってくる（header関数）
exit;
    
    }
?>

<?php  
    $dsn= "mysql:host=$host;dbname=$dbname;charset=$char";
    $db = new PDO($dsn,$user,$pass);
    $ps = $db->query("SELECT * FROM chatdb.chattb ORDER BY ban DESC");//「chat-tb」テーブルから番号の降順に投稿内容を取得する
        




    define("SECMINUITE", 60);					//1分（秒）
    define("SECHOUR",    60 * 60);				//1時間（秒）
    define("SECDAY",     60 * 60 * 24);			//1日（秒）
    define("SECWEEK",    60 * 60 * 24 * 7);		//1週（秒）
    define("SECMONTH",   60 * 60 * 24 * 30);	//1月（秒）
    define("SECYEAR",    60 * 60 * 24 * 365);	//1年（秒）

        
    function niceTime($dest,$sour) {      
        $sour = (func_num_args() == 1) ? time() : func_get_arg(1);
        
     $tt = $dest - $sour;
    
 
    if ($tt / SECYEAR  < -1) return abs(round($tt / SECYEAR))    . '年前';
    if ($tt / SECMONTH < -1) return abs(round($tt / SECMONTH))   . 'ヶ月前';
    if ($tt / SECWEEK  < -1) return abs(round($tt / SECWEEK))    . '週間前';
    if ($tt / SECDAY   < -1) return abs(round($tt / SECDAY))     . '日前';
    if ($tt / SECHOUR  < -1) return abs(round($tt / SECHOUR))    . '時間前';
    if ($tt / SECMINUITE < -1)   return abs(round($tt / SECMINUITE)) . '分前';
    if ($tt < 0)                return abs(round($tt)) . '秒前';
    if ($tt / SECYEAR  > +1) return abs(round($tt / SECYEAR))    . '年後';
    if ($tt / SECMONTH > +1) return abs(round($tt / SECMONTH))   . 'ヶ月後';
    if ($tt / SECWEEK  > +1) return abs(round($tt / SECWEEK))    . '週間後';
    if ($tt / SECDAY   > +1) return abs(round($tt / SECDAY))     . '日後';
    if ($tt / SECHOUR  > +1) return abs(round($tt / SECHOUR))    . '時間後';
    if ($tt / SECMINUITE > +1)   return abs(round($tt / SECMINUITE)) . '分後';
    if ($tt > 0)                return abs(round($tt)) . '秒後';
     return '現在';
 }
 //===================================================   
      
 //ここまで「何分前」の表示プログラム====================================      
 
        try{
        
   while($r = $ps->fetch()){ 　//それぞれの投稿内容（名前＋メッセージ＋番号＋日時）を$rに代入（while文とfetch関数を使用）
        
//ここから「何分前」の表示プログラム==================
    $beforedest = $r["dat"];//投稿された時刻を$beforedestに代入
    $dest = strtotime($beforedest);//$beforedestの時刻をUnix タイムスタンプに変換（strtotime関数を使用）
    $sour = time(); //現在の時刻を$sourに代入 
    $outstr = nicetime($dest,$sour);//上で作ったnicetime関数に第一・ニ引数を入れて$outstrに代入 
?>       
        
        <div class="chat-list">
        <div class="chat-name">
    <?php
    print "{$r['nam']}";?>//名前の表示
        </div>
        
        <div class="chat-date">
    <?php
        print $outstr;?>//何分前の表示
        </div>
        
        <div class="chat-message">
    <?php    
    print nl2br($r['mes']); ?> //メッセージを表示
        </div> 
        
        </div><hr>
    <?php }
            
        }catch(Exception $e){
          echo $e->getMessage() . PHP_EOL;//エラーが出たときの処理
      }
      ?>