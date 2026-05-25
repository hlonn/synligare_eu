<?php

$debug=false;



///////////////////////////////////////////////////////////////////////////////////////////////////////
/**
* this function will update the mysql database table to reflect the new count of the keyword
* i.e. the sum of current count in the mysql database &amp;amp;amp;amp; current count in the input.
*/
function update_database_entry($link,$table,$keyword,$weight){

	
	$string=$_POST['tag_input'];
	$link = mysqli_connect("localhost", "c9nvm403l_synligare_eutagcloud", "tagmaster", "c9nvm403l_synligare_eutagcloud");

	/**
	* now comes the main part of generating the tag cloud
	* we would use a css styling for deciding the size of the tag according to its weight, 
	* both of which would be fetched from mysql database.
	*/

//	$query="select * from `synligare_eutagcloud`.`tagtable` where keyword like '%$keyword%'";
//	$query=	"SELECT * FROM `tagtable` WHERE `keyword` LIKE 'a'";
	$query=	"SELECT * FROM `tagtable` WHERE `keyword` LIKE ".$keyword;
	$resultset=mysqli_query($link, $query);
if ($debug) printf("updating");
    if ($debug) printf($resultset->field_seek); 
	if(!$resultset){
		die('Invalid query: ' . mysqli_error($link));
	} else {
		if ($debug) printf("Seek OK; ");
		while($row=mysqli_fetch_array($resultset)){
//		$query="UPDATE `tagtable`.`tags` SET weight=".($row[2]+$weight)." where tag_id=".$row[0].";";
//		$query="UPDATE `tagtable`.`tags` SET weight=77 where tag_id=".$row[0].";";

		$query="UPDATE `tagtable` SET `weight` =". ($weight+$row[2]) ." WHERE `tagtable`.`id` = ".$row[0];

		
		mysqli_query($link, $query);
		if ($debug) printf("Updated with return code: ");
		if ($debug) printf(mysqli_errno($link));

	}
}
}
?>
<?php
/*
* get the input string from the post and then tokenize it to get each word, save the words in an array
* in case the word is repeated add '1' to the existing words counter
*/





$string=$_POST['tag_input'];

//printf("String is".$string);




	$count=0;
	$tok = strtok($string, " \t,;.\'\"!&-`\n\r");    //considering line-return,line-feed,white space,comma,ampersand,tab,etc... as word separator
	if(strlen($tok)>0) $tok=strtolower($tok);
	$words=array();
	$words[$tok]=1;
	while ($tok !== false) {
		if ($debug) echo "Word=$tok";
		$tok = strtok(" \t,;.\'\"!&-`\n\r");
		if(strlen($tok)>0) {
		$tok=strtolower($tok);
		if($words[$tok]>=1){
			$words[$tok]=$words[$tok] + 1;
		} else {
			$words[$tok]=1;
		}
	}
}
print_r($words);
printf("added to the database");
echo '';



/**
* now enter the above array of word and corresponding count values into the database table
* in case the keyword already exist in the table then update the database table using the function 'update_database_entry(...)'
*/
$table="c9nvm403l_synligare_eutagcloud";
//mysqli_select_db($link, $table);




$link = mysqli_connect("localhost", "c9nvm403l_synligare_eutagcloud", "tagmaster", "c9nvm403l_synligare_eutagcloud");

/* check connection */
if ($debug) printf("Connecting... ");
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

else if ($debug) printf("Success\n\n !!");




/*

	$query="INSERT INTO `tagtable` (`id`, `keyword`, `weight`, `link`, `reg_date`) VALUES ('2', 'andra', '2', 'www.a.b', current_timestamp())";
	if(mysqli_query($link, $query)) {
		printf("line added!!"); }
		else
		printf("Error".mysqli_errno($link));

	$query="INSERT INTO `tagtable` (`keyword`, `weight`, `link`, `reg_date`) VALUES ('tredje', '2', 'www.a.b', current_timestamp())";
	if(mysqli_query($link, $query)) {
		printf("line added!!"); }
		else
		printf("Error".mysqli_errno($link));

$keyw="\""."anotherr"."\"";
$wei=76;

	$query="INSERT INTO `tagtable` (`keyword`, `weight`, `link`, `reg_date`) VALUES ($keyw, $wei, 'www.a.b', current_timestamp())";
	printf($query);
	if(mysqli_query($link, $query)) {
		printf("line added!!"); }
		else
		printf("Förfel".mysqli_errno($link));

*/

foreach($words as $keyword=>$weight){
	$query="INSERT INTO `tagtable`.`tags` (keyword,weight,link) values ('".$keyword."',".$weight.",'NA')";
	$keyword="\"".$keyword."\"";
	if ($debug) printf($keyword);
	$query="INSERT INTO `tagtable` (`keyword`, `weight`, `link`, `reg_date`) VALUES ($keyword, $weight, 'www.a.b', current_timestamp())";

	if(!mysqli_query($link, $query)){
    if ($debug) printf("Error for ".$keyword);
    if ($debug) printf(mysqli_errno($link));
		if(mysqli_errno($link)==1062){
		    
    if ($debug) printf($table);
	if ($debug) printf($keyword);
	if ($debug) printf($weight);
	
		    
		    
			update_database_entry($link,$table,$keyword,$weight);
		}
	}
}
mysqli_close($link);


?>