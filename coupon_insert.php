<?php include __DIR__ . './_header.php';?>
<main class="col-10 bg-white">
  <aside class="my-2">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="coupon_list.php">coupon查詢</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="coupon_insert.php">新增coupon</a>
      </li>
    </ul>
  </aside>
  <section class="" style="height: 100%;">

    <!-- submit result message -->
    <div id="info_bar" style="display: none" class="alert alert-success"></div>
    <div class="container">
      <div class="card-body">

        <div class="row d-flex justify-content-center">
          <div class="col-sm-8">
            <h5 class="card-title text-center">新增coupon</h5>
          </div>
        </div>
        <form method="POST" name="coupon_form" onsubmit="return sendForm()">

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>coupon名稱</label>
            <div class="col-6">
              <input type="text" class="form-control" name="coupon_name" placeholder="輸入coupon名稱">
              <small class="form-text text-muted"></small>
            </div>
          </div>

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>張數</label>
            <div class="col-6">
              <input type="text" class="form-control" name="amount" placeholder="輸入張數">
            </div>
          </div>

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>促銷折扣數值</label>
            <div class="col-6">
              <input type="text" class="form-control" name="dis_num" placeholder="輸入折扣數值">
            </div>
          </div>

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>折扣類型</label>
            <div class="col-6">
              <select class="form-control" name="dis_type">
                <option value="1">打折</option>
                <option value="2">扣除金額</option>
              </select>
            </div>
          </div>

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>發放條件</label>
            <div class="col-6">
              <select class="form-control" name="issue_condi">
                <option value="1">初次登入</option>
                <option value="2">會員升等</option>
                <option value="3">訂單累積</option>
              </select>
            </div>
          </div>

          <div class="form-group justify-content-center row">
            <label class="col-2 text-right"><span class="asterisk"> *</span>到期時間</label>
            <div class="col-6">
              <input type="date" class="form-control" id="start" name="coupon_expire" value="" min="2018-01-01"
                max="2020-12-31">
            </div>
          </div>

          <div class="form-group justify-content-center row  text-center">
            <div class="col-sm-8">
              <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
            </div>
          </div>

        </form>
      </div>
    </div>
    <script>
    const submit_btn = document.getElementById('submit_btn');

    function sendForm(e) {
      const form = new FormData(coupon_form);
      submit_btn.style.display = 'none';
      fetch('coupon_insert_api.php', {
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
          }, 3000);
          submit_btn.style.display = 'block';
        });
      return false;
    }
    </script>


    <?php include __DIR__ . './_footer.php';?>