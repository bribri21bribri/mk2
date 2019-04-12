<?php include __DIR__ . './_header.php' ?>
<main class="col-10 bg-white">

          <aside class="my-2">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a class="nav-link active"href="./_plan_list.php">查詢促銷方案</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./_insert.php">新增促銷方案</a>
              </li>
            </ul>
          </aside>

          <section class="container-fluid" style="height: 100%;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lo-12">
                <div class="alert alert-success" role="alert" style="display: none;" id="info_bar"></div>
                <form method="POST" name="addPromoForm" id="addPromoForm">

                    <div class="form-group">
                        <label>查詢方案</label>
                        <select class="form-control" name="planType" id="planType">
                            <option value="">---請選擇查詢方案類型---</option>
                            <option value="user_plan">使用者促銷</option>
                            <option value="prod_plan">產品促銷</option>
                            <option value="price_plan">價格促銷</option>
                            <option value="amount_plan">商品數量促銷</option>
                        </select>
                        <small class="form-text text-muted"></small>
                    </div>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-bordered" id="list_table">
                    <thead>
                    <tr>
                        <th scope="col">編輯</th>
                        <th scope="col">#</th>
                        <th scope="col">方案名稱</th>
                        <th scope="col">適用條件</th>
                        <th scope="col">折扣數值</th>
                        <th scope="col">折扣類型</th>
                        <th scope="col">開始時間</th>
                        <th scope="col">結束時間</th>
                        <th scope="col">刪除</th>
                    </tr>
                    </thead>
                    <tbody id="data_body">

                    </tbody>
                </table>
            </div>
        </div>


    </div>
    <script>

        let ori_data = []; // data
        let ori_obj = {}; // data
        const info_bar = document.getElementById('info_bar');
        const planType = document.getElementById('planType');
        planType.addEventListener('change', sendPlanType);
        let condi;


        const data_body = document.getElementById('data_body');



        const dis_type_arr = {
            1:'打折',
            2:'扣除金額'
        };


        function sendPlanType() {
            condi = planType.value;
            let condi_col;
            if (condi == 'user_plan') {
                    condi_col = 'user_condi'
                } else if (condi == 'price_plan') {
                    condi_col = 'price_condi';
                } else if (condi == 'prod_plan') {
                    condi_col =  'prod_condi';
                } else if (condi == 'amount_plan') {
                    condi_col = 'amount_condi';
                }

            let planTypeInput = new FormData();
            planTypeInput.append('planType', planType.value);
            fetch('_list_api.php', {
                method: 'POST',
                body: planTypeInput
            })
                .then(response => response.json())
                .then(json => {
                    console.log(json);
                    ori_data = json;
                    for (let v of ori_data.data) {
                        ori_obj[v['id']] = v;
                    }

                    let str = '';
                    for (let val of ori_data.data) {

                        let tr_str = `<tr data-id=${val.id} id="tr${val.id}">
                        <td>
                            <a href="_edit_plan.php?id=${val.id}&planType=${planType.value}" class="update_btn"><i class="fas fa-edit"></i></a>
                        </td>
                        <td class="plan_id">${val.id}</td>
                        <td class="plan_name">${val.name}</td>
                        <td class="plan_condi">${val[condi_col]}</td>
                        <td class="plan_dis_num">${val.dis_num}</td>
                        <td class="plan_dis_type">${dis_type_arr[val.dis_type]}</td>
                        <td class="plan_start">${val.start}</td>
                        <td class="plan_end">${val.end}</td>
                        <td><a href="javascript: delete_plan(${val.id})">
                              <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>`;

                        console.log(val);
                        str += tr_str;
                    }
                    data_body.innerHTML = str;

                })
        }


        function delete_plan(id) {

            if (confirm(`確認是否刪除`)) {
                let planTypeInput = new FormData();
                planTypeInput.append('planType', planType.value);
                planTypeInput.append('id', id);
                fetch('_delete_api.php', {
                    method: 'POST',
                    body: planTypeInput
                })
                    .then(response => response.json())
                    .then(result => {
                        console.log(result);

                        info_bar.style.display = 'block';

                        if (result.success) {
                            info_bar.className = 'alert alert-success';
                            info_bar.innerHTML = '刪除成功';
                        } else {
                            info_bar.className = 'alert alert-danger';
                            info_bar.innerHTML = obj.errorMsg;
                        }
                        setTimeout(function () {
                            info_bar.style.display = 'none';
                        }, 2000);
                        sendPlanType();
                    })
            }

        }

        function get_id(e) {
            const tr = $(e.target).closest('tr');
            let id = tr.attr('data-id');
            return id;
        }

        $('#data_body').on('click', '.update_btn', get_id)       //
        //
        // function send_update_form(e) {
        //     let condi = deside_planType();
        //     const tr = e.target.parentNode.parentNode;
        //     let id = tr.getAttribute('data-id');
        //
        //     let update_name = document.getElementById('update_name').value;
        //     let update_condi;
        //     if (condi === 'user_condi') {
        //         update_condi = document.getElementById('update_user_condi').value;
        //     } else if (condi === 'price_condi') {
        //         update_condi = document.getElementById('update_price_condi').value
        //     } else if (condi === 'prod_condi') {
        //         update_condi = document.getElementById('update_prod_condi').value
        //     } else if (condi === 'amount_condi') {
        //         update_condi = document.getElementById('update_amount_condi').value
        //     }
        //     let update_dis_num = document.getElementById('update_dis_num').value;
        //     let update_dis_type = document.getElementById('update_dis_type').value;
        //     let update_start = document.getElementById('update_start').value;
        //     let update_end = document.getElementById('update_end').value;
        //
        //
        //     const form = new FormData();
        //     form.append('planType', planType.value);
        //     form.append('id', id);
        //     form.append('name', update_name);
        //     form.append('condi', update_condi);
        //     form.append('dis_num', update_dis_num);
        //     form.append('dis_type', update_dis_type);
        //     form.append('start', update_start);
        //     form.append('end', update_end);
        //
        //
        //     let update_submit_btn = e.target;
        //     update_submit_btn.style.display = 'none';
        //
        //
        //     fetch('_edit_api.php', {
        //         method: 'POST',
        //         body: form
        //     })
        //         .then(response => response.json())
        //         .then(obj => {
        //
        //             console.log(obj);
        //
        //             info_bar.style.display = 'block';
        //
        //             if (obj.success) {
        //
        //                 info_bar.className = 'alert alert-success';
        //                 info_bar.innerHTML = '資料修改成功';
        //             } else {
        //
        //                 info_bar.className = 'alert alert-danger';
        //                 info_bar.innerHTML = obj.errorMsg;
        //             }
        //
        //             update_submit_btn.style.display = 'block';
        //         });
        //
        //     return false;
        // }

    </script>
<?php include __DIR__ . './_footer.php' ?>