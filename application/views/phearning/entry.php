<?php
$msg = $this->session->flashdata('msg');
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3>Pay Head Amount Entry (Designation wise)</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="myform" action="<?php echo site_url("sphearning"); ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Pay Head:</label>
                                                <select id="payhead_id" name="payhead_id" class="dd form-control pointer">
                                                    <option value="">Select Payhead</option>
                                                    <?php foreach($payhead as $row) { ?>
                                                    <option value="<?=$row->sl_no?>"><?=$row->pay_head?></option>
                                                    <?php } ?>
                                                </select> 
                                            </div>
                                            <div class="col-5">
                                                <label>Designation:</label>
                                                <select id="designation_id" name="designation_id" class="form-control pointer">
                                                    <option value="">Select Designation</option>
                                                    <?php foreach($designation as $row) { ?>
                                                    <option value="<?=$row->sl_no?>"><?=$row->designation?></option>
                                                    <?php } ?>
                                                </select> 
                                            </div>
                                            <div class="col-3">
                                                <label>Amount:</label>
                                                <input type="text" id="amount" name="amount" class="form-control" value="" />
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
</div>