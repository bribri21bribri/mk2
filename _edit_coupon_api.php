<?php
require __DIR__ . '/_connectDB.php';

header('Content-Type: application/json');

$result = [
    'success' => false,
    'errorCode' => 0,
    'errorMsg' => '資料輸入不完整',
    'post' => [], // 做 echo 檢查

];


if (isset($_POST['coupon_name'])) {

  $coupon_id = htmlentities($_POST['coupon_id']);
  $coupon_name = htmlentities($_POST['coupon_name']);

  $dis_num = htmlentities($_POST['dis_num']);
  $dis_type = htmlentities($_POST['dis_type']);
  $issue_condi = htmlentities($_POST['issue_condi']);
  $coupon_expire = htmlentities($_POST['coupon_expire']);









  $result['post'] = $_POST;  // 做 echo 檢查



  // TODO: 檢查



  $sql = "UPDATE `coupon` SET
              `coupon_name`=?, 
              `dis_num`=?, 
              `dis_type`=?,
              `issue_condi`=?,
              `coupon_expire`=?
              WHERE `coupon_id`=?";


  try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        $coupon_name,
        $dis_num,
        $dis_type,
        $issue_condi,
        $coupon_expire,
        $coupon_id
    ]);

    if ($stmt->rowCount() == 1) {
      $result['success'] = true;
      $result['errorCode'] = 200;
      $result['errorMsg'] = '';
    } else {
      $result['errorCode'] = 402;
      $result['errorMsg'] = '修改錯誤';
    }
  } catch (PDOException $ex) {
    $result['errorCode'] = 403;
    $result['errorMsg'] = $ex->getMessage();
  }
}

echo json_encode($result, JSON_UNESCAPED_UNICODE);
