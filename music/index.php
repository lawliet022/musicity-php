<?php include 'database.php'?>
<?php
$que = "SELECT * FROM singer";
$sing = $conn->query($que);

$que = "SELECT * FROM album";
$alb = $conn->query($que);

$que = "SELECT * FROM song order by hits desc LIMIT 10";
$song = $conn->query($que);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>MusiCity! </title>
		<link rel="stylesheet" href="css/style.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<header>
				<h1><center>You are Welcome at <stong>MusiCity</stong></center></h1>
			</header>
			<div id="sings">
				<center><strong><font size=5>Top 10 Songs</font> </strong> </center><br>
				<ul>
					<?php while($row = mysqli_fetch_assoc($song)): ?>
						<li class="sing"> <span><?php echo $row['songid'] ?></span> - <strong> <?php echo $row['name'] ?></strong> - <?php echo $row['genere'] ?> </li>
					<?php endwhile ; ?>		 
				</ul> 
			</div>
			<div id="sings">
				<center><strong><font size=5>Search Results</font> </strong> </center><br>
				<ul>
					<li class="sing">
				<?php if(isset($_GET['hero'])) : ?>
					<?php echo $_GET['hero']; ?>
				<?php endif; ?>
			</li>
			</ul>
			</div>
			<div id="input">
				<?php if(isset($_GET['error'])) : ?>
					<div class= "error"><?php echo $_GET['error']; ?></div>
				<?php endif; ?>
				<?php if(isset($_GET['add'])) : ?>
					<div class= "add"><?php echo $_GET['add']; ?></div>
				<?php endif; ?>
				<form method="post" action="process.php">
					<input type="text" name="name" placeholder="Song Name"/>
					<input type="text" name="singername" placeholder="Singer Name"/>
					<input type="text" name="albumname" placeholder="Album Name"/>
					<input type="text" name="releasedate" placeholder="Album Release Date"/>
					<br>
					<input type="text" name="pbtime" placeholder="Enter Playback Time"/>
					<input type="text" name="genere" placeholder="Enter Genere"/>
					<input type="text" name ="language" placeholder="Language" />
					<input type="text" name="hits" placeholder="Hits"/>
					<br />
					<center>
					<input class="shout-btn" type="submit" name="submit" value="Insert Song" />
					<input class="shout-btn" type="submit" name="submit2" value="Insert Singer" />
					<input class="shout-btn" type="submit" name="submit3" value="Insert Album" />
					<input class="shout-btn" type="submit" name="submit4" value="Delete a Song" />
					<input class="shout-btn" type="submit" name="submit5" value="Delete an Album" />
					<input class="shout-btn" type="submit" name="submit6" value="Delete entire Singer's Record" />
					<input class="shout-btn" type="submit" name="submit7" value="Search" />
					<input class="shout-btn" type="submit" name="nothing" value="" />
					<input class="shout-btn" type="submit" name="submit8" value="Update hits" />
				</center>
				</form>
			</div>
		</div>>	
	</body>
</html>