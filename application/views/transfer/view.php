<style>
    #tbl td:nth-child(6),
    #tbl th:nth-child(6) {
        max-width: 300px !important;
        white-space: nowrap !important;
        word-wrap: break-word !important;
    }
</style>
<div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-10">
                          <h3>Transfer</h3>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12"><hr></div>
                  </div>
                  <div id="msg" class="row alert alert-success pull-right" style="display: none;"></div>
                  <br>
                  <div class="row mt-5">
                      <div class="col-12">
                          <div class="table-responsive">
                              <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                  <thead>
                                      <tr>    
                                          <th>Branch</th>    
                                          <th>Code</th> 
                                          <th>Name</th>
                                          <th>Joining Date</th>     
                                          <th>Transfer To</th>
                                          <th>Joining Date</th>
                                          <th class="not-export">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        if ($list) {
                                            $sl_no = 1;
                                            foreach ($list as $row) {
                                        ?>
                                                <tr>         
                                                    <td><?= $row->branch_name; ?></td> 
                                                    <td><?= $row->emp_code; ?></td>
                                                    <td><?= $row->emp_name; ?></td>
                                                    <td><?= date('d.m.Y', strtotime($row->join_dt)); ?></td>                                                       
                                                    <td style="width: 30%;"><span id="trf_branch_<?= $row->emp_code ?>" class="lbl_<?= $row->emp_code ?>"></span><span class="input_<?= $row->emp_code ?>" style="display: none;"><p>
                                                        <?php 
                                                        echo '<select name="branch_id" id="branch_id" class="form-control" required>';
                                                        echo '<option value="">Select Branch</option>';
                                                        foreach($branch_list as $branch) {    
                                                            echo '<option value="' . $branch->id . '">' . $branch->branch_name . '</option>';
                                                        }
                                                        echo '</select>';
                                                        ?>
                                                    </p></span></td>
                                                    <td><span id="trf_date_<?= $row->emp_code ?>" class="lbl_<?= $row->emp_code ?>"></span><span class="input_<?= $row->emp_code ?>" style="display: none;"><input type="date" id="trf_date" name="trf_date" class="form-control" value="<?= date('d-m-Y') ?>"/></span></td>
                                                    <td>
                                                        <a href="#" onclick="edit('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Edit" class="cls_edit_<?= $row->emp_code ?>">
                                                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                                        </a>                                                        
                                                        <a href="#" onclick="save('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Apply to Employee" style="display: none;" class="cls_save_<?= $row->emp_code ?>">
                                                            <i class="fa fa-save fa-2x" style="color: green"></i>
                                                        </a>
                                                        <a href="#" onclick="cancel('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Cancel" style="display: none;" class="cls_cancel_<?= $row->emp_code ?>">
                                                            <i class="fa fa-times fa-2x" style="color: red"></i>
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
              </div>
          </div>
      </div>
  </div>
  <script>
      $(document).ready(function() {
        _datatable('Transfer List', 2, 3);
        msg();
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
        $('.cls_cancel_' + emp_code).show();
      }

      function cancel(emp_code) {
        $('.lbl_' + emp_code).show();
        $('.input_' + emp_code).hide();
        $('.cls_edit_' + emp_code).show();
        $('.cls_save_' + emp_code).hide();
        $('.cls_cancel_' + emp_code).hide();
      }

      function save(emp_code) {
        if(+emp_code > 0 && $('#branch_id').val() > 0 && $('#trf_date').val() != '') {
            var r = confirm("Are you sure you want to transfer this employee?");
            if (r == false) {
                return false;
            }
            $.ajax({
                url: "<?=site_url('Admin/transfer_update')?>",
                type: "POST",
                data: {code : emp_code, branch_id : $('#branch_id').val(), trf_date : $('#trf_date').val()},
                async: false,
                success: function(result) {
                    if(result) {   
                        $('#trf_branch_' + emp_code).text($('#branch_id option:selected').text());  
                        $('#trf_date_' + emp_code).text($('#trf_date').val());
                    }
                }
            });  
        }    
        msg();     
        $('.lbl_' + emp_code).show();
        $('.input_' + emp_code).hide();
        $('.cls_edit_' + emp_code).show();
        $('.cls_save_' + emp_code).hide();
        $('.cls_cancel_' + emp_code).hide();
      }
  </script>