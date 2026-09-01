<div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-12">
                          <h3>Other Deduction</h3>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12">
                        <hr>
                    </div>
                  </div>
                  <div id="msg" class="row alert alert-success pull-right" style="display: none;"></div>
                  <br>
                  <div class="row mt-5">
                      <div class="col-12">
                          <div class="table-responsive">
                              <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                  <thead>
                                      <tr>
                                          <th>Code</th>
                                          <th>Name</th>
                                          <th>Designation</th> 
                                          <?php foreach ($header as $row) { ?>
                                            <th><?= $row->pay_head; ?></th>
                                          <?php } ?>
                                          <th class="not-export">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        if ($list) {
                                            foreach ($list as $row) {
                                                $disabled = $row->id > 0 ? '' : 'disabled';
                                        ?>
                                                <tr>
                                                    <td><?= $row->emp_code; ?></td>
                                                    <td><?= $row->emp_name; ?></td>
                                                    <td><?= $row->designation; ?></td>
                                                    <?php 
                                                        $pay_head_id = explode(',', $row->pay_head_id);
                                                        $amount = explode(',', $row->amount);
                                                        $payhead_array = array();
                                                        for ($i = 0; $i < count($pay_head_id); $i++) {
                                                            $payhead_array[$pay_head_id[$i]] = $amount[$i];
                                                        }
                                                        foreach ($header as $head) {
                                                            $amt = isset($payhead_array[$head->sl_no]) ? $payhead_array[$head->sl_no] : 0;
                                                            echo "<td style='text-align: right;'><span id='lbl_" . $row->emp_code . "_" . $head->sl_no . "' class='lbl_" . $row->emp_code . "'>" . number_format($amt, 2) . "</span><span><input type='text' id='amt_" . $row->emp_code . "_" . $head->sl_no . "' class='form-control input_" . $row->emp_code . "' style='width: 100%; text-align: right; display: none;' value='" . +$amt . "'></span></td>";
                                                        }
                                                    ?>
                                                    <td>
                                                        <a href="#" onclick="edit('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Edit" class="cls_edit_<?= $row->emp_code ?>">
                                                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                                        </a>
                                                        <a href="#" onclick="save('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Apply to Employee" style="display: none;" class="cls_save_<?= $row->emp_code ?>">
                                                            <i class="fa fa-save fa-2x" style="color: green"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                      <?php
                                            }
                                        }
                                        ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div> 
                  <br>
                  <hr>
                  <form class="form-group" id="frm_upload" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="multiselect_div">
                                    <input type="file" name="userfile" data-default-file="" class="dropify" data-max-file-size="500K" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" id="submit" name="submit" class="btn btn-primary"><i class="fa fa-upload"></i></button>
                            </div>
                        </div>
                    </div> 
                  </form>                
              </div>
          </div>
      </div>
  </div>
  <script>
      $(document).ready(function() {
        _datatable('Other Deduction List', 2);
        msg();
        $('#submit').on('click', function (e) {
            e.preventDefault();
            $('#submit').prop('disabled', true);
            $('.main-panel').off('click');
            upload();
        });
      });

      function msg () {
        if ("<?php echo $this->session->flashdata('msg'); ?>") {
            $('#msg').text('<?php echo $this->session->flashdata('msg'); ?>').fadeIn();
            setTimeout(function() {            
                $('#msg').fadeOut();            
            }, 3000);
        }        
      }

      function edit(emp_code) {
        $('.lbl_' + emp_code).hide();
        $('.input_' + emp_code).show();
        $('.cls_edit_' + emp_code).hide();
        $('.cls_save_' + emp_code).show();
      }

      function save(emp_code) {
        if(+emp_code > 0) {
            var r = confirm("Are you sure you want to apply the changes to employee payroll structure?");
            if (r == false) {
                return false;
            }
            var payhead_data = {};
            $('.input_' + emp_code).each(function() {
                var id_parts = $(this).attr('id').split('_');
                var payhead_id = id_parts[2];
                var amount = +$(this).val();
                payhead_data[payhead_id] = amount;
                $('#lbl_' + emp_code + '_' + payhead_id).text((amount).toFixed(2));
            });
            $.ajax({
                url: "<?=site_url('Admin/other_deduction_update')?>",
                type: "POST",
                data: {code : emp_code, payhead_data : payhead_data},
                async: false,
                success: function(result) {
                    if(result) {             
                        $('.input_' + emp_code).each(function() {
                            var id_parts = $(this).attr('id').split('_');
                            var payhead_id = id_parts[2];
                            var amount = +$(this).val();
                            $('.lbl_' + emp_code).find('span').eq(payhead_id - 1).text((amount).toFixed(2));
                        });
                    }
                }
            });  
        }    
        msg();     
        $('.lbl_' + emp_code).show();
        $('.input_' + emp_code).hide();
        $('.cls_edit_' + emp_code).show();
        $('.cls_save_' + emp_code).hide();
      }

      function upload() {
        var formData = new FormData($('#frm_upload')[0]);
        formData.append('userfile', $('input[type=file]')[0].files[0]);
        $.ajax({
            url: '<?=site_url('Admin/upload')?>',
            type: 'post',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            async: false
        }).done(function (data) {
            alert('Other Deduction uploaded: ' + data);
            window.location.href = '<?= site_url('Admin/other_deduction') ?>';
        });
    }
  </script>