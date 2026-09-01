<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Employee Edit</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="myform" action="<?php echo site_url("estem"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                        <div class="col-2">
                                                <label for="exampleInputName1">Employee Code:<span class="requiredfield">*</span></label>
                                                <input type="text" name="" class="form-control" value="<?php echo $employee_dtls->prefix_emp_cd; ?>" readonly />
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">Employee Code:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_code" class="form-control" id="emp_code" value="<?php echo $employee_dtls->emp_code; ?>" readonly />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Employee Name:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_name" class="form-control required" id="emp_name" value="<?php echo $employee_dtls->emp_name; ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Sex:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="emp_sex" id="emp_sex" required >
                                                <option value="">Select Sex <?php echo $employee_dtls->emp_sex=='M' ; ?></option>
                                                <option value="M" <?php if($employee_dtls->emp_sex=='M') echo 'selected'; ?>>Male</option>
                                                <option value="F" <?php if($employee_dtls->emp_sex=='F') echo 'selected'; ?> >Female</option>
                                                <option value="O" <?php if($employee_dtls->emp_sex=='O') echo 'selected'; ?> >Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Father Name:<span class="requiredfield">*</span></label>
                                                <input type="text" name="father_name" class="form-control" id="father_name" value="<?=$employee_dtls->father_name?>" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Qualification:<span class="requiredfield">*</span></label>
                                                <input type="text" name="qualification" class="form-control" id="qualification" value="<?=$employee_dtls->qualification?>" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Caste:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="caste" id="caste" required >
                                                <option value="">Select Caste</option>
                                                <?php foreach ($caste as $list) {
                                                ?>
                                                    <option value="<?php echo $list->id ?>" <?php echo ($employee_dtls->caste == $list->id) ? 'selected' : ''; ?>>
                                                        <?php echo $list->caste; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Category:<span class="requiredfield">*</span></label>
                                                <select class="form-control required" name="emp_catg" id="emp_catg">

                                                    <option value="">Select Category</option>

                                                    <?php foreach ($category_dtls as $c_list) {

                                                    ?>
                                                        <option value="<?php echo $c_list->id ?>" <?php echo ($employee_dtls->emp_catg == $c_list->id) ? 'selected' : ''; ?>>
                                                            <?php echo $c_list->category; ?>
                                                        </option>

                                                    <?php

                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                           
                                            <div class="col-4">
                                                <label for="exampleInputName1">Branch:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="branch_id" id="branch_id" required>

                                                    <option value="">Select Branch</option>
                                                    
                                                    <?php 
                                                    foreach ($branch_dtls as $dist) {
                                                    ?>
                                                        <option value="<?php echo $dist->id ?>" <?php echo ($employee_dtls->branch_id == $dist->id) ? 'selected' : ''; ?>>
                                                            <?php echo $dist->branch_name; ?>
                                                        </option>

                                                    <?php

                                                    }

                                                    ?>

                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Designation:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="designation" id="designation" required>
                                                    <option value="">Select Designation</option>
                                                    <?php
                                                    foreach ($dept as $dep) {
                                                        $selected = '';
                                                        if ($dep->sl_no == $employee_dtls->designation) {
                                                            $selected = 'selected';
                                                        } ?>
                                                        <option value="<?php echo $dep->sl_no; ?>" <?= $selected ?>><?php echo $dep->designation; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                       
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Date of Birth:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="dob" id="dob" value="<?php if (isset($employee_dtls->dob)) {
                                                                                                                        echo $employee_dtls->dob;
                                                                                                                    }
                                                                                                                    ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Joining Date:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="join_dt" id="join_dt" value="<?php if (isset($employee_dtls->join_dt)) {
                                                                                                                                echo $employee_dtls->join_dt; } ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Retirement Date:</label>
                                                <input type="date" class="form-control" name="ret_dt" id="ret_dt" value="<?php if (isset($employee_dtls->ret_dt)) {
                                                                                                                                echo $employee_dtls->ret_dt;
                                                                                                                            } ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Email:</label>
                                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $employee_dtls->email; ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Phone No.<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control" name="phn_no" id="phn_no" value="<?php echo $employee_dtls->phn_no; ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">PI No.<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control" name="pi_no" id="pi_no" value="<?php echo $employee_dtls->pi_no; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group">
                                        <div class="row">
                                          
                                            <div class="col-12">
                                                <label for="exampleInputName1">Address:</label>
                                                <textarea type="text" class="form-control required" name="emp_addr" id="emp_addr"><?php echo $employee_dtls->emp_addr; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-header">

                                        <h4>Basic Pay</h4>

                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Basic Pay:<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control required" name="basic_pay" id="basic_pay" value="<?php echo $employee_dtls->basic_pay; ?>" />
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">HRA FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="hra_flag" id="hra_flag">
                                                    <option value="Y" <?php echo ($employee_dtls->hra_flag == 'Y') ? 'selected' : ''; ?>>YES</option>
                                                    <option value="N" <?php echo ($employee_dtls->hra_flag == 'N') ? 'selected' : ''; ?>>NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">PF FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="pf_flag" id="pf_flag">
                                                    <option value="Y" <?php echo ($employee_dtls->pf_flag == 'Y') ? 'selected' : ''; ?>>YES</option>
                                                    <option value="N" <?php echo ($employee_dtls->pf_flag == 'N') ? 'selected' : ''; ?>>NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">CASH FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="cash_flag" id="cash_flag">
                                                    <option value="Y" <?php echo ($employee_dtls->cash_flag == 'Y') ? 'selected' : ''; ?>>YES</option>
                                                    <option value="N" <?php echo ($employee_dtls->cash_flag == 'N') ? 'selected' : ''; ?>>NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">FOOD FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="food_flag" id="food_flag">
                                                    <option value="Y" <?php echo ($employee_dtls->food_flag == 'Y') ? 'selected' : ''; ?>>YES</option>
                                                    <option value="N" <?php echo ($employee_dtls->food_flag == 'N') ? 'selected' : ''; ?> >NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-header">
                                        <h4>Bank & Other Details</h4>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Bank Name:</label>
                                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $employee_dtls->bank_name; ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">A/C No.:</label>
                                                <input type="text" class="form-control" name="bank_ac_no" id="bank_ac_no" value="<?php echo $employee_dtls->bank_ac_no; ?>" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">IFSC:</label>
                                                <input type="text" class="form-control" name="ifsc" id="ifsc" value="<?php echo $employee_dtls->ifsc; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">PF A/C No.:</label>
                                                <input type="text" class="form-control" name="pf_ac_no" id="pf_ac_no" value="<?php echo $employee_dtls->pf_ac_no; ?>" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">UAN.:</label>
                                                <input type="text" class="form-control" name="uan" id="uan" value="<?php echo $employee_dtls->uan; ?>" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Pan No.:</label>
                                                <input type="text" class="form-control" name="pan_no" id="pan_no" value="<?php echo $employee_dtls->pan_no; ?>" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Aadhar No.:</label>
                                                <input type="text" class="form-control required" name="aadhar" id="aadhar" value="<?php echo $employee_dtls->aadhar_no; ?>" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-6">
                                                <label for="exampleInputName1">Status:</label>
                                                <select name='emp_status' class='form-control'>
                                                    <option value="A" <?php if ($employee_dtls->emp_status == 'A') echo 'selected'; ?>>Active</option>
                                                    <option value="R" <?php if ($employee_dtls->emp_status == 'R') echo 'selected'; ?>>Retired</option>
                                                    <option value="S" <?php if ($employee_dtls->emp_status == 'S') echo 'selected'; ?>>Suspended</option>
                                                    <option value="RG" <?php if ($employee_dtls->emp_status == 'RG') echo 'selected'; ?>>Resigned</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleInputName1">Remarks:</label>
                                                <textarea class='form-control' name="remarks"><?=$employee_dtls->remarks?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <button class="btn btn-light">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        <?php if ($employee_dtls->emp_status == 'R' or $employee_dtls->emp_status == 'RG') { ?>
            $(document).ready(function() {
                $("#myform :input").prop("disabled", true);
            });
        <?php } ?>

           $('#dob').change(function() {
    // 1. Get the Date of Birth value
    var dob = new Date($('#dob').val());

    // 2. Calculate the Retirement Year (DOB Year + 60)
    var retirementYear = dob.getFullYear() + 60;

    // 3. Determine the Retirement Month (DOB Month)
    //    We want the *last day* of this month, so we calculate the *first day* of the *next* month.
    var retirementMonth = dob.getMonth() + 1; // Month index starts at 0, so DOB month is current month + 1

    // 4. Create a new Date object for the FIRST DAY of the *NEXT* month
    //    - year: retirementYear
    //    - month: retirementMonth (since month index is 0-based, this represents the NEXT month)
    //    - day: 1
    var nextMonth = new Date(retirementYear, retirementMonth, 1);

    // 5. Subtract one day (86400000 milliseconds) from the 'nextMonth' date
    //    This rolls the date back to the last day of the desired retirement month.
    var lastDayOfMonth = new Date(nextMonth.getTime() - 86400000);

    // 6. Format the resulting date as YYYY-MM-DD
    var day = ("0" + lastDayOfMonth.getDate()).slice(-2);
    var month = ("0" + (lastDayOfMonth.getMonth() + 1)).slice(-2);
    var year = lastDayOfMonth.getFullYear();

    var rtday = year + "-" + month + "-" + day;

    // 7. Set the value of the retirement date input
    $('#ret_dt').val(rtday);
});
    </script>