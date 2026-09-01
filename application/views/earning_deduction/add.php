<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Payhead Add</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo base_url();?>index.php/salary/eardeduadd" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="exampleInputName1">Employee Name:</label>
                                     <select name="emp_cd" class="form-control" id="emp_cd" >
                                         <option value="">Select Employee</option>
                                         <?php foreach($emps as $emps) { ?>
                                         <option value="<?=$emps->emp_code?>"><?=$emps->emp_name?></option>
                                         <?php } ?>
                                     </select>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Basic:</label>
                                    <input type="number" name="basic" value="" class="form-control" id="basic" required/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Effective Date:</label>
                                    <input type="date" name="effective_dt" value="" class="form-control" required />
                                    </div>
                                </div>
                            </div>
                            <div class="row"  style="text-align: center;">
                              <div class="col-6">
                                    <h3 style="color:green">Earning</h3>
                              </div>
                              <div class="col-6">
                                      <h3 style="color:red">Deduction</h3>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-6 grid-margin">
                                <table id="debit_vau_tab">
                                  <thead>
                                      <tr>
                                          <th width="40%">Pay Head Type</th>
                                          <th width="40%">Amount</th>
                                          <th>
                                            <button class="btn btn-success" type="button" id="debitnewrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button>
                                          </th>
                                      </tr>
                                  </thead>
                                <tbody id="debitadd">
                                  <tr>
                                    <td style="padding: 0px 5px 0px 5px"> 
                                      <select name="epay_cd[]" id="epay_cd_1" class="form-control epay" onchange="set_grDebit(1)">
                                            <option value="">Select Payhead</option>
                                            <?php foreach($epayhead as $key) { ?>
                                            <option value="<?=$key->sl_no?>"><?=$key->pay_head?></option>
                                            <?php } ?>
                                        </select> 
                                    </td>
                                    <td>
                                      <input type="number" title="" class="form-control eamount" id="eamount_1" name="eamount[]" value="0.00" required onchange="calEarning()">
                                    </td>
                                    </tr>
                                  </tbody>
                                </table>
                               </div>
                              <div class="col-6 grid-margin">
                                  <table id="vau_tab">
                                    <thead>
                                        <tr>
                                              <th width="40%">Pay Head Type</th>
                                              <th width="40%">Amount</th>
                                            <th>
                                            <button class="btn btn-success" type="button" id="newrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button>
                                            
                                            </th>
                                        </tr>
                                    </thead>
                                  <tbody id="add">
                                    <tr>
                                      <td style="padding: 0px 5px 0px 5px">
                                        <select name="dpay_cd[]" class="form-control dpay" id="dpay_cd_1" onchange="set_grded(1)">
                                              <option value="">Select Payhead</option>
                                              <?php foreach($dpayhead as $key) { ?>
                                              <option value="<?=$key->sl_no?>"><?=$key->pay_head?></option>
                                              <?php } ?>
                                          </select> 
                                      </td>
                                      <td>
                                        <input type="number" title="" class="form-control" id="damount_1" name="damount[]"  value="0.00" onchange="countDeduction()">
                                      </td>
                                      </tr>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-6 grid-margin">
                                  <div class="row">
                                          <div class="col-md-6" style="padding: 0px 0px 0px 22px">
                                            Total  Earning
                                          </div>
                                          <div class="col-md-6" id="tot_earning"></div>
                                  </div>       
                                </div> 
                                <div class="col-6 grid-margin">
                                   <div class="row">
                                      <div class="col-6 grid-margin">
                                        Total Deduction
                                      </div>
                                      <div class="col-6 " id="tot_deduction"></div>
                                    </div> 
                                </div> 
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>


    <script>
    $(document).ready(function() {
        var tot_amt = 0;
        var pf_percentage = 0;
        $("#debitnewrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#debit_vau_tab #debitadd>tr').length;
                var x = tr_len + 1;
                
                $("#debitadd").append('<tr class="mb-2"><td><select id="epay_cd_' + x + '" name="epay_cd[]" class="form-control epay" onchange="set_grDebit(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($epayhead as $key) {
                            echo "<option value='" . $key->sl_no . "'>" . $key->pay_head . "</option>";
                        }
                        ?>" + '</select></td>' +'<td><input type="number" class="form-control eamount"  id="eamount_' + x + '" name="eamount[]"  value="0.00" required onchange="calEarning()" ></td>' + '<td><button type = "button" class = "btn btn-danger" id = "removeRow_Debit"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
           //  $( ".select2" ).select2();

            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });
    });

    $("#debitadd").on('click', '#removeRow_Debit', function() {
            $(this).parent().parent().remove();
            $('.amount_cls_Debit').change();
        });


        var tot_amt = 0;
        $("#newrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#vau_tab #add>tr').length;
                var x = tr_len + 1;

                $("#add").append('<tr class="mb-2"><td><select id="dpay_cd_' + x + '" name="dpay_cd[]" class="form-control dpay"  onchange="set_grded(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($dpayhead as $value) {
                 
                            echo "<option value='" . $value->sl_no . "'>" . $value->pay_head . "</option>";
               
                        }
                        ?>" + '</select></td>'+'<td><input type="text" class="form-control"  id="damount_' + x + '" name="damount[]" required value="0.00" onchange="countDeduction()"></td>' +  '<td><button type = "button" class = "btn btn-danger" id = "removeRow"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');

            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
            $('.amount_cls').change();
            calculatePF();
        });

        $('#emp_cd').on('change', function() {
            var emp_cd = $(this).val()
            $.ajax({
                type: "GET",
                url: "<?= site_url() ?>/salary/get_basic",
                data: {"emp_cd": emp_cd},
                success: function(result) {
                    if (result) {
                        $('#basic').val(result);
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })

      function set_grDebit(id) {
        var pre_val = '';
        var pre_id = id - 1;
        var basic = $('#basic').val();
        var tot   = 0.00;
        var inputValue = 0.00;
        var total = 0.00;
        if(basic > 0 ) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('salary/paytype_detail'); ?>",
            data: {
              epay_cd: $('#epay_cd_' + id).val(),
              emp_cd: $('#emp_cd').val()
            },
        //    dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                result = result[0];
                var input_flag = result.input_flag;
                if (id > 1) {
                    pre_val = $('#epay_cd_' + pre_id).val();
                    if (pre_val == $('#epay_cd_' + id).val()) {
                        alert('Pay Head Can Not Be Same');
                        $('#epay_cd_' + id).val('');
                    } else {
                       if(input_flag == 'A'){
                        tot = basic*(result.percentage/100);
                        $('#eamount_' + id).val(tot.toFixed()).change();
                        $('.eamount').each(function() {
                          // Parse the value as a float and add to total
                          var inputValue = parseFloat($(this).val());
                          total += isNaN(inputValue) ? 0 : inputValue;

                        });
                      total  +=parseFloat(basic);
                      // $('#tot_earning').html(total.toFixed());
                    
                       }

                       if(result.sl_no == '107'){
                        $('#eamount_' + id).val('300').change()
                       }
                       console.log('amount: ' + result.amount);
                       if(+result.amount > 0){
                        $('#eamount_' + id).val(result.amount).change();
                       }
                       
                    }
                } else {
                  if(input_flag == 'A'){
                    tot = basic*(result.percentage/100);
                    $('#eamount_1').val(tot.toFixed()).change();
                    $('.eamount').each(function() {
                          var inputValue = parseFloat($(this).val());
                          total += isNaN(inputValue) ? 0 : inputValue;

                      });
                      total  +=parseFloat(basic);
                      // $('#tot_earning').html(total.toFixed());
                    
                  }

                  console.log(result);
                  console.log('amount: ' + result.amount);
                  if(+result.amount > 0){
                    $('#eamount_' + id).val(result.amount).change();
                  }
                }
                //sujay
                calculatePF();
            }
        });

        }else{
          alert('Please Check basic Value');
        }
      }
      function set_grded(id) {
        var pre_val = '';
        var pre_id = id - 1;
        var basic = $('#basic').val();
        var tot   = 0.00;
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('salary/paytype_detail'); ?>",
            data: {
              epay_cd: $('#dpay_cd_' + id).val(),
              emp_cd: $('#emp_cd').val()
            },
        //    dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                result = result[0];
                console.log(result, 'DED');
                var input_flag = result.input_flag;
                if (id > 1) {
                    pre_val = $('#dpay_cd_' + pre_id).val();
                    if (pre_val == $('#dpay_cd_' + id).val()) {
                        alert('Pay Head Can Not Be Same');
                        $('#dpay_cd_' + id).val('');
                    } else {
                       if(input_flag == 'A'){
                        tot = basic*(result.percentage/100);
                        $('#damount_' + id).val(tot.toFixed());
                       }

                       if(result.sl_no == '201'){
                        $('input[name="epay_cd[]"]').each(function(){
                          console.log($(this).val(), 'ER VAL');
                          if($(this).val() == '104'){
                            var attr = $(this).attr('id')
                            var ele_id = attr.split('_')[1]
                            var da_val = $(`eamount_${ele_id}`).val()
                            console.log(ele_id, da_val);
                            var pf_val = ((parseFloat(basic) + parseFloat(da_val))*12)/100
                            $('#damount_' + id).val(pf_val.toFixed());
                          }
                        })
                       }

                       if(+result.amount > 0){
                        $('#damount_' + id).val(result.amount).change();
                       }
                    }
                    console.log('HEHEHE');
                } else {
                  if(input_flag == 'A'){
                    tot = basic*(result.percentage/100);
                    $('#damount_1').val(tot.toFixed());
                  }
                  if(result.sl_no == '201'){
                    $('input[name="epay_cd[]"]').each(function(){
                      console.log($(this).val(), 'ER VAL');
                      if($(this).val() == '104'){
                        var attr = $(this).attr('id')
                        var ele_id = attr.split('_')[1]
                        var da_val = $(`eamount_${ele_id}`).val()
                        console.log(ele_id, da_val);
                        var pf_val = ((parseFloat(basic) + parseFloat(da_val))*12)/100
                        $('#damount_' + id).val(pf_val.toFixed());
                      }
                    });
                  }
                  if(+result.amount > 0){
                    $('#damount_' + id).val(result.amount).change();
                  }
                }
                if($('#dpay_cd_' + id).val() == '463'){
                  pf_percentage = result.percentage;
                }
                //sujay
                calculatePF();
            }
        });
      }

function countDeduction(){
  var tot_ded = 0
  $('input[name="damount[]"]').each(function(){
    tot_ded += parseFloat($(this).val()) > 0 ? parseFloat($(this).val()) : 0
    // console.log($(this).val());
  })
  $('#tot_deduction').text(tot_ded);
}

function calEarning(){
  var tot_er = parseFloat($('#basic').val())
  $('input[name="eamount[]"]').each(function(){
    tot_er += parseFloat($(this).val()) > 0 ? parseFloat($(this).val()) : 0
    // console.log($(this).val());
  })
  $('#tot_earning').text(tot_er)
}
//sujay - da 457 pf 463
function calculatePF() {
  var basic = $('#basic').val();
  var da_index = 0;
  var pf_index = 0;
  var deduction = 0;
  $(".epay").each(function () {
      if ($(this).val() === '457') {
        var arr = $(this).attr("id").split("_");
        da_index = arr[2];
        basic = +basic + +$('#eamount_' + da_index).val();
      }
  });
  $(".dpay").each(function () {
    var arr = $(this).attr("id").split("_");
    var index = arr[2];
    if ($(this).val() === '463') {
        pf_index = index;          
    } else {
      deduction = +deduction + +$('#damount_' + index).val();
    }
  });
  console.log('pf_index: ' + pf_index);
  var pf = pf_index > 0 ? Math.round(basic * (+pf_percentage/100)) : 0;
  $('#damount_' + pf_index).val(pf);
  $('#tot_deduction').text(deduction + +pf);
}
</script>