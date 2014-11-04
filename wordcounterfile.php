<?php
// Include utility files
require_once 'config.php';
//include pdftotxt class file
require_once 'pdftotxt.class.php';

ini_set('memory_limit', '256M');
ini_set('max_execution_time', 0);
$updateword = 0;
$addword = 0;

try
{

    if(isset($_FILES["file"]["name"]))
    {

		if ($_FILES["file"]["type"] == "text/plain") {

 			$txtfile = fopen("upload/".$_FILES["file"]["name"], "r") or die("Unable to open txt file!");  // you can chenge file uploud path
			$str = fread($txtfile,filesize("upload/".$_FILES["file"]["name"]));  // you can chenge file uploud path
			fclose($txtfile);
		}
		elseif ($_FILES["file"]["type"] == "application/pdf") {
			$a = new PDF2Text();
			$a->setFilename("upload/".$_FILES["file"]["name"]);  // you can chenge file uploud path
			$a->decodePDF();
			$str = $a->output();		   
		}
		else {
			throw new Exception("Error: file type is invalid." , 1);
		}

		
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

	  	print("update word = ".$updateword." and add word = ".$addword." from ".$_FILES["file"]["name"]);
	  	print("<br><a href='".SITE_URL."'>Back To Home</a><br>");

	}
	else
    {
        //
        throw new Exception("Error: Invalid file", 1);
        
    }
}
catch( Exception $e )
{
	//catch any exceptions and report the problem
    $result = $e->getMessage();
    print($result);
}

?>