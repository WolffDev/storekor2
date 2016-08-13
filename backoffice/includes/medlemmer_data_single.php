<?php
/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "4100";
$dbname = "storekor";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData= $_REQUEST;


$columns = array(
// datatable column index  => database column name
	0 => 'fornavn',
	1 => 'efternavn',
	2 => 'email',
  3 => 'telefon',
  4 => 'stemme',
  5 => 'bruger_rolle',
  6 => 'bruger_status'
);

// getting total number records without any search
$sql = "SELECT fornavn, efternavn, email, telefon, stemme, bruger_rolle, bruger_status ";
$sql.=" FROM medlemmer";
$query=mysqli_query($conn, $sql) or die("medlemmer_data.php: get medlemmer");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter
	$sql = "SELECT fornavn, efternavn, email, telefon, stemme, bruger_rolle, bruger_status ";
	$sql.=" FROM medlemmer";
	$sql.=" WHERE fornavn LIKE '".$requestData['search']['value']."%' ";    // $requestData['search']['value'] contains search parameter
	$sql.=" OR efternavn LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR brugernavn LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR telefon LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR stemme LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR bruger_rolle LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR bruger_status LIKE '".$requestData['search']['value']."%' ";
  $sql.=" OR dato_oprettet LIKE '".$requestData['search']['value']."%' ";
	$sql.=" OR app_status LIKE '".$requestData['search']['value']."%' ";
	$query=mysqli_query($conn, $sql) or die("medlemmer_data.php: get medlemmer");
	$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result without limit in the query

	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   "; // $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc , $requestData['start'] contains start row number ,$requestData['length'] contains limit length.
	$query=mysqli_query($conn, $sql) or die("medlemmer_data.php: get medlemmer"); // again run query with limit

} else {

	$sql = "SELECT fornavn, efternavn, email, telefon, stemme, bruger_rolle, bruger_status ";
	$sql.=" FROM medlemmer";
	$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	$query=mysqli_query($conn, $sql) or die("medlemmer_data.php: get medlemmer");

}



$data = array();
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
	$nestedData=array();

	$nestedData[] = $row["fornavn"];
	$nestedData[] = $row["efternavn"];
	$nestedData[] = $row["email"];
  $nestedData[] = $row["telefon"];
	$nestedData[] = $row["stemme"];
	$nestedData[] = $row["bruger_rolle"];
  $nestedData[] = $row["bruger_status"];

	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

echo json_encode($json_data);  // send data as json format

?>
