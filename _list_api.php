<?php
require __DIR__. '/_connectDB.php';
header('Content-Type: application/json');

$result = [
    'success' => false,
    'data' => [],
    'errorCode' => 0,
    'errorMsg' => '',
];

//$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
//
//// 算總筆數
//$t_sql = "SELECT COUNT(1) FROM address_book";
//$t_stmt = $pdo->query($t_sql);
//$total_rows = $t_stmt->fetch(PDO::FETCH_NUM)[0];
//$result['totalRows'] = intval($total_rows);
//
//// 總頁數
//$total_pages = ceil($total_rows/$per_page);
//$result['totalPages'] = $total_pages;
//
//if($page < 1) $page = 1;
//if($page > $total_pages) $page = $total_pages;
//$result['page'] = $page;
if(isset($_POST['planType'])) {
  $planType = $_POST['planType'];
  $sql = "SELECT * FROM {$planType}";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $rows= $stmt->fetchAll(PDO::FETCH_ASSOC);











// 所有資料一次拿出來
  $result['data'] = $rows;
  $result['success'] = true;
}
// 將陣列轉換成 json 字串
echo json_encode($result, JSON_UNESCAPED_UNICODE);

