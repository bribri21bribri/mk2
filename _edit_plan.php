<?php include __DIR__ . './_header.php'?>


<style>
    .form-group small {
        color: red !important;
    }

</style>
<?php
require __DIR__ . '/_connectDB.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$playType = $_GET['planType'];
$sql = "SELECT * FROM $playType WHERE id=$id";

$stmt = $pdo->query($sql);

if ($stmt->rowCount() == 0) {
    header('Location: _list.php');
    exit;
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);

$mem_sql = "SELECT * FROM member_level";
$mem_stmt = $pdo->query($mem_sql);
$mem_rows = $mem_stmt->fetchAll(PDO::FETCH_ASSOC);

$camp_type_sql = "SELECT * FROM campsite_type";
$camp_type_stmt = $pdo->query($camp_type_sql);
$camp_type_rows = $camp_type_stmt->fetchAll(PDO::FETCH_ASSOC);

$dis_type_sql = "SELECT * FROM dis_type";
$dis_type_stmt = $pdo->query($dis_type_sql);
$dis_type_rows = $dis_type_stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="container">

    <div class="row">
        <div class="col-lg-12">

            <div class="alert alert-success" role="alert" style="display: none;" id="info_bar">

            </div>

            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">修改資料</h5>

                    <form method="post" name="update_form" onsubmit="return sendForm()">
                        <input type="hidden" name="planType" value="<?=$playType?>">
                        <input type="hidden" name="id" value="<?=$row['id']?>">
                        <div class="form-group">
                            <label for="name">方案名稱</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder=""
                                   value="<?=$row['name']?>">
                            <small id="" class="form-text text-muted"></small>
                        </div>

                      <?php if ($playType == 'user_plan'): ?>
                          <div class="form-group">
                              <label>適用條件</label>
                              <select class="form-control" name="condi">
                                <?php foreach ($mem_rows as $mem_row): ?>
                                    <option <?=$row['user_condi'] == $mem_row['mem_level'] ? "selected" : "";?>
                                            value="<?=$mem_row['mem_level']?>"><?=$mem_row['level_title']?></option>
                                <?php endforeach;?>
                              </select>
                              <small id="" class="form-text text-muted"></small>
                          </div>
                      <?php elseif ($playType == 'price_plan'): ?>
                          <div class="form-group">
                              <label>訂單價格條件</label>
                              <input type="text" value="<?=$row['price_condi']?>" name="condi">
                              <small id="emailHelp" class="form-text text-muted"></small>
                          </div>
                      <?php elseif ($playType == 'prod_plan'): ?>
                          <div class="form-group">
                              <label>營地類型</label>
                              <select class="form-control" name="condi">
                                <?php foreach ($camp_type_rows as $camp_type_row): ?>
                                    <option <?=$row['prod_condi'] == $camp_type_row['campType_id'] ? "selected" : "";?>
                                            value="<?=$camp_type_row['campType_id']?>"><?=$camp_type_row['campType_name']?></option>
                                <?php endforeach;?>
                              </select>
                              <small id="" class="form-text text-muted"></small>
                          </div>
                      <?php elseif ($playType == 'amount_plan'): ?>
                          <div class="form-group">
                              <label>訂單數量條件</label>
                              <input type="text" value="<?=$row['amount_condi']?>" name="condi">
                              <small id="" class="form-text text-muted"></small>
                          </div>
                      <?php endif;?>


                        <div class="form-group">
                            <label>折扣數值</label>
                            <input type="text" class="form-control" name="dis_num" placeholder="輸入折扣數值" value="<?=$row['dis_num']?>">
                            <small id="" class="form-text text-muted"></small>
                        </div>

                        <div class="form-group">
                            <label for="address">折扣類型</label>
                            <select class="form-control" name="dis_type">
                                <?php foreach ($dis_type_rows as $dis_type_row): ?>
                                <option <?=$row['dis_type'] == $dis_type_row['id'] ? "selected" : "";?>
                                        value="<?=$dis_type_row['id']?>"><?=$dis_type_row['dis_type']?></option>
                                <?php endforeach;?>
                            </select>
                            <small id="" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="address">開始時間</label>
                            <input type="date" id="start" name="start"
                                   value="<?=$row['start']?>"
                                   min="2018-01-01" max="2020-12-31">
                            <small id="addressHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="form-group">
                            <label for="address">結束時間</label>
                            <input type="date" id="end" name="end"
                                   value="<?=$row['end']?>"
                                   min="2018-01-01" max="2020-12-31">
                            <small id="" class="form-text text-muted"></small>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


</div>
<script>
    const info_bar = document.querySelector('#info_bar');
    const submit_btn = document.querySelector('#submit_btn');

    // const fields = [
    //     'name',
    //     'email',
    //     'mobile',
    //     'address'
    // ];
    // const fs = {};
    // for (let v of fields) {
    //     fs[v] = document.form1[v];
    // }
    //
    // function checkForm() {
    //     let fsv = {};
    //     for (let v of fields) {
    //         fsv[v] = fs[v].value;
    //     }
    //     console.log(fsv);
    //
    //     let isPassed = true;
    //
    //
    //     let email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    //     let mobile_pattern = /^09\d{2}\-?\d{3}\-?\d{3}$/;
    //
    //     for (let v of fields) {
    //         fs[v].style.borderColor = '#cccccc';
    //         document.querySelector('#' + v + 'Help').innerHTML = '';
    //     }


        // let name = document.form1.name.value;
        // let  email = document.form1.email.value;
        //  let  mobile = document.form1.mobile.value;

        // if (fsv.name.length < 2) {
        //     fs.name.style.borderColor = 'red';
        //     document.querySelector('#nameHelp').innerHTML = '請填寫正確的姓名!';
        //     isPassed = false;
        // }
        // if (!email_pattern.test(fsv.email)) {
        //     fs.email.style.borderColor = 'red';
        //     document.querySelector('#emailHelp').innerHTML = '請填寫正確的Email!';
        //     isPassed = false;
        // }
        // if (!mobile_pattern.test(fsv.mobile)) {
        //     fs.mobile.style.borderColor = 'red';
        //     document.querySelector('#mobileHelp').innerHTML = '請填寫正確的電話!';
        //     isPassed = false;
        // }
        // if (isPassed) {
        //     let form = new FormData(document.form1);
        //
        //     submit_btn.style.display = "none";
    //
    //         fetch('_insert2_api.php', {
    //             method: 'POST',
    //             body: form
    //         })
    //             .then(response=>response.json())
    //             .then(obj=>{
    //
    //                 console.log(obj);
    //
    //                 info_bar.style.display = 'block';
    //
    //                 if(obj.success){
    //                     info_bar.className = 'alert alert-success';
    //                     info_bar.innerHTML = '資料新增成功';
    //                 } else {
    //                     info_bar.className = 'alert alert-danger';
    //                     info_bar.innerHTML = obj.errorMsg;
    //                 }
    //                 submit_btn.style.display = "block";
    //             });
    //
    //
    //     }
    //     return false;
    // }
    function sendForm() {
        let form = new FormData(document.update_form);

                fetch('_edit_plan_api.php', {
                    method: 'POST',
                    body: form
                })
                    .then(response=>response.json())
                    .then(obj=>{

                        console.log(obj);

                        info_bar.style.display = 'block';

                        if(obj.success){
                            info_bar.className = 'alert alert-success';
                            info_bar.innerHTML = '資料修改成功';
                        } else {
                            info_bar.className = 'alert alert-danger';
                            info_bar.innerHTML = obj.errorMsg;
                        }
                        submit_btn.style.display = "";setTimeout(function () {
                            info_bar.css('display', 'none')
                        },3000);
                    });
                return false;
    }
</script>


<?php include __DIR__ . './_footer.php'?>

