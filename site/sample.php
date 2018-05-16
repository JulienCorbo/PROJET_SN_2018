<?php 
function getFunction($selectedData){
	$connect =mysqli_connect("localhost","root","raspberry","pool3k");
	$query='SELECT ph, temp, cl,
	UNIX_TIMESTAMP(CONCAT_WS(" ",sample_date,sample_time)) AS datetime
	FROM statements 
	ORDER BY sample_date DESC, sample_time DESC';
	$result = mysqli_query($connect,$query);
	$cols=array();
	$rows=array();
	$table=array();
	// $table['cols']=array(
	$cols[]=array(
		'label'=>'Date',
		'type'=>'datetime'
	);
	switch ($selectedData) {
		case 'ph':
		$cols[]=array('label'=>'Ph','type'=>'number');
		break;
		case 'temp':
		$cols[]=array('label'=>'Température (°C)','type'=>'number');
		break;
		case 'cl':
		$cols[]=array('label'=>'Taux de chlore (mg/L)','type'=>'number');
		break;
		case 'table':
		$cols[]=array('label'=>'Température (°C)','type'=>'number');
		$cols[]=array('label'=>'Ph','type'=>'number');
		$cols[]=array('label'=>'Taux de chlore (mg/L)','type'=>'number');
		break;

	};
	$table['cols']=$cols;
	while($dataRow=mysqli_fetch_array($result))
	{
		$sub_array=array();
		$datetime = explode(".", $dataRow["datetime"]);
		$sub_array[]=array("v" => 'Date('.$datetime[0].'000)');
		switch ($selectedData) {
			case 'ph':
			$sub_array[]=array("v" => $dataRow['ph']);
			break;
			case 'temp':
			$sub_array[]=array("v" => $dataRow['temp']);
			break;
			case 'cl':
			$sub_array[]=array("v" => $dataRow['cl']);
			break;
			case 'table':
			$sub_array[]=array("v" => $dataRow['temp']);
			$sub_array[]=array("v" => $dataRow['ph']);
			$sub_array[]=array("v" => $dataRow['cl']);
			break;
		}
		$rows[]=array(
			"c"=>$sub_array
		);
	}
	$table['rows']=$rows;
	$table=json_encode($table,JSON_NUMERIC_CHECK);
	return $table;
};
echo getFunction($_GET['selectedData']);
?>