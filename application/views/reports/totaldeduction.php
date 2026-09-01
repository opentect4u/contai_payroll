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
  $tot_pf = 0;
  $tot_adv_agst_hb_prin = 0;
  $tot_adv_agst_hb_int = 0;
  $tot_adv_agst_hb_const_prin = 0;
  $tot_adv_agst_hb_const_int = 0;
  $tot_adv_agst_hb_staff_prin = 0;
  $tot_adv_agst_hb_staff_int = 0;
  $tot_gross_hb_int = 0;
  $tot_adv_agst_of_staff_prin = 0;
  $tot_adv_agst_of_staff_int = 0;
  $tot_staff_adv_ext_prin = 0;
  $tot_staff_adv_ext_int = 0;
  $tot_motor_cycle_prin = 0;
  $tot_motor_cycle_int = 0;
  $tot_p_tax = 0;
  $tot_gici = 0;
  $tot_puja_adv = 0;
  $tot_income_tax_tds = 0;
  $tot_union_subs = 0;
  $tot_tot_diduction = 0;
?>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="card">
        <div class="card-body" id='divToPrint'>
          <center>
          <div class="row">
          <div class="col-2 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= base_url() ?>assets/images/bm_ardb.jpg" alt="logo" height="100" width="100" /></a></div>
            <div class="col-10 payslip_logo_Desc_Uts">
               <?php include_once('common_report_header.php'); ?>
              <h4>Total earning of Regular employees From <?php echo date('d/m/Y', strtotime($this->input->post('from_date'))) . ' To ' . date('d/m/Y', strtotime($this->input->post('to_date'))); ?>
                <!-- <h4>Pay Slip for <?php //echo date($this->input->post('sal_month'), "d/m/Y") . '-' . $this->input->post('year'); 
                                      ?></h4> -->
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
                      <th>Name of Emplyees</th>
                      <th>Income Tax</th>
                      <th>Contributory P.F.</th>
                      <th>GPF of<br>GOVT Staff</th>
                      <th>GI of<br>GOVT Staff</th>
                      <th>Loan from P.F.</th>
                      <th>Festival Adv.</th>
                      <th>Group Insurance</th>
                      <th>Tax on Proffession</th>
                      <th>ECCS</th>
                      <th>HB Loan Prin.</th>
                      <th>HB Loan Int.</th>
                      <th>Salary Adv.</th>
                      <th>Total <br>Deduction</th>
                    </tr>

                  </thead>

                  <tbody>

                    <?php

                    if ($total_deduct) {

                      $i  =   1;
                      $tot_it = 0;
                      $tot_cpf = 0;
                      $tot_gpf = 0;
                      $tot_gigs = 0;
                      $tot_lpf = 0;
                      $tot_fa = 0;
                      $tot_gi = 0;
                      $tot_top = 0;
                      $tot_eccs = 0;
                      $tot_hblp = 0;
                      $tot_hbli = 0;
                      $tot_s_adv = 0;
                      $tot_tot_diduction = 0;

                      // $tot_ins = $tot_css = $tot_hbl = $tot_tel = $tot_med_adv = $tot_fa = $tot_tf = $tot_med_ins = $tot_comp_loan = $tot_ptax = $tot_itax = $tot_gpf = $tot_epf = $tot_other_deduction = 0;

                      foreach ($total_deduct as $td_list) {

                        $tot_it += $td_list->it;
                        $tot_cpf += $td_list->cpf;
                        $tot_gpf += $td_list->gpf;
                        $tot_gigs += $td_list->gigs;
                        $tot_lpf += $td_list->lpf;
                        $tot_fa += $td_list->fa;
                        $tot_gi += $td_list->gi;
                        $tot_top += $td_list->top;
                        $tot_eccs += $td_list->eccs;
                        $tot_hblp += $td_list->hblp;
                        $tot_hbli += $td_list->hbli;
                        $tot_s_adv += $td_list->s_adv;
                        $tot_tot_diduction += $td_list->tot_diduction;
                    ?>

                        <tr>

                          <td><?= $i++; ?></td>

                          <td><?= $td_list->emp_name; ?></td>
                          <td><?= $td_list->it; ?></td>
                          <td><?= $td_list->cpf; ?></td>
                          <td><?= $td_list->gpf; ?></td>
                          <td><?= $td_list->gigs; ?></td>
                          <td><?= $td_list->lpf; ?></td>
                          <td><?= $td_list->fa; ?></td>
                          <td><?= $td_list->gi; ?></td>
                          <td><?= $td_list->top; ?></td>
                          <td><?= $td_list->eccs; ?></td>
                          <td><?= $td_list->hblp; ?></td>
                          <td><?= $td_list->hbli; ?></td>
                          <td><?= $td_list->s_adv; ?></td>
                          <td><?= $td_list->tot_diduction; ?></td>
                        </tr>

                      <?php

                      }

                      ?>


                      <tr>

                        <td colspan="2">Total Amount</td>
                        <td><?= $tot_it ?></td>
                        <td><?= $tot_cpf ?></td>
                        <td><?= $tot_gpf ?></td>
                        <td><?= $tot_gigs ?></td>
                        <td><?= $tot_lpf ?></td>
                        <td><?= $tot_fa ?></td>
                        <td><?= $tot_gi ?></td>
                        <td><?= $tot_top ?></td>
                        <td><?= $tot_eccs ?></td>
                        <td><?= $tot_hblp ?></td>
                        <td><?= $tot_hbli ?></td>
                        <td><?= $tot_s_adv ?></td>
                        <td><?= $tot_tot_diduction ?></td>
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

                  <p style="display: inline; margin-left: 8%;">Establishment, Sr. Asstt.</p>

                  <p style="display: inline; margin-left: 8%;">Assistant Manager-II</p>

                  <p style="display: inline; margin-left: 8%;">Chief Executive officer</p>

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
            <h3>Deduction Report</h3>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form method="POST" id="form" action="<?php echo site_url("reports/totaldeduction"); ?>">
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