<div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-10">
                          <h3>Increment</h3>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-12"><hr></div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                        <form method="POST" id="myform" action="<?php echo site_url("incr"); ?>">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Month:</label>
                                        <select id="month" name="month" class="form-control pointer">
                                            <option value="">Select Month</option>
                                            <?php 
                                            foreach($month_list as $row) { 
                                                $selected = ($row->id == $month) ? 'selected' : '';
                                                echo '<option value="'.$row->id.'" '.$selected.'>'.$row->month_name.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label>Year:</label>
                                        <select id="year" name="year" class="form-control pointer">
                                            <option value="">Select Year</option>
                                            <option value="2025" <?= ($year == '2025') ? 'selected' : ''; ?>>2025</option>
                                            <option value="2026" <?= ($year == '2026') ? 'selected' : ''; ?>>2026</option>
                                        </select>
                                    </div>
                                    <div class="col-2 mt-4">
                                        <button id="search" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="hdn_month" id="hdn_month" value="<?php echo $month; ?>">
                            <input type="hidden" name="hdn_year" id="hdn_year" value="<?php echo $year; ?>">
                        </form>
                    </div>
                  </div>
                  <br>
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
                                          <th>Category</th>
                                          <th>Designation</th>                                          
                                          <th>Joining Date</th>
                                          <th>Old Basic Pay</th>
                                          <th>Increment</th>
                                          <th>New Basic Pay</th>
                                          <th class="not-export">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        if ($list) {
                                            foreach ($list as $row) {
                                                $disabled = $row->id > 0 ? '' : 'disabled';
                                                $style = $row->isapplied > 0 ? 'style="color: green; pointer-events: none; cursor: default;"' : '';
                                        ?>
                                                <tr>
                                                    <td><?= $row->emp_code; ?></td>
                                                    <td><?= $row->emp_name; ?></td>
                                                    <td><?= $row->category; ?></td>
                                                    <td><?= $row->designation; ?></td>
                                                    <td><?= date("d/m/Y", strtotime($row->join_dt)); ?></td>
                                                    <td><span class="old_cls_<?= $row->emp_code; ?>"><?= $row->old_basic; ?></span></td>
                                                    <td><span class="rupees_cls_<?= $row->emp_code; ?>"><?= $row->new_basic-$row->old_basic; ?></span><span><input id="amount_<?= $row->emp_code; ?>" type="text" class="form-control amount_cls_<?= $row->emp_code; ?>" value="<?= ($row->new_basic-$row->old_basic) + 0; ?>" style="width: 100%; text-align: right; display: none;" onblur="update_increment('<?= $row->id; ?>', '<?= $row->emp_code; ?>')"></span></td>
                                                    <td><span class="new_cls_<?= $row->emp_code; ?>"><?= $row->new_basic; ?></span></td>
                                                    <td>
                                                        <a href="#" onclick="edit('<?= $row->emp_code ?>')" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                                        </a>
                                                        <a href="#" onclick="apply('<?= $row->id ?>')" data-toggle="tooltip" data-placement="bottom" title="Apply to Employee" class="<?= $disabled; ?>" <?= $style; ?>>
                                                            <i class="fa fa-check fa-2x"></i>
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
        _datatable('Increment List', 2);
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
        $('.rupees_cls_' + emp_code).hide();
        $('.amount_cls_' + emp_code).show();
        $('.amount_cls_' + emp_code).focus();
      }

      function update_increment(id, emp_code) {
        var amount = +$('#amount_' + emp_code).val();
        var basic = +$('.old_cls_' + emp_code).text();
        $.ajax({
            url: "<?=site_url('Admin/increment_update')?>",
            type: "POST",
            data: {id : id, code : emp_code, basic : basic, increment : amount, month : $('#hdn_month').val(), year : $('#hdn_year').val()},
            async: false,
            success: function(result) {
                if(result) {             
                    $('.rupees_cls_' + emp_code).html((amount).toFixed(2));
                }
            }
        });       
        msg(); 
        $('.new_cls_' + emp_code).html((basic + amount).toFixed(2));
        $('.amount_cls_' + emp_code).hide();
        $('.rupees_cls_' + emp_code).show();
      }

      function apply(id) {
        if(+id > 0) {
            var r = confirm("Are you sure you want to apply this increment to employee?");
            if (r == false) {
                return false;
            }
            $.ajax({
                url: "<?=site_url('Admin/increment_apply')?>",
                type: "POST",
                data: {id : id},
                success: function(result){
                    window.location.reload();
                }
            });   
        }            
      }
  </script>