<?php
include('db.php');
include("function.php");
if (isset($_POST["user_id"])) {
	$output = array();
	$statement = $connection->prepare(
		"SELECT * FROM customer 
		WHERE customer_id = '".$_POST["user_id"]."' 
		LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach ($result as $row) {
		$output["mobile"] = $row["customer_contact"];
		$output["uname"] = $row["uname"];
		$output["pass"] = $row["customer_pass"];
	
	}
	echo json_encode($output);
}

// SELECT p.products_id, p.product_title, p.product_price,
// p.product_img1, p.product_keywords, p.cost, c.cat_title,
// c.cat_id, pc.p_cat_id, pc.p_cat_title FROM products1 p 
// JOIN category c ON c.cat_id = p.cat_id JOIN availability 
// pc ON pc.p_cat_id = p.p_cat_id 
// WHERE p.products_id =