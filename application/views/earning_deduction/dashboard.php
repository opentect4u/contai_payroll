<div class="main-panel">
  <div class="content-wrapper">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-10">
            <h3>Earning Deduction</h3>
          </div>
          <div class="col-2">
            <small><a href="<?php echo base_url(); ?>index.php/salary/eardeduadd" class="btn btn-primary customFloat_Uts">Add</a></small>
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                <thead>
                  <tr>
                    <th>Sl No</th>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Designation</th>
                    <th>Effective Date</th>
                    <th class="not-export">Edit</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if ($payhead) {
                    $i = 0; 
                    foreach ($payhead as $d_dtls) {
                  ?>
                      <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $d_dtls->emp_name; ?></td>
                        <td><?php echo $d_dtls->emp_no; ?></td>
                        <td><?php echo $d_dtls->designation; ?></td>
                        <td><?php echo date('d/m/Y',strtotime($d_dtls->effective_dt)); ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>index.php/salary/eardeduedit?id=<?php echo $d_dtls->emp_no.'/'.$d_dtls->effective_dt; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">
                            <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
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
    _datatable('Employee Salary List', 2);
    $('.confirm-div').hide();
    <?php if ($this->session->flashdata('msg')) { ?>

      $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();

    <?php } ?>

  });
</script>