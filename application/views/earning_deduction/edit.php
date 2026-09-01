    <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Payhead Add</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo base_url();?>index.php/salary/eardeduedit" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                      <input type="hidden" name="emp_cd" value="<?=$earning_dtls[0]->emp_code?>" />
                                       <label for="exampleInputName1">Employee Name:</label><br>
                                      <input type="text"  value="<?=$earning_dtls[0]->emp_name?>" class="form-control" readonly/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Basic:</label>
                                    <input type="number" name="basic" value="<?=$earning_dtls[0]->basic_pay?>" class="form-control" id="basic" readonly/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Effective Date:</label>
                                    <input type="date" name="effective_dt" value="<?=$earning_dtls[0]->effective_dt?>" class="form-control" readonly />
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
                                 
                                    <?php      $tot_earning = $earning_dtls[0]->basic_pay ; $tot_deduction = 0;
                                     
                                    foreach($earning_dtls as $ekey) {
                                          if($ekey->pay_head_type == 'E') {
                                            if($ekey->input_flag == 'A'){
                                              $tot_earning += round(($earning_dtls[0]->basic_pay*$ekey->percentage)/100);
                                            }else{
                                              $tot_earning += $ekey->amount;
                                            }
                                           
                                      ?>
                                    <tr>
                                      <td style="padding: 0px 5px 0px 5px"> 
                                      <input type="text" name="" class="form-control" value="<?=$ekey->pay_head?>" readonly>
                                        <input type="hidden" name="epay_cd[]" id="" class="form-control" value="<?=$ekey->pay_head_id?>">
                                      </td>
                                      <td>
                                      <?php if($ekey->input_flag == 'A') {  ?>
                                        <input type="number" class="form-control eamount" id="" name="eamount[]" value="<?=round(($earning_dtls[0]->basic_pay*$ekey->percentage)/100)?>" required>
                                        <?php }else{  ?>
                                           <input type="number" class="form-control eamount" id="" name="eamount[]" value="<?=$ekey->amount?>" required> 
                                        <?php } ?>
                                      </td>
                                    </tr>
                                    <?php } 
                                            } ?>
                                  </tbody>
                                </table>
                               </div>
                              <div class="col-6 grid-margin">
                                  <table id="vau_tab">
                                    <thead>
                                        <tr>
                                              <th width="40%">Pay Head Type</th>
                                              <th width="25%">Amount</th>
                                              <th>Account No</th>
                                            <th>
                                            <button class="btn btn-success" type="button" id="newrow"><i class="fa fa-arrow-circle-down" aria-hidden="true"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                  <tbody id="add">
                                 
                                      <?php foreach($earning_dtls as $ekey) {
                                          if($ekey->pay_head_type == 'D') {
                                            $tot_deduction += $ekey->amount;
                                            // if($ekey->input_flag == 'A'){
                                            //   $tot_deduction += round(($earning_dtls[0]->basic_pay*$ekey->percentage)/100);
                                            // }else{
                                            //   $tot_deduction += $ekey->amount;
                                            // }

                                            
                                      ?>
                                    <tr>
                                      <td style="padding: 0px 5px 0px 5px"> 
                                      <input type="text" name="" class="form-control" value="<?=$ekey->pay_head?>" readonly>
                                        <input type="hidden" name="dpay_cd[]" id="" class="form-control" value="<?=$ekey->pay_head_id?>">
                                      </td>
                                      <td>
                                        <input type="number" class="form-control damount" id="" name="damount[]" value="<?=$ekey->amount?>" required>
                                      </td>
                                      <td>
                                        <input type="text" class="form-control" name="account_no[]" value="<?=$ekey->account_no?>">
                                      </td>
                                    </tr>
                                    <?php } 
                                            } ?>
                                    </tbody>
                                  </table>
                              </div>
                            </div>
                            <div class="row" style="font-weight:bold">
                                <div class="col-6 grid-margin">
                                  <div class="row">
                                          <div class="col-6" style="padding: 0px 0px 0px 22px">
                                            TOTAL  EARNING : 
                                          </div>
                                          <div class="col-2" id="tot_earning">
                                          <?=$tot_earning?>
                                         
                                         </div>
                                         <div class="col-2" id="">
                                           
                                         </div>
                                  </div>       
                                </div> 
                                <div class="col-6 grid-margin">
                                   <div class="row">
                                      <div class="col-6">
                                        TOTAL DEDUCTION
                                      </div>
                                      <div class="col-6 " id="tot_deduction">
                                           <?=$tot_deduction?>
                                      </div>
                                    </div> 
                                </div> 
                            </div>
                            <div class="row" style="font-weight:bold">
                                <div class="col-6 grid-margin">
                                  <div class="row">
                                          <div class="col-md-6" style="padding: 0px 0px 0px 22px">
                                          </div>
                                          <div class="col-md-6" id="">
                                         </div>
                                  </div>       
                                </div> 
                                <div class="col-6 grid-margin">
                                   <div class="row">
                                      <div class="col-6">
                                        NET SALARY
                                      </div>
                                      <div class="col-6 " id="net">
                                           <?=round($tot_earning-$tot_deduction)?>
                                      </div>
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
        $("#debitnewrow").click(function() {
            if ($('#v_type').val() != '') {
                var tr_len = $('#debit_vau_tab #debitadd>tr').length;
                var x = tr_len + 1;
                $("#debitadd").append('<tr class="mb-2"><td style="padding: 0px 5px 0px 5px"><select id="epay_cd_' + x + '" name="epay_cd[]" class="form-control eamount" onchange="set_grDebit(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($epayhead as $key) {
                           echo "<option value='" . $key->sl_no . "'>" . $key->pay_head . "</option>";
                        }
                        ?>" + '</select></td>' +'<td><input type="number" class="form-control eamount"  id="eamount_' + x + '" name="eamount[]"  value="0.00" required ></td>' + '<td><button type = "button" class = "btn btn-danger" id = "removeRow_Debit"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
			   
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

                $("#add").append('<tr class="mb-2" ><td style="padding: 0px 5px 0px 5px"><select id="dpay_cd_' + x + '" name="dpay_cd[]" class="form-control"  onchange="set_grded(' + x + ')" required><option value="">Select</option>' +
                    "<?php
                        foreach ($dpayhead as $value) {
                          echo "<option value='" . $value->sl_no . "'>" . $value->pay_head . "</option>";
                        }
                        ?>" + '</select></td>'
                        +'<td><input type="text" class="form-control damount"  id="damount_' + x + '" name="damount[]" oninput="validate(this)" required value="0.00"></td>' 
                        +'<td><input type="text" class="form-control"  id="account_no_' + x + '" name="account_no[]" value=""></td>' 
                        +'<td><button type = "button" class = "btn btn-danger" id = "removeRow"> <i class = "fa fa-undo" aria-hidden = "true" > </i></button> </td></tr> ');
			  //$( ".select2" ).select2();
            } else {
                alert('Please Select Voucher Type First');
                return false;
            }
        });

        $("#add").on('click', '#removeRow', function() {
            $(this).parent().parent().remove();
            //$('.preferenceSelect').change();
            $('.amount_cls').change();
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
              epay_cd: $('#epay_cd_' + id).val()
            },
        //    dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
                var input_flag = result.input_flag;
                if (id > 1) {
                    pre_val = $('#epay_cd_' + pre_id).val();
                    if (pre_val == $('#epay_cd_' + id).val()) {
                        alert('Pay Head Can Not Be Same');
                        $('#epay_cd_' + id).val('');
                    } else {
                       if(input_flag == 'A'){
                        tot = basic*(result.percentage/100);
                        $('#eamount_' + id).val(tot.toFixed());
                        $('.eamount').each(function() {
                          // Parse the value as a float and add to total
                          var inputValue = parseFloat($(this).val());
                          total += isNaN(inputValue) ? 0 : inputValue;

                      });
                      total  +=parseFloat(basic);
                      $('#tot_earning').html(total.toFixed());
                    
                       }
                       
                    }
                } else {
                  if(input_flag == 'A'){
                    tot = basic*(result.percentage/100);
                    $('#eamount_1').val(tot.toFixed());
                    $('.eamount').each(function() {
                          var inputValue = parseFloat($(this).val());
                          total += isNaN(inputValue) ? 0 : inputValue;

                      });
                      total  +=parseFloat(basic);
                      $('#tot_earning').html(total.toFixed());
                    
                  }
                }
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
              epay_cd: $('#dpay_cd_' + id).val()
            },
        //    dataType: 'html',
            success: function(result) {
                var result = $.parseJSON(result);
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
                    }
                } else {
                  if(input_flag == 'A'){
                    tot = basic*(result.percentage/100);
                    $('#damount_1').val(tot.toFixed());
                  }
                }
            }
        });
      }

      $('.eamount').change(function() {
        
        var totald = 0;
        var tot = 0;
           var basic = parseFloat($('#basic').val());
           var totale = parseFloat($('#basic').val());
          $('.eamount').each(function() {
                var inputValue = parseFloat($(this).val());
                totale += isNaN(inputValue) ? 0 : inputValue;
          });
          $('.damount').each(function() {
                var inputValues = parseFloat($(this).val());
                totald += isNaN(inputValues) ? 0 : inputValues;
          });
          tot  = parseFloat(totale) - parseFloat(totald);
          $('#tot_earning').html(totale.toFixed())
          $('#tot_deduction').html(totald.toFixed())
          $('#net').html(tot.toFixed())
    })
    $('.damount').change(function() {
        
        var totald = 0;
        var tot = 0;
           var basic = parseFloat($('#basic').val());
           var totale = parseFloat($('#basic').val());
          $('.eamount').each(function() {
                var inputValue = parseFloat($(this).val());
                totale += isNaN(inputValue) ? 0 : inputValue;
          });
          $('.damount').each(function() {
                var inputValues = parseFloat($(this).val());
                totald += isNaN(inputValues) ? 0 : inputValues;
          });
          tot  = parseFloat(totale) - parseFloat(totald);
          $('#tot_earning').html(totale.toFixed())
          $('#tot_deduction').html(totald.toFixed())
          $('#net').html(tot.toFixed())
    })
</script>