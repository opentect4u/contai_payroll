<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Employee Add</h3>
                <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("emadst"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                        
                                            <div class="col-2">
                                                <label for="exampleInputName1">Code Prefix:<span class="requiredfield">*</span></label>
                                                <input type="text" name="prefix_emp_cd" class="form-control" id="prefix_emp_cd" value=""  />
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">Employee Code:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_code" class="form-control" id="emp_code" value="" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Employee Name:<span class="requiredfield">*</span></label>
                                                <input type="text" name="emp_name" class="form-control" id="emp_name" value="" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Sex:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="emp_sex" id="emp_sex" required >
                                                <option value="">Select Sex</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                                <option value="O">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Father Name:<span class="requiredfield">*</span></label>
                                                <input type="text" name="father_name" class="form-control" id="father_name" value="" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Qualification:<span class="requiredfield">*</span></label>
                                                <input type="text" name="qualification" class="form-control" id="qualification" value="" required />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Caste:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="caste" id="caste" required >
                                                <option value="">Select Caste</option>
                                                <?php foreach ($caste as $list) {
                                                ?>
                                                    <option value="<?php echo $list->id ?>">
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
                                                <select class="form-control" name="emp_catg" id="emp_catg" required >
                                                <option value="">Select Category</option>
                                                <?php foreach ($category_dtls as $c_list) {
                                                ?>
                                                    <option value="<?php echo $c_list->id ?>">
                                                        <?php echo $c_list->category; ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Branch:</label>
                                                <select class="form-control" name="branch_id" id="branch_id" required>
                                                    <option value="">Select Branch</option>
                                                    <?php foreach ($branch_dtls as $branch) {
                                                    ?>
                                                        <option value="<?php echo $branch->id ?>">
                                                            <?php echo $branch->branch_name; ?>
                                                        </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Designation:</label>
                                                <select class="form-control" name="designation" id="designation">
                                                    <option value="">Select Designation</option>
                                                    <?php foreach ($dept as $dep) { ?>
                                                        <option value="<?php echo $dep->sl_no ?>">
                                                            <?php echo $dep->designation; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Email:</label>
                                                <input type="email" class="form-control" name="email" id="email" value="" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Phone No.<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control" name="phn_no" required id="phn_no" value="" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">PI NO.<span class="requiredfield">*</span></label>
                                                <input type="text" class="form-control" name="pi_no" required id="pi_no" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label for="exampleInputName1">Date of Birth:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="dob" id="dob" required value="" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Joining Date:<span class="requiredfield">*</span></label>
                                                <input type="date" class="form-control" name="join_dt" id="join_dt" required value="" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">Retirement Date:</label>
                                                <input type="date" class="form-control" name="ret_dt" id="ret_dt" value="" />
                                            </div>
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="exampleInputName1">Address:</label>
                                                <textarea type="text" class="form-control required" name="emp_addr" id="emp_addr"></textarea>
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
                                                <input type="text" class="form-control required" name="basic_pay" required id="basic_pay" value="" />
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">HRA FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="hra_flag" id="hra_flag">
                                                    <option value="Y">YES</option>
                                                    <option value="N">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">PF FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="pf_flag" id="pf_flag">
                                                    <option value="Y">YES</option>
                                                    <option value="N">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">CASH FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="cash_flag" id="cash_flag">
                                                    <option value="Y">YES</option>
                                                    <option value="N">NO</option>
                                                </select>
                                            </div>
                                            <div class="col-2">
                                                <label for="exampleInputName1">FOOD FLAG:<span class="requiredfield">*</span></label>
                                                <select class="form-control" name="food_flag" id="food_flag">
                                                    <option value="Y">YES</option>
                                                    <option value="N">NO</option>
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
                                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="" />
                                            </div>
                                            <div class="col-4">
                                                <label for="exampleInputName1">A/C No.:</label>
                                                <input type="text" class="form-control" name="bank_ac_no" id="bank_ac_no" value="" />
                                            </div>
                                             <div class="col-4">
                                                <label for="exampleInputName1">IFSC:</label>
                                                <input type="text" class="form-control" name="ifsc" id="ifsc" value="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">PF A/C No.:</label>
                                                <input type="text" class="form-control" name="pf_ac_no" id="pf_ac_no" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">UAN.:</label>
                                                <input type="text" class="form-control" name="uan" id="uan" value="" />
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="exampleInputName1">Pan No.:</label>
                                                <input type="text" class="form-control" name="pan_no" id="pan_no" value="" />
                                            </div>
                                            <div class="col-6">
                                                <label for="exampleInputName1">Aadhar No.:</label>
                                                <input type="text" class="form-control required" name="aadhar" id="aadhar" value="" />
                                            </div>

                                        </div>
                                    </div>
                                    <input type="hidden" name="emp_dist" value="339">
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
    <script>
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