<?php
date_default_timezone_set('Asia/Tokyo');

$dataFile = 'bbs.dat';

session_start();

function setToken() {
	$token = sha1(uniqid(mt_rand(), true));
	$_SESSION['token'] = $token;

}
function checkToken() {
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $_POST['token'])) {
    	// echo "不正なPOSTが行われました！";
    	// exit;
    }
}

function h($s) {
	return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['message']) &&
    isset($_POST['user'])) {
  
    checkToken();

	$message = trim($_POST['message']);
	$user = trim($_POST['user']);


	if ($message !== '') {
	     
	   $user = ($user === '') ? '名無しさん' : $user;
	   $message = str_replace("\t", '' , $message);
	   $user = str_replace("\t", '' , $user);

        

       
        $postedAt = date('Y-m-d H:i:s');
	    $newData = $message . "\t" . $user . "\t" . $postedAt."\n";



		$fp = fopen($dataFile, 'a');
		fwrite($fp, $newData);
    	fclose($fp);

	} else {
		setToken();
	}
	

}
$posts = file($dataFile, FILE_IGNORE_NEW_LINES );

$posts = array_reverse($posts);



?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">	
	<title>掲示板</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	<header>
		<div class="title text-right mb-5 mr-4">
　　　     <h1>競馬予想</h1>
        </div>
    </header>
    <section>
    	<div class="top">

    	</div>	
    </section>
　　　<form action="" method="post">
	   <div class="_post text-left ml-3">
	   	<input type="text" name="message" class="form-control mb-2" placeholder="message"><br>
	    <input type="text" name="user" class="form-control mb-2" placeholder="user">
	     <input class="btn btn-primary "type="submit"  value="投稿">  
	     <input type="hidden" name="token" value="<?php echo h($_SESSION['token']) ?>">
	  </div>
     </form>
     <div class="post">
     <h2 class="bg-white __post ml-3">投稿一覧　(<?php echo count($posts); ?>件)</h2>
     
     <ul>
     	<?php if (count($posts)) : ?>
     		<?php foreach ($posts as $post) : ?>
     		<?php list($message, $user, $postedAt) = explode("\t", $post); ?>
     			<li><?php echo h($message); ?>(<?php echo h($user); ?>) - <?php echo h($postedAt); ?></li>
     		<?php endforeach; ?>
     	<?php else : ?>	
     	<li>まだ投稿はありません。</li>
     <?php endif; ?>
    
     </ul>
 </div>
   <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
