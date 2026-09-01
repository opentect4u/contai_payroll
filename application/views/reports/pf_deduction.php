<?php 
$selected = (object) $selected;
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>PF Deduction Report</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("reports/pf_deduction"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                        <div class="col-3">
                                                <label for="exampleInputName1">Branch:</label>
                                                <select class="form-control" name="branch_id" id="branch_id">
                                                    <option value="">Select Branch</option>
                                                    <option value="0" <?= $selected->branch_id == 0 ? 'selected' : '' ?>>All Branch</option>
                                                    <?php 
                                                    foreach ($branch as $row) {
                                                        $_selected = ($selected->branch_id == $row->id) ? 'selected' : '';
                                                        echo '<option value="'.$row->id.'" '.$_selected.'>'.$row->branch_name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="exampleInputName1">Input Year:</label>
                                                <input type="text" class="form-control" name="year" id="year" value="<?= $selected->year ?>" required />
                                            </div>
                                            <div class="col-3">
                                                <label for="exampleInputName1">Select Month:</label>
                                                <select class="form-control" name="month" id="month" required>
                                                    <option value="">Select Month</option>
                                                    <?php 
                                                    foreach ($month as $row) {
                                                        $_selected = ($selected->month == $row->id) ? 'selected' : '';
                                                        echo '<option value="'.$row->id.'" '.$_selected.'>'.$row->month_name.'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="exampleInputName1">Category:</label>
                                                <select class="form-control" name="category_id" id="category_id">
                                                    <option value="">Select Category</option>
                                                    <?php 
                                                    foreach ($category as $row) {
                                                        $_selected = ($selected->category_id == $row->id) ? 'selected' : '';
                                                        echo '<option value="'.$row->id.'" '.$_selected.'>'.$row->category.'</option>';
                                                    }
                                                    ?>
                                                </select>
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
                                                    <th class="not-export">Sl No</th>
                                                    <th class="not-export">BRANCH</th>
                                                    <th>UAN</th>
                                                    <th>MEMBER NAME</th>
                                                    <th>GROSS WAGES</th>
                                                    <th>EPF WAGES</th>
                                                    <th>EPS WAGES</th>
                                                    <th>EDLI WAGES</th>
                                                    <th>EPF CONTRI REMITTED</th>
                                                    <th>EPS CONTRI REMITTED</th>
                                                    <th>EPF EPS DIFF REMITTED</th>
                                                    <th>NCP DAYS</th>
                                                    <th>REFUND OF ADVANCES</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if ($list) {
                                                        $i = 0; 
                                                        foreach ($list as $row) {
                                                            $age = date_diff(date_create($row->dob), date_create('now'))->y;
                                                            if($age > 60) {
                                                                continue;
                                                            }
                                                            $row->gross = round($row->gross,0);
                                                            $row->epf_wages = round($row->wages,0);
                                                            $row->eps_wages = $age >= 58 ? 0 : (round($row->wages,0) > 15000 ? 15000 : round($row->wages,0));
                                                            $row->edli_wages = round($row->wages,0) > 15000 ? 15000 : round($row->wages,0);
                                                            $row->epf_contri_remitted = round(($row->epf_wages*12)/100,0);
                                                            $row->eps_contri_remitted = round(($row->eps_wages*8.33)/100,0);
                                                            $row->epf_eps_diff_remitted = round($row->epf_contri_remitted - $row->eps_contri_remitted,0);
                                                            echo '<tr>';
                                                            echo '<td>'.++$i.'</td>';
                                                            echo '<td>'.$row->branch_name.'</td>';
                                                            echo '<td>'.$row->uan.'</td>';
                                                            echo '<td>'.$row->emp_name.'</td>';
                                                            echo '<td align="right">'.$row->gross.'</td>';
                                                            echo '<td align="right">'.$row->epf_wages.'</td>';
                                                            echo '<td align="right">'.$row->eps_wages.'</td>';
                                                            echo '<td align="right">'.$row->edli_wages.'</td>';
                                                            echo '<td align="right">'.$row->epf_contri_remitted.'</td>';
                                                            echo '<td align="right">'.$row->eps_contri_remitted.'</td>';
                                                            echo '<td align="right">'.$row->epf_eps_diff_remitted.'</td>';
                                                            echo '<td>0</td>';
                                                            echo '<td>0</td>';
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
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'gross')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'epf_wages')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'eps_wages')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'edli_wages')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'epf_contri_remitted')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'eps_contri_remitted')) ?></th>
                                                        <th style="text-align:right"><?= array_sum(array_column($list, 'epf_eps_diff_remitted')) ?></th>
                                                        <th></th>
                                                        <th></th>
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
      _datatable('PF Deduction for ' + $('#branch_id option:selected').text() + '_' + $('#month').val() + $('#year').val(), 4, 0, 'tbl', 'landscape');
    });
</script>