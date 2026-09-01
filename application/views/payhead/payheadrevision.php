    <div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h3>Payhead Revision</h3>
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                          <div class="card-body">
                            <?php if (validation_errors()): ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
    <?php endif; ?>
            <?php if($this->session->flashdata('success')): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?php echo $this->session->flashdata('success'); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>

          <?php if($this->session->flashdata('error')): ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?php echo $this->session->flashdata('error'); ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
          <?php endif; ?>
                            <p class="mb-2">You can revise the payhead details on Basic. All associated Payhead amounts will be updated, and the corresponding Payhead percentages will also be synchronized in the master payhead records.</p>
                            <div class="p-3 rounded" style="background-color:#d91c1c; color:white; display:flex; align-items:center;">
                              <svg xmlns="http://www.w3.org/2000/svg" 
                                  class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" 
                                  width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.964 0L.165 13.233c-.457.778.091 1.767.982 1.767h13.706c.89 0 1.438-.99.982-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2.002 0 1 1 0 0 1 2.002 0z"/>
                              </svg>
                              <div>
                                  <strong>Warning:</strong> Be extremely cautious! Processing will update all employee payhead amounts and master payhead percentages.
                              </div>
                          </div>
                        </div>
                  </div>   
                </div>
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                        <form method="POST" id="form" action="<?php echo base_url();?>index.php/salary/payheadrevision" >
                            <div class="form-group">
                                <div class="row">
                                   <div class="col-3">
                                    <label for="exampleInputName1">Category </label>
                                       <select type="text" class="form-control" name="category" id="category" required >

                                                <option value="">Select Category</option>

                                                <?php foreach ($category as $c_list) { ?>

                                                    <option value="<?php echo $c_list->id; ?>"><?php echo $c_list->category; ?></option>

                                                <?php
                                                }
                                                ?>

                                                </select>
                                    </div>
                                    <div class="col-3">
                                    <label for="exampleInputName1">Payhead </label>
                                        <select name="payhead_id" id="payhead_id" class="form-control" Required>
                                            <option value="">Select Payhead</option>
                                            <?php foreach($payhead_dtls as $key) { ?>
                                            <option value="<?=$key->sl_no?>"><?=$key->pay_head?></option>
                                            <?php } ?>
                                        </select> 
                                    </div>
                                  <div class="col-3">
                                    <label for="exampleInputName1">Year:</label>
                                    <input type="number" 
                                              name="year" 
                                              class="form-control" 
                                              id="year" 
                                              min="1900" 
                                              max="2100" 
                                              step="1"  value="<?php echo date("Y"); ?>"
                                              required/>
                                  </div>
                                  <div class="col-3">
                                    <label for="exampleInputName1">Months </label>
                                        <select name="month_id" id="month_id" class="form-control" >
                                             <?php 
                                                  $currentMonth = date('n'); // 1-12 numeric representation of current month
                                                  foreach($month_list as $month) { 
                                                      $selected = ($month->id == $currentMonth) ? 'selected' : '';
                                                  ?>
                                                      <option value="<?=$month->id?>" <?=$selected?>>
                                                          <?=$month->month_name?>
                                                      </option>
                                                  <?php } ?>
                                        </select> 
                                    </div>
                                  <div class="col-3">
                                    <label for="exampleInputName1">Percentage:</label>
                                    <input type="number" name="percentage" class="form-control" id="percentage" value="0.0" step=".01" required/>
                                    </div>
                                    
                                </div>
                            </div>
                          
                            <button type="submit" class="btn btn-primary mr-2">Proceed</button>
                            <button class="btn btn-light">Cancel</button>
                        </form>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
    </div>