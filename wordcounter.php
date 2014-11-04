<?php
// Include utility files
require_once 'config.php';


ini_set('memory_limit', '256M');
ini_set('max_execution_time', 0);
$updateword = 0;
$addword = 0;


try
{
    if(isset($_POST["text"]) && ($_POST["text"] != ""))
    {
		$str = $_POST["text"];
		$words = array_count_values(str_word_count($str, 1));      // this function work only with ASCII

		$obj_connect= new PDO(DSN,DBUSER,DBPASS);


		foreach ($words as $word => $count) {

			$qery = "select * from wordscount where word=:word";
			$stmt = $obj_connect->prepare($qery);
			$stmt->bindValue(':word', $word);
			$stmt->execute();

		  	if($res = $stmt->fetchAll())
		  	{
		  		$addcount = $res["0"]["2"];
		  		$addcount += $count;
		  		$qery = "UPDATE wordscount SET count=:addcount WHERE word=:word";
	            $stmt = $obj_connect->prepare($qery);
	            $stmt->bindValue(':addcount', $addcount);
	            $stmt->bindValue(':word', $word);
	            $stmt->execute();
				
				$updateword ++;
		  	}
		  	else
		  	{
		  		$qery = "INSERT INTO wordscount (word,count) VALUES (:word,:count)";
	            $stmt = $obj_connect->prepare($qery);
	            $stmt->bindValue(':count', $count);
	            $stmt->bindValue(':word', $word);
	            $stmt->execute();

		  		$addword ++;
		  	}
		}

		
	  	$obj_connect = null;

	  	print("update word = ".$updateword." and add word = ".$addword);
	  	print("<br><a href='".SITE_URL."'>Back To Home</a>");
	}
	else
    {
        //
        throw new Exception("you dont enter any text", 1);
        
    }
}
catch( Exception $e )
{
	//catch any exceptions and report the problem
    $result = $e->getMessage();
    print($result);
}

?>