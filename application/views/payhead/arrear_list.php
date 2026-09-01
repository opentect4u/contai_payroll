  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-10">
              <h3>Arrear List</h3>
            </div>
            <div class="col-2">
              <small><a href="<?php echo base_url(); ?>index.php/salary/calculate_arrears" class="btn btn-primary ">Calculate Arrear</a></small>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table id="order-listing" class="table">
                  <thead>
                    <tr>
                      <th>Sl No</th>
                     
                      <th>Payment Date</th>
                      <th>Emp name</th>
                      <th>Amount</th>
                      <th>Delete</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php

                    if ($arrear_dtl) {
                      $i = 0;
                      foreach ($arrear_dtl as $d_dtls) {
                    ?>
                        <tr>

                          <td><?php echo ++$i; ?></td>
                          <td><?php echo $d_dtls->trans_dt; ?></td>
                           <td><?php echo $d_dtls->emp_name; ?></td>
                          <td><?php echo $d_dtls->amount; ?></td>
                          <td>
                            <a href="<?php echo base_url(); ?>index.php/salary/arrear_delete?id=<?php echo $d_dtls->id; ?>" data-toggle="tooltip" data-placement="bottom" title="Delete">
                              <i class="fa fa-trash fa-2x" style="color: #007bff;"></i>
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

      $('.delete').click(function() {
        var id = $(this).attr('id');
        var result = confirm("Do you really want to delete this record?");
        if (result) {
          window.location = "<?php echo site_url('dstf?empcd="+id+"'); ?>";
        }
      });
    });

    $(document).ready(function() {

      $('.confirm-div').hide();
      <?php if ($this->session->flashdata('msg')) { ?>

        $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();

      <?php } ?>

    });
  </script>