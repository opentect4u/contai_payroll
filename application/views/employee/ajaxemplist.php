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
<script>
    $(document).ready(function() {
      _datatable('Employee List',2, 2, 'order-listing');
    });
</script>