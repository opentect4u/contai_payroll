<?php 
$selected = (object) $selected;
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Income-Tax / TDS Deduction Report</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("reports/tds_deduction"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                          <div class="col-3">
                                              <label for="exampleInputName1">From Date:</label>
                                              <input type="date" name="from_date" class="form-control" id="from_date" value="<?= $selected->from_date; ?>" />
                                          </div>
                                          <div class="col-3">
                                              <label for="exampleInputName1">From Date:</label>
                                              <input type="date" name="to_date" class="form-control" id="to_date" value="<?= $selected->to_date; ?>" />
                                          </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info" value="Submit" />
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                                <thead>
                                                <tr>                                                    
                                                    <th>Branch</th>
                                                    <th>Emp Code</th>
                                                    <th>Employee Name</th>
                                                    <th>Designation</th>
                                                    <th>PAN No</th>
                                                    <th>Month</th>
                                                    <th>Year</th>
                                                    <th>TDS Deduction</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if ($list) {
                                                        $i = 0; 
                                                        foreach ($list as $row) {
                                                            echo '<tr>';
                                                            echo '<td>'.$row->branch_name.'</td>';
                                                            echo '<td>'.$row->emp_code.'</td>';
                                                            echo '<td>'.$row->emp_name.'</td>';
                                                            echo '<td>'.$row->designation.'</td>';
                                                            echo '<td>'.$row->pan_no.'</td>';
                                                            echo '<td>'.$row->sal_month.'</td>';
                                                            echo '<td>'.$row->sal_year.'</td>';
                                                            echo '<td align="right">'.floatval($row->amount).'</td>';
                                                            echo '</tr>';
                                                        }
                                                    }
                                                ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'amount')) ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
      _datatable('TDS Deduction from ' + $('#from_date').val() + ' to ' + $('#to_date').val(), 4, 1, 'tbl', 'landscape');
    });
</script>