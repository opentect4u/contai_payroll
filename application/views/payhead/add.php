    <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Payhead Add</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo base_url();?>index.php/payheadadd" >
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="exampleInputName1">Payhead Name:</label>
                                    <input type="text" name="pay_head" class="form-control" id="pay_head" value="" required/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Input Flag:</label>
                                    <select name="input_flag"  class="form-control" required>
                                      <option value="M">Manual</option>
                                      <option value="A">Automatic</option>
                                      <option value="AD">Arrear DA</option>
                                    </select>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Pay Flag:</label>
                                    <select name="pay_flag"  class="form-control" required>
                                      <option value="E">Earning</option>
                                      <option value="D">Deduction</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                    <label for="exampleInputName1">Percentage:</label>
                                    <input type="number" name="percentage" class="form-control" id="percentage" value="0.0" step=".01" required/>
                                    </div>
                                    <div class="col-4">
                                    <label for="exampleInputName1">Account Code:</label>
                                    <input type="number" name="acc_cd" class="form-control" id="acc_cd" value="" required/>
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