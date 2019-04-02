<?php
include 'database.php';

if(isset($_POST['submit'])){
	$name = mysqli_real_escape_string($conn,$_POST['name']);
	$singername = mysqli_real_escape_string($conn,$_POST['singername']);
	$albumname = mysqli_real_escape_string($conn,$_POST['albumname']);	
	$releasedate = mysqli_real_escape_string($conn,$_POST['releasedate']);
	$pbtime = mysqli_real_escape_string($conn,$_POST['pbtime']);
	$genere = mysqli_real_escape_string($conn,$_POST['genere']);
	$lang = mysqli_real_escape_string($conn,$_POST['language']);
	$hits = mysqli_real_escape_string($conn,$_POST['hits']);

	if(!isset($name) || $name == '' || !isset($singername) || $singername == ''||!isset($albumname) || $albumname == '') {
	 	$error = "Please fill in all three --> Song name, Singer Name and Album Name!!!";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	 }
	 else{
	 	$sing_check = "SELECT sid from singer WHERE name = '$singername'";
	 	$sing_check2 = $conn->query($sing_check);
	 	$album_check = "SELECT aid from album WHERE name = '$albumname'";
	 	$album_check2 = $conn->query($album_check);
	 	
	 	if(mysqli_num_rows($album_check2)==0 && (!isset($releasedate) || $releasedate == '') ){
			$error = "Please fill in Release Date for this New album";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();
	 		
	 	}
	 	
	 	
		if(mysqli_num_rows($album_check2)==0){
			if(mysqli_num_rows($sing_check2)==0){
	 		$query = "INSERT INTO singer (name) VALUES ('$singername')";
	 		mysqli_query($conn,$query);
			}

			$t_sid="SELECT sid from singer WHERE name = '$singername'";
			$p_sid=$conn->query($t_sid);
			$row1 = mysqli_fetch_assoc($p_sid);
			$f_sid=$row1['sid'];

			$query = "INSERT INTO album (name,releasedate,sid) VALUES ('$albumname','$releasedate','$f_sid')";
		 	mysqli_query($conn,$query);
	 	}

	 	$t_aid="SELECT aid from album WHERE name = '$albumname'";
		$p_aid=$conn->query($t_aid);
		$row2 = mysqli_fetch_assoc($p_aid);
		$f_aid=$row2['aid'];


	 	$query = "INSERT INTO song (name,pbtime,genere,lang,hits,aid) VALUES ('$name','$pbtime','$genere','$lang','$hits','$f_aid')";
		mysqli_query($conn,$query);

	 	$add = "Song added Succesfully..";
	 	header("location: index.php?add=".urlencode($add));
	 		exit();


	 }

}


if(isset($_POST['submit2'])){
	$singername = mysqli_real_escape_string($conn,$_POST['singername']);


	if(!isset($singername) || $singername == '') {
	 	$error = "Please fill in Singer Name";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
	 	$sing_check = "SELECT sid from singer WHERE name = '$singername'";
	 	$sing_check2 = $conn->query($sing_check);
	 	
	 	if(mysqli_num_rows($sing_check2)>0){
	 		$error = "Singer already exists.. Can't Overwrite!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}
	 	$query = "INSERT INTO singer (name) VALUES ('$singername')";
	 	mysqli_query($conn,$query);

	 	$add = "Singer added Succesfully..";
	 	header("location: index.php?add=".urlencode($add));
	 	exit();
	}
}


if(isset($_POST['submit3'])){
	$singername = mysqli_real_escape_string($conn,$_POST['singername']);
	$albumname = mysqli_real_escape_string($conn,$_POST['albumname']);
	$releasedate = mysqli_real_escape_string($conn,$_POST['releasedate']);

	if(!isset($singername) || $singername == '' || !isset($albumname) || $albumname == '' || !isset($releasedate) || $releasedate == '') {
	 	$error = "Please fill in Album Name, Singer Name and Release Date";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
		$sing_check = "SELECT sid from singer WHERE name = '$singername'";
		$sing_check2 = $conn->query($sing_check);
		$album_check = "SELECT aid from album WHERE name = '$albumname'";
		$album_check2 = $conn->query($album_check);
		if(mysqli_num_rows($album_check2)>0){
			$error = "Album already exists.. Can't Overwrite!!";
			header("location: index.php?error=".urlencode($error));
			exit();
		}
		if(mysqli_num_rows($sing_check2)==0){
			$query = "INSERT INTO singer (name) VALUES ('$singername')";
			mysqli_query($conn,$query);
		}

		$t_sid="SELECT sid from singer WHERE name = '$singername'";
		$p_sid=$conn->query($t_sid);
		$row1 = mysqli_fetch_assoc($p_sid);
		$f_sid=$row1['sid'];

	 	$query = "INSERT INTO album (name,releasedate,sid) VALUES ('$albumname','$releasedate','$f_sid')";
	 	mysqli_query($conn,$query);

		$add = "Album added Succesfully..";
		header("location: index.php?add=".urlencode($add));
		exit();

	}
}


if(isset($_POST['submit4'])){
	$name = mysqli_real_escape_string($conn,$_POST['name']);

	if(!isset($name) || $name == '') {
	 	$error = "Please fill in a Song Name to delete";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
	 	$song_check = "SELECT * from song WHERE name = '$name'";
	 	$song_check2 = $conn->query($song_check);
	 	
	 	if(mysqli_num_rows($song_check2)==0){
	 		$error = "No song with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}

	 	$query = "DELETE FROM song where name ='$name'";
	 	mysqli_query($conn,$query);

	 	$add = "Song deleted successfully..";
	 	header("location: index.php?add=".urlencode($add));
	 	exit();
	}
}


if(isset($_POST['submit5'])){
	$albumname = mysqli_real_escape_string($conn,$_POST['albumname']);

	if(!isset($albumname) || $albumname == '') {
	 	$error = "Please fill in a Album Name to delete";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
	 	$album_check = "SELECT * from album WHERE name = '$albumname'";
	 	$album_check2 = $conn->query($album_check);
	 	
	 	if(mysqli_num_rows($album_check2)==0){
	 		$error = "No Album with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}

	 	$row = mysqli_fetch_assoc($album_check2);
		$f_aid=$row['aid'];

		$query = "DELETE FROM song where aid= '$f_aid'";
		mysqli_query($conn,$query);
		
	 	$query = "DELETE FROM album where aid ='$f_aid'";
	 	mysqli_query($conn,$query);

	 	$add = "Album deleted successfully..";
	 	header("location: index.php?add=".urlencode($add));
	 	exit();
	}
}


if(isset($_POST['submit6'])){
	$singername = mysqli_real_escape_string($conn,$_POST['singername']);


	if(!isset($singername) || $singername == '') {
	 	$error = "Please fill in a Singer Name to delete";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
	 	$singer_check = "SELECT * from singer WHERE name = '$singername'";
	 	$singer_check2 = $conn->query($singer_check);
	 	
	 	if(mysqli_num_rows($singer_check2)==0){
	 		$error = "No Singer with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}

	 	$row = mysqli_fetch_assoc($singer_check2);
		$f_sid=$row['sid'];

		// $query = "DELETE FROM song where aid IN (SELECT aid from album where sid = '$f_sid')";
		$album_check = "SELECT * from album WHERE sid = '$f_sid'";
	 	$album_check2 = $conn->query($album_check);

		while($row2 = mysqli_fetch_assoc($album_check2)){
			$temp = $row2['aid'];
			$query = "DELETE FROM song where aid ='$temp'";
	 		mysqli_query($conn,$query);	
		}
		mysqli_query($conn,$query);
		
	 	$query = "DELETE FROM album where sid ='$f_sid'";
	 	mysqli_query($conn,$query);

	 	$query = "DELETE FROM singer where sid ='$f_sid'";
	 	mysqli_query($conn,$query);


	 	$add = "Singer deleted successfully..";
	 	header("location: index.php?add=".urlencode($add));
	 	exit();
	}
}

if(isset($_POST['submit7'])){
	$name = mysqli_real_escape_string($conn,$_POST['name']);
	$singername = mysqli_real_escape_string($conn,$_POST['singername']);
	$albumname = mysqli_real_escape_string($conn,$_POST['albumname']);	
	$releasedate = mysqli_real_escape_string($conn,$_POST['releasedate']);
	$pbtime = mysqli_real_escape_string($conn,$_POST['pbtime']);
	$genere = mysqli_real_escape_string($conn,$_POST['genere']);
	$lang = mysqli_real_escape_string($conn,$_POST['language']);
	$hits = mysqli_real_escape_string($conn,$_POST['hits']);


	if((!isset($name) || $name == '') && (!isset($singername) || $singername == '')&& (!isset($albumname) || $albumname == '') && (!isset($hits) || $hits == '')) {
	 	$error = "Please fill in either Song Name or Singer Name or Album Name or hits";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
		if(isset($name) && $name !=''){
			$song_check = "SELECT * from song WHERE name = '$name'";
		 	$song_check2 = $conn->query($song_check);

		 	if(mysqli_num_rows($song_check2)==0){
	 		$error = "No Song with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 		}
	 		else{
	 			$song_="SELECT * from song WHERE name = '$name'";
	 			$song_2 = $conn->query($song_);
	 			$row = mysqli_fetch_assoc($song_2);

	 			$alb = $row['aid'];
	 			$alb_ = "SELECT * from album WHERE aid = '$alb'";
	 			$alb_2 = $conn->query($alb_);
	 			$row2 = mysqli_fetch_assoc($alb_2);

	 			$singid = $row2['sid'];
	 			$sing_ = "SELECT name from singer WHERE sid = '$singid'";
	 			$sing_2 = $conn->query($sing_);
	 			$row3 = mysqli_fetch_assoc($sing_2);
	 			$singer_name = $row3['name'];
	 			$album_name = $row2['name'];
	 			
	 			
	 			$hero = "Song- ".$row['name']."<br>"."Singer-".$singer_name."<br>"."Album -".$album_name.'<br>'."Genre- ". $row['genere']."<br>"."Length- ". $row['pbtime']."<br>"."Language- ". $row['lang']."<br>";
				header("location: index.php?hero=".urlencode($hero));	
				exit();

	 		}


		}

		if(isset($singername) && $singername !='' && $genere=='' && $lang==''){
			$singer_check = "SELECT * from singer WHERE name = '$singername'";
		 	$singer_check2 = $conn->query($singer_check);

		 	if(mysqli_num_rows($singer_check2)==0){
	 		$error = "No Singer with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 		}
	 		else{
	 			$singer_="SELECT * from singer WHERE name = '$singername'";
	 			$singer_2 = $conn->query($singer_);
	 			$row = mysqli_fetch_assoc($singer_2);

	 			$sid = $row['sid'];
	 			$hero = "<font size='4' color='red'>".$row['name']."</font>"."<br>";
	 			$alb_ = "SELECT * from album WHERE sid = '$sid'";
	 			$alb_2 = $conn->query($alb_);
	 			while($row2 = mysqli_fetch_assoc($alb_2)){
	 				$aid = $row2['aid'];
	 				$hero = $hero."<br>"."<font size='3' color='blue'>".$row2['name']."</font>"."<br>";
	 				$song_ = "SELECT * from song WHERE aid = '$aid'";
	 				$song_2 = $conn->query($song_);
	 				while($row3 = mysqli_fetch_assoc($song_2)){
	 					$songname_ = $row3['name'];
	 					$hero = $hero.$row3['name']."<br>";

	 				}

	 			}




	 			header("location: index.php?hero=".urlencode($hero));	
				exit();

	 		}


		}

		if(isset($albumname) && $albumname !=''){
		$album_check = "SELECT * from album WHERE name = '$albumname'";
		$album_check2 = $conn->query($album_check);

		if(mysqli_num_rows($album_check2)==0){
	 		$error = "No Album with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}
	 	else{
	 		$album_="SELECT * from album WHERE name = '$albumname'";
	 		$album_2 = $conn->query($album_);
	 		$row = mysqli_fetch_assoc($album_2);

	 		$aid = $row['aid'];
	 		$hero = $row['name']."<br>";
	 		$song_ = "SELECT * from song WHERE aid = '$aid'";
	 		$song_2 = $conn->query($song_);
	 		while($row2 = mysqli_fetch_assoc($song_2)){
	 			$aid = $row2['name'];
	 			$hero = $hero.$aid."<br>";
	 		}

	 		header("location: index.php?hero=".urlencode($hero));	
			exit();

	 		}


		}
	 	
	 	// $add = "Song deleted successfully..";
	 	// header("location: index.php?add=".urlencode($add));
	 	// exit();

		if(isset($singername) && $singername !='' && isset($genere) && $genere !='' ){
			$singer_check = "SELECT * from singer WHERE name = '$singername'";
		 	$singer_check2 = $conn->query($singer_check);

		 	if(mysqli_num_rows($singer_check2)==0){
	 		$error = "No Singer with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 		}
	 		else{
	 			$singer_="SELECT * from singer WHERE name = '$singername'";
	 			$singer_2 = $conn->query($singer_);
	 			$row = mysqli_fetch_assoc($singer_2);

	 			$sid = $row['sid'];
	 			$hero = $row['name']."<br>";
	 			$alb_ = "SELECT * from album WHERE sid = '$sid'";
	 			$alb_2 = $conn->query($alb_);
	 			while($row2 = mysqli_fetch_assoc($alb_2)){
	 				$aid = $row2['aid'];
	 				// $hero = $hero."<br>".$row2['name']."<br>";
	 				$song_ = "SELECT * from song WHERE aid = '$aid' and genere='$genere'";
	 				$song_2 = $conn->query($song_);
	 				while($row3 = mysqli_fetch_assoc($song_2)){
	 					$songname_ = $row3['name'];
	 					$hero = $hero.$row3['name']."<br>";

	 				}

	 			}




	 			header("location: index.php?hero=".urlencode($hero));	
				exit();

	 		}


		}

		if(isset($singername) && $singername !='' && isset($lang) && $lang !='' ){
			$singer_check = "SELECT * from singer WHERE name = '$singername'";
		 	$singer_check2 = $conn->query($singer_check);

		 	if(mysqli_num_rows($singer_check2)==0){
	 		$error = "No Singer with Entered Name exists in Database!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 		}
	 		else{
	 			$singer_="SELECT * from singer WHERE name = '$singername'";
	 			$singer_2 = $conn->query($singer_);
	 			$row = mysqli_fetch_assoc($singer_2);

	 			$sid = $row['sid'];
	 			$hero = $row['name']."<br>";
	 			$alb_ = "SELECT * from album WHERE sid = '$sid'";
	 			$alb_2 = $conn->query($alb_);
	 			while($row2 = mysqli_fetch_assoc($alb_2)){
	 				$aid = $row2['aid'];
	 				// $hero = $hero."<br>".$row2['name']."<br>";
	 				$song_ = "SELECT * from song WHERE aid = '$aid' and lang='$lang'";
	 				$song_2 = $conn->query($song_);
	 				while($row3 = mysqli_fetch_assoc($song_2)){
	 					$songname_ = $row3['name'];
	 					$hero = $hero.$row3['name']."<br>";

	 				}

	 			}

	 			header("location: index.php?hero=".urlencode($hero));	
				exit();

	 		}


		}


		if(isset($hits) && $hits !=''){
			
		 	if($hits<0 || $hits>10){
	 		$error = "Hits should be in 0-10 range!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 		}
	 		else{
	 			$hero = '<font size=3>';

	 			$song_ = "SELECT * from song WHERE hits>= $hits ORDER BY hits";
	 			$song_2 = $conn->query($song_);
	 			while($row3 = mysqli_fetch_assoc($song_2)){
	 				$songname_ = $row3['name'];
	 				$hero = $hero.$row3['name']."  - ".$row3['hits']."<br>";

	 			}
	 			$hero=$hero."</font>";

	 			header("location: index.php?hero=".urlencode($hero));	
				exit();		

	 		}

		}

		
	}
}


if(isset($_POST['submit8'])){
	$songname = mysqli_real_escape_string($conn,$_POST['name']);
	$hits = mysqli_real_escape_string($conn,$_POST['hits']);


	if(!isset($songname) || $songname == '' || !isset($hits) || $hits == '') {
	 	$error = "Please fill in a both Song Name and hits to Update hits";
	 	header("location: index.php?error=".urlencode($error));
	 	exit();
	}
	else{
	 	$song_check = "SELECT * from song WHERE name = '$songname'";
	 	$song_check2 = $conn->query($song_check);
	 	
	 	if(mysqli_num_rows($song_check2)==0){
	 		$error = "Please input a correct Song Name!!";
	 		header("location: index.php?error=".urlencode($error));
	 		exit();

	 	}

	 	
		$query = "Update song SET hits = $hits where name = '$songname' ";
		mysqli_query($conn,$query);
		
	 	
	 	$add = "Hits Updated successfully..";
	 	header("location: index.php?add=".urlencode($add));
	 	exit();
	 }
}



?>

