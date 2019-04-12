<?php 
require __DIR__. '/_connectDB.php';
header('Content-Type: application/json');

$result = [
  'success' => false,
  'errorCode' => 0,
  'errorMsg' => '資料輸入不完整',
  'post' => [], // 做 echo 檢查
  'data'=>[],
  'according_to'=>0,
  'total_page'=>0,
  'total_row'=>0
];

$sql = "SELECT * FROM coupon ";
if(isset($_POST['sql'])){
  $sql.=$_POST['sql'];
}

//echo $sql;
//exit();


$stmt = $pdo->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();

if($row_count>0){
  $result['total_row'] = $row_count;
}
$data = [];

$result['data'] = $rows;
//$result['data'] = $data;
echo json_encode($result,JSON_UNESCAPED_UNICODE);