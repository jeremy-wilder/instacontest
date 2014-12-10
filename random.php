<?php

// connection to db
// basic functions 


$blog_id = getBlogId();

$ts = time();

$winner = mysql_field("SELECT url FROM wp_live_winner WHERE blog_id=$blog_id");

if (!$_SESSION[_member] && !$winner) {
		?>Please <a href="/login">Login</a> or <a href="/signup">Sign up</a> to select a winner.<? 
		exit();
		}
?>The winner is of this contest chosen at random by a registered member from all the entries on instagram.<br />
You do not have to be a registered member to win.<br />
 We do this to make the possibility of being selected based on two factors:<br /><br />
1) the server randomly selecting an entry<br /> 2) the randomness of a user activating the script.<br /><br /><?
if ($winner) { echo "<b>Winner</b> - <a href='$winner'>". $winner."</a>"; } else {

	$sql = mysql_query("SELECT * FROM  `wp_live` WHERE  `blog_id` = $blog_id AND user_id NOT IN (6435181, 19289771, 216429479, 228081701) ORDER BY RAND() LIMIT 1"); // excludes us and shops from winning
	while($row=mysql_fetch_array($sql)) {
		echo "<b>Winner</b> - <a href='$row[url]'>".$row[url] . "</a><br />";
		
		$sqlr = "INSERT INTO wp_live_winner (blog_id, url, selected_by, ts) VALUES ($blog_id, '$row[url]', $_SESSION[_member], $ts)";
		mysql_query($sqlr);
	}
	
	
	}
