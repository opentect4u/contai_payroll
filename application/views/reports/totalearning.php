<script>
  function printDiv() {

    var divToPrint = document.getElementById('divToPrint');

    var WindowObject = window.open('', 'Print-Window');
    WindowObject.document.open();
    WindowObject.document.writeln('<!DOCTYPE html>');
    WindowObject.document.writeln('<html><head><title></title><style type="text/css">');


    WindowObject.document.writeln('@media print { .center { text-align: center;}' +
      '                                         .inline { display: inline; }' +
      '                                         .underline { text-decoration: underline; }' +
      '                                         .left { margin-left: 315px;} ' +
      '                                         .right { margin-right: 375px; display: inline; }' +
      '                                          table { border-collapse: collapse; }' +
      '                                          th, td { border: 1px solid black; border-collapse: collapse; padding: 10px;}' +
      '                                           th, td { }' +
      '                                         .border { border: 1px solid black; } ' +
      '                                         .bottom { bottom: 5px; width: 100%; position: fixed ' +
      '                                       ' +
      '                                   } } </style>');
    WindowObject.document.writeln('</head><body onload="window.print()">');
    WindowObject.document.writeln(divToPrint.innerHTML);
    WindowObject.document.writeln('</body></html>');
    WindowObject.document.close();
    setTimeout(function() {
      WindowObject.close();
    }, 10);

  }
</script>

<style>
  th {
    text-align: center;
    vertical-align: middle !important;
  }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
?>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body" id='divToPrint'>
<center>
          <div class="row">
            <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/<?php 
if (isset($this->session->userdata['loggedin']['logo_path'])) {
    echo $this->session->userdata['loggedin']['logo_path']; 
}
?>" alt="logo" height="100" width="100" /></a></div>
			  <div class="col-10 payslip_logo_Desc_Uts">
        <?php include_once('common_report_header.php'); ?>
				  <h4>Total earning of Regular employees From <?php echo date('d/m/Y', strtotime($this->input->post('from_date'))) . ' To ' . date('d/m/Y', strtotime($this->input->post('to_date'))); ?>
				  </h4>
			  </div>
          </div>
</center>
          <div class="row">
            <div class="col-12">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Sl No.</th>
                      <th>Emplyees Code</th>
                      <th>Name of Emplyees</th>
                      <th>Earning</th>
                      <th>Deduction</th>
                      <th>Net </th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($total_ear) {
                      $i  =   1;
                      $tot_sp = 0;
                      $tot_da = 0;
                      $tot_hra = 0;
                      $tot_ma = 0;
                
                      $tot_ded = 0;
                      $totearn = 0;
                      $tot_final_gross = 0;
                      foreach ($total_ear as $td_list) {
                        $totearn += $td_list->tot_earn;
                        $tot_ded += $td_list->tot_dedu;

                    ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= $td_list->emp_code; ?></td>
                          <td><?= $td_list->emp_name; ?></td>
                          <td><?= $td_list->tot_earn; ?></td>
                          <td><?= $td_list->tot_dedu; ?></td>
                          <td><?= $td_list->tot_earn - $td_list->tot_dedu; ?></td>
                        </tr>
                      <?php
                      }
                      ?>
                      <tr>
                        <td colspan="3">Total Amount</td>
                        <td><?= $totearn; ?></td>
                        <td><?= $tot_ded; ?></td>
                        <td><?= $totearn - $tot_ded; ?></td>
                      </tr>
                    <?php
                    } else {
                      echo "<tr><td colspan='9' style='text-align:center;'>No Data Found</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
                <br>
                <div>
		</div>
                <div class="bottom">
                  <p style="display: inline;">Prepared By</p>
                  <p style="display: inline; margin-left: 8%;">Accountent</p>
                  <p style="display: inline; margin-left: 8%;">Manager</p>
                  <p style="display: inline; margin-left: 8%;">Secretary</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <center>
        <button type='button' class="btn btn-primary mt-3" onclick='printDiv();'>Print</button>
      </center>
    </div>



  <?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

  ?>

    <div class="main-panel">
      <div class="content-wrapper">
        <div class="card">
          <div class="card-body">
            <h3>Earning Report</h3>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="form" action="<?php echo site_url("reports/totalearning"); ?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-6">
                            <label for="exampleInputName1">From Date:</label>
                            <input type="date" name="from_date" class="form-control required" id="from_date" value="<?php echo $sys_date; ?>" />
                          </div>
                          <div class="col-6">
                            <label for="exampleInputName1">To Date:</label>
                            <input type="date" name="to_date" class="form-control required" id="to_date" value="<?php echo $sys_date; ?>" />


                          </div>
                        </div>
                      </div>

                      <input type="submit" class="btn btn-info" value="Proceed" />
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php

  } else {

    echo "<h1 style='text-align: center;'>No Data Found</h1>";
  }

    ?>