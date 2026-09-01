  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <h3>Employee List</h3>
              <?php if ($this->session->flashdata('msg')) { ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $this->session->flashdata('msg'); ?>
                </div>
              <?php } ?>
            </div>
            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="active_status" id="active_status" value="A" checked>
                  Active
                </label>
              </div>
            </div>
            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="active_status" id="active_status" value="R">
                  Retired
                </label>
              </div>
            </div>
            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="active_status" id="active_status" value="S">
                  Suspended
                </label>
              </div>
            </div>
            <div class="col-2">
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input" name="active_status" id="active_status" value="RG">
                  Resigned
                </label>
              </div>
            </div>

            <div class="col-1">
              <small><a href="<?php echo site_url("emadst"); ?>" class="btn btn-primary customFloat_Uts">Add</a></small>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive" id='ajaxl'>
                <table id="order-listing" class="table stripe row-border order-column" style="width:100%">
                  <thead>
                    <tr>
                      <th>Emp code</th>
                      <th>Name</th>
                      <th>Category</th>
                      <th>Designation</th>
                      <th>Branch </th>
                      <th>UAN No</th>
                      <th>DoB</th>
                      <th>DoA</th>
                      <th>DoR</th>
                      <th>Date of Exit from EPS</th>
                      <th>Date of Exit from EPF</th>
                      <th>PAN No</th>
                      <th>Aadhaar No</th>
                      <th>Mobile No</th>
                      <th>Qualification</th>
                      <th>Address</th>
                      <th>Mail ID</th>
                      <th>Account No</th>
                      <th>IFSC Code</th>
                      <th>Bank Name</th>                      
                      <th>Basic</th>
                      <th class="not-export">Edit</th>
                      <!-- <th>Delete</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($employee_dtls) {
                      $i = 0 ;
                      foreach ($employee_dtls as $e_dtls) {
                        $exit_eps = date("Y-m-d", strtotime($e_dtls->dob . " +58 years"));
                        $exit_epf = date("Y-m-d", strtotime($e_dtls->dob . " +60 years"));
                    ?>
                        <tr>
                          <td><?php if (strlen($e_dtls->prefix_emp_cd) > 0) echo $e_dtls->prefix_emp_cd; ?><?= $e_dtls->emp_code; ?></td>
                          <td><?= $e_dtls->emp_name; ?></td>
                          <td><?= $e_dtls->category; ?></td>
                          <td><?= $e_dtls->designation; ?></td>
                          <td><?= $e_dtls->branch_name; ?></td>
                          <td><?= $e_dtls->UAN; ?></td>
                          <td data-sort="<?= strtotime($e_dtls->dob) ?>"><?= date('d.m.Y', strtotime($e_dtls->dob)); ?></td>
                          <td data-sort="<?= strtotime($e_dtls->join_dt) ?>"><?= date('d.m.Y', strtotime($e_dtls->join_dt)); ?></td>
                          <td data-sort="<?= strtotime($e_dtls->ret_dt) ?>"><?= date('d.m.Y', strtotime($e_dtls->ret_dt)); ?></td>
                          <td data-sort="<?= strtotime($exit_eps) ?>"><?= date('d.m.Y', strtotime($exit_eps)); ?></td>
                          <td data-sort="<?= strtotime($exit_epf) ?>"><?= date('d.m.Y', strtotime($exit_epf)); ?></td>
                          <td><?= $e_dtls->pan_no; ?></td>
                          <td><?= $e_dtls->aadhar_no; ?></td>
                          <td><?= $e_dtls->phn_no; ?></td>   
                          <td><?= $e_dtls->qualification; ?></td>
                          <td><?= $e_dtls->emp_addr; ?></td>
                          <td><?= $e_dtls->email; ?></td>      
                          <td><?= $e_dtls->bank_ac_no; ?></td>
                          <td><?= $e_dtls->ifsc; ?></td>
                          <td><?= $e_dtls->bank_name; ?></td>                 
                          <td><?= $e_dtls->basic_pay; ?></td>
                          <td>
                            <a href="estem?emp_code=<?= $e_dtls->emp_code; ?>" data-toggle="tooltip" data-placement="bottom" title="Edit">
                              <i class="fa fa-edit fa-2x" style="color: #007bff"></i>
                            </a>
                          </td>
                          <!-- <td>
                            <a type="button" class="delete" id="" data-toggle="tooltip" data-placement="bottom" title="Delete">
                              <i class="fa fa-trash fa-2x"></i>
                            </a>
                          </td> -->
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
      _datatable('Employee List',2, 2, 'order-listing');
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

    $('input[type=radio][name=active_status]').on('change', function() {
      const selectedValue = $(this).val();
      $('#ajaxl').html('<p>Loading...</p>');

      $.ajax({
        url: "<?= base_url() ?>index.php/admin/ajaxemplist",
        type: "POST",
        data: { active_status: selectedValue },
        success: function(result) {
          $('#ajaxl').html(result);
          // $('#order-listing').DataTable({
          //   destroy: true // Required to reinitialize the DataTable
          // });
        },
        error: function(xhr, status, error) {
          $('#ajaxl').html('<p style="color:red;">Failed to load data. Please try again.</p>');
          console.error("AJAX Error:", status, error);
        }
      });
    });

  </script>