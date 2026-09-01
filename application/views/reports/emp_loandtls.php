
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Emp Loan Details</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                          
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                                <thead>
                                                <tr>                                                    
                                                    <th>Employee Name</th>
                                                    <th>Pay head Name </th>
                                                    <th>Amount</th>
                                                    <th>Loan Account No</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                    if ($list) {
                                                        $i = 0; 
                                                        foreach ($list as $row) {
                                                            echo '<tr>';
                                                            echo '<td>'.$row->emp_name.'</td>';
                                                            echo '<td>'.$row->pay_head.'</td>';
                                                            echo '<td>'.$row->amount.'</td>';
                                                            echo '<td>'.$row->account_no.'</td>';
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
      _datatable('Employee Loan Details', 1, 2, 'tbl', 'landscape');
    });
</script>