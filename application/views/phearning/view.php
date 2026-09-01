<div class="main-panel">
      <div class="content-wrapper">
          <div class="card">
              <div class="card-body">
                  <div class="row">
                      <div class="col-10">
                          <h3>Pay Head Earning (Designation wise)</h3>
                      </div>
                      <div class="col-2">
                          <a href="<?= site_url('phearningedit') ?>" class="btn btn-primary customFloat_Uts">Add</a>
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
                                          <th>Sl No</th>
                                          <th>Pay Head</th>
                                          <th>Designation</th>
                                          <th>Amount</th>
                                          <th class="not-export">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                        if ($list) {
                                            $i = 0;
                                            foreach ($list as $row) {
                                        ?>
                                                <tr>
                                                    <td><?= ++$i; ?></td>
                                                    <td><?= $row->pay_head; ?></td>
                                                    <td><?= $row->designation; ?></td>
                                                    <td><span class="rupees_cls_<?= $row->id; ?>"><?= $row->amount; ?></span><span><input id="amount_<?= $row->id; ?>" type="text" class="form-control amount_cls_<?= $row->id; ?>" value="<?= $row->amount + 0; ?>" style="width: 100%; text-align: right; display: none;" onblur="update_amount('<?= $row->id; ?>')"></span></td>
                                                    <td>
                                                        <a href="#" onclick="edit('<?= $row->id ?>')" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                                                        </a>
                                                        <a href="#" onclick="apply('<?= $row->id ?>')" data-toggle="tooltip" data-placement="bottom" title="Apply to Employee">
                                                            <i class="fa fa-check fa-2x"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                      <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='10' style='text-align: center;'>No data Found</td></tr>";
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
        _datatable('Employee Category List');
        msg();
        $('.delete').click(function() {
            var id = $(this).attr('id');
            var result = confirm("Do you really want to delete this record?");
            if (result) {
                window.location = "<?php echo site_url('dstf?empcd="+id+"'); ?>";
            }
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

      function edit(id) {
        $('.rupees_cls_' + id).hide();
        $('.amount_cls_' + id).show();
        $('.amount_cls_' + id).focus();
      }

      function update_amount(id) {
        var amount = parseFloat($('#amount_' + id).val());
        $.ajax({
            url: "<?=site_url('Admin/phearning_update')?>",
            type: "POST",
            data: {id : id, amount : amount},
            async: false,
            success: function(result){
                if(result) {             
                    $('.rupees_cls_' + id).html(amount.toFixed(2));
                }
            }
        });       
        msg(); 
        $('.amount_cls_' + id).hide();
        $('.rupees_cls_' + id).show();
      }

      function apply(id) {
        if(+id > 0) {
            var r = confirm("Are you sure you want to apply this amount to employee?");
            if (r == false) {
                return false;
            }            
            $.ajax({
                url: "<?=site_url('Admin/phearning_apply')?>",
                type: "POST",
                data: {id : id},
                success: function(result){
                    window.location.reload();
                }
            });
        }
      }
  </script>