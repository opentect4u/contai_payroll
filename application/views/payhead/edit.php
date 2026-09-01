<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Designation Edit</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo base_url();?>index.php/payheadedit" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="exampleInputName1">Designation Name:</label>
                                    <input type='hidden' name='id' value='<?php echo $payhead_dtls->sl_no; ?>' />
                                    <input type="text" name="pay_head" class="form-control required" id="name" value="<?php echo $payhead_dtls->pay_head; ?>" />
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Input Flag:</label>
                                    <select name="input_flag"  class="form-control" required>
                                      <option value="M" <?php  if($payhead_dtls->input_flag=='M') { echo 'selected'; }?>>Manual</option>
                                      <option value="A" <?php  if($payhead_dtls->input_flag=='A') { echo 'selected'; } ?>>Automatic</option>
                                      <option value="AD" <?php  if($payhead_dtls->input_flag=='AD') { echo 'selected'; } ?>>Arrear DA</option>
                                    </select>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Pay Flag:</label>
                                    <select name="pay_flag"  class="form-control" required>
                                      <option value="E" <?php  if($payhead_dtls->input_flag=='E') { echo 'selected'; }?> >Earning</option>
                                      <option value="D" <?php  if($payhead_dtls->input_flag=='D') { echo 'selected'; }?> >Deduction</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                <div class="col-4">
                                    <label for="exampleInputName1">Percentage:</label>
                                    <input type="number" name="percentage" class="form-control" id="percentage" step=".01" value="<?php echo $payhead_dtls->percentage; ?>" required/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Account Code:</label>
                                    <input type="number" name="acc_cd" class="form-control" id="acc_cd" value="<?php echo $payhead_dtls->acc_cd; ?>" required/>
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