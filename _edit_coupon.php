<?php include __DIR__ . './_header.php'?>
<?php
require __DIR__ . '/_connectDB.php';
if (isset($_GET['coupon_id'])) {
    $coupon_id = $_GET['coupon_id'];
}
$sql = "SELECT * FROM coupon WHERE coupon_id = $coupon_id";
try {
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

$dis_type_sql = "SELECT * FROM dis_type";
try {
    $dis_type_stmt = $pdo->query($dis_type_sql);
    $dis_type_rows = $dis_type_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

$issue_sql = "SELECT * FROM issue_condi";

try {
    $issue_stmt = $pdo->query($issue_sql);
    $issue_rows = $issue_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}

?>

<main class="col-lg-10">
  <section class="container">
    <!-- submit result message -->
    <div id="info_bar" style="display: none" class="alert alert-success"></div>
    <div class="card-body">
      <div class="row d-flex justify-content-center">
        <div class="col-sm-8">
          <h5 class="card-title text-center">新增coupon</h5>
        </div>
      </div>
      <form method="POST" name="coupon_form" onsubmit="return sendForm()">
        <h4>coupon ID: <?=$coupon_id?></h4>
        <h4>coupon code: <?=$row['coupon_code']?></h4>
        <input type="hidden" name="coupon_id" value="<?=$coupon_id?>">

        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">coupon ID</label>
          <div class="col-6">
            <div><?=$row['coupon_name']?></div>
            <small class="form-text text-muted"></small>
          </div>
        </div>

        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">coupon名稱</label>
          <div class="col-6">
            <input type="text" class="form-control" name="coupon_name" placeholder="輸入coupon名稱"
              value="<?=$row['coupon_name']?>">
            <small class="form-text text-muted"></small>
          </div>
        </div>

        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">coupon名稱</label>
          <div class="col-6">
            <input type="text" class="form-control" name="coupon_name" placeholder="輸入coupon名稱"
              value="<?=$row['coupon_name']?>">
            <small class="form-text text-muted"></small>
          </div>
        </div>

        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">促銷折扣數值</label>
          <div class="col-6">
            <input type="text" class="form-control" name="dis_num" placeholder="輸入折扣數值" value="<?=$row['dis_num']?>">
          </div>
        </div>

        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">折扣類型</label>
          <div class="col-6">
            <select class="form-control" name="dis_type">
              <?php foreach ($dis_type_rows as $dis_type_row): ?>
              <option <?=$row['dis_type'] == $dis_type_row['id'] ? "selected" : "";?> value="<?=$dis_type_row['id']?>">
                <?=$dis_type_row['dis_type']?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">發放條件</label>
          <div class="col-6">
            <select class="form-control" name="issue_condi">
              <?php foreach ($issue_rows as $issue_row): ?>
              <option <?=$row['issue_condi'] == $issue_row['issue_condi'] ? "selected" : "";?>
                value="<?=$issue_row['issue_condi']?>"><?=$issue_row['issue_condi_name']?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        <div class="form-group justify-content-center row">
          <label class="col-2 text-right">到期時間</label>
          <div class="col-6">
            <input class="form-control" type="date" id="start" name="coupon_expire" value="<?=$row['coupon_expire']?>"
              min="2018-01-01" max="2020-12-31">
          </div>
        </div>

        <div class="form-group justify-content-center row  text-center">
          <div class="col-sm-8">
            <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</main>
</div>
</div>
<script>
function sendForm() {
  let form = new FormData(document.coupon_form);

  fetch('_edit_coupon_api.php', {
      method: 'POST',
      body: form
    })
    .then(response => response.json())
    .then(obj => {

      console.log(obj);

      info_bar.style.display = 'block';

      if (obj.success) {
        info_bar.className = 'alert alert-success';
        info_bar.innerHTML = '資料新增成功';
      } else {
        info_bar.className = 'alert alert-danger';
        info_bar.innerHTML = obj.errorMsg;
      }
      setTimeout(function() {
        info_bar.style.display = 'none';
      }, 2000);
      submit_btn.style.display = "block";
    });
  return false;
}
</script>
<?php include __DIR__ . './_footer.php'?>