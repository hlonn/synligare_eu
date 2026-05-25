<!DOCTYPE html>
<html>
    
    <?php
	echo '<form method="post" action="tag_cloud_gen.php" name="gen_tag_db">';
	echo '<p>Input your text here:</p><p><textarea name="tag_input" rows="20" cols="80"></textarea></p>';
	echo '<input type="submit" name="submit">';
	echo '</form>';
?>

<h3>OR</h3>

<p>see the current tag cloud here</p>
<?php
	echo '<form name="show_tag_cloud" method="post" action="show_tag_cloud.php">';
	echo '<input type="submit" value="show current tag cloud" >';
	echo '</form>';
?>
