<style>
    th {
        text-align: center;
        vertical-align: middle !important;
    }
</style>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$logoFile = $this->session->userdata['loggedin']['logo_path'];

	// Convert URL to server file path
	$imagePath = FCPATH . 'assets/images/' . $logoFile;

	if (file_exists($imagePath)) {
		$imageType = pathinfo($imagePath, PATHINFO_EXTENSION);
		$imageData = file_get_contents($imagePath);
		$base64Image = 'data:image/' . $imageType . ';base64,' . base64_encode($imageData);
	} else {
		$base64Image = '';
	}
?>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body" id='divToPrint'>
                    <div class="row">
                        <div class="col-3"><a href="javascript:void()">
                            <img src="<?php echo $base64Image; ?>" alt="logo" height="100" width="100" />
							</a></div>
                        <div class="col-9" style="text-align: center !important;">
                                 <?php include_once('common_report_header.php'); ?>
							<h4>Salary summary report for the month of <?php echo MONTHS[$this->input->post('sal_month')] . ' ' . $this->input->post('year'); ?></h4>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive" id='ajaxl'>
                                <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                    <thead>
                                        <tr>
                                        <th>Branch</th>
                                        <th>Code</th>
                                        <th>Employee</th>
                                        <th>Designation</th>
                                        <th>Basic</th>
                                        <?php 
                                        foreach($payhead as $row) {
                                            if($row->pay_head_type == 'E') echo '<th title="'.$row->pay_head.'">'.$row->code.'</th>';
                                        }
                                        echo '<th title="Gross Pay">GPS</th>';
                                        foreach($payhead as $row) {
                                            if($row->pay_head_type == 'D') echo '<th title="'.$row->pay_head.'">'.$row->code.'</th>';
                                        }
                                        echo '<th title="Net Pay">NS</th>';
                                        ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach($list as $row) {
                                            $key = explode(',', $row->payhead);
                                            $val = explode(',', $row->amount);
                                            $row->basic = $val[0];
                                            echo '<tr>';
                                            echo '<td>'.$row->branch_name.'</td>';
                                            echo '<td>'.$row->emp_code.'</td>';
                                            echo '<td>'.$row->emp_name.'</td>';
                                            echo '<td>'.$row->designation.'</td>';
                                            echo '<td><b>'.floatval($val[0]).'</b></td>';
                                            $gross = $val[0];
                                            foreach($payhead as $ph) {
                                                if($ph->pay_head_type == 'E') {
                                                    $position = array_search($ph->pay_head_id, $key);
                                                    $code = $ph->code;
                                                    $amount = 0;
                                                    if($position > 0) {
                                                        $amount = $val[$position];
                                                    }
                                                    echo '<td><b>'.floatval($amount).'</b></td>';
                                                    $gross += $amount;
                                                    $row->$code = $amount;
                                                }
                                            }
                                            echo '<td><b>'.floatval($gross).'</b></td>';
                                            $row->gross = $gross;
                                            $deduction = 0;
                                            foreach($payhead as $ph) {
                                                if($ph->pay_head_type == 'D') {
                                                    $position = array_search($ph->pay_head_id, $key);
                                                    $code = $ph->code;
                                                    $amount = 0;
                                                    if($position > 0) {
                                                        $amount = $val[$position];
                                                    }
                                                    echo '<td><b>'.floatval($amount).'</b></td>';
                                                    $deduction += $amount;
                                                    $row->$code = $amount;
                                                }
                                            }
                                            $row->net = $gross - $deduction;
                                            echo '<td><b>'.floatval($row->net).'</b></td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="not-export"></th>
                                            <th></th>
                                            <th></th>
                                            <th class="not-export"></th>
                                            <th><?= array_sum(array_column($list, 'basic')) ?></th>
                                            <?php 
                                            foreach($payhead as $ph) {
                                                if($ph->pay_head_type == 'E') {
                                                    echo '<th>'.array_sum(array_column($list, $ph->code)).'</th>';
                                                }
                                            }
                                            echo '<th>'.array_sum(array_column($list, 'gross')).'</th>';
                                            foreach($payhead as $ph) {
                                                if($ph->pay_head_type == 'D') {
                                                    echo '<th>'.array_sum(array_column($list, $ph->code)).'</th>';
                                                }
                                            }
                                            echo '<th>'.array_sum(array_column($list, 'net')).'</th>';
                                            ?>
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
<?php
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="card">
                    <div class="card-body">
                        <h3>Employee Salary Statement Report</h3>
                        <div class="row">
                            <div class="col-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <form method="POST" id="form" action="<?php echo site_url("reports/empeardedudd"); ?>">
                                            <div class="form-group">
                                                <div class="row">
                                                <div class="col-3">
                                                        <label for="exampleInputName1">Branch:</label>
                                                        <select class="form-control" name="branch_id" id="branch_id" required>
                                                            <option value="">Select Branch</option>
                                                            <option value="0">All Branch</option>
                                                            <?php foreach ($branchlist as $m_list) { ?>
                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->branch_name; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Input Year:</label>
                                                        <input type="text" class="form-control" name="year" id="year" value="<?php echo date('Y'); ?>" required />
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Select Month:</label>
                                                        <select class="form-control" name="sal_month" id="sal_month" required>
                                                            <option value="">Select Month</option>
                                                            <?php foreach ($month_list as $m_list) { ?>

                                                                <option value="<?php echo $m_list->id ?>"><?php echo $m_list->month_name; ?></option>

                                                            <?php
                                                            }
                                                            ?>

                                                        </select>

                                                    </div>
                                                    <div class="col-3">
                                                        <label for="exampleInputName1">Category:</label>
                                                        <select class="form-control required" name="category" id="category" required>

                                                            <option value="">Select Category</option>

                                                            <?php foreach ($category as $c_list) { ?>

                                                                <option value="<?php echo $c_list->id; ?>"><?php echo $c_list->category; ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <input type="submit" class="btn btn-info" value="Proceed" onclick="return checkVal();" />
                                            <button class="btn btn-light">Cancel</button>
                                        </form>
                                    </div>
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
<script>
    $(document).ready(function() {
      _datatable('Salary Statement for the month of <?php echo MONTHS[$this->input->post('sal_month')] . ' ' . $this->input->post('year'); ?>',3, 1, 'tbl', 'landscape', 1);
    });
    function checkVal() {
        var month = $('#sal_month').val();
        var catg_id = $('#category').val();
        if (month > 0 && catg_id > 0) {
            return true;
        } else {
            alert('Please fill all fields')
            return false;
        }
    }
</script>