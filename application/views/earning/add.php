<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Earnings</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slryad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-5">
                                                <label for="exampleInputName1">Date:</label>
                                                <input type="date" name="sal_date" class="form-control required" id="sal_date" value="<?= $selected['sal_date']; ?>" />
                                            </div>
                                            <div class="col-5">
                                                <label for="exampleInputName1">Category:</label>
                                                <select class="form-control required" name="catg_id" id="catg_id">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    if ($catg_list) {
                                                        $select = '';
                                                        foreach ($catg_list as $catg) {
                                                            if ($selected['catg_id'] == $catg->id) {
                                                                $select = 'selected';
                                                            } else {
                                                                $select = '';
                                                            } ?>
                                                            <option value="<?= $catg->id ?>" <?= $select ?>><?= $catg->category; ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-2 float-right">
                                                <label for="exampleInputName1">&nbsp;</label>
                                                <button type="submit" id="submit" name="submit" class="btn btn-primary mr-2 form-control">Populate</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php if (isset($_REQUEST['submit'])) {
            $display = '';
            $disabled = '';
            if ($selected['catg_id'] == 2) {
                $display = 'style="display:none;"';
            } ?>
            <div class="card mt-4">
                <div class="card-body">
                    <h3>Add Earnings</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("salsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Emp name</th>
                                                                <th>Basic</th>
                                                                <th>D.A.</th>
                                                                <!-- <th>S.P.</th> -->
                                                                <th>H.R.A.</th>
                                                                <th>M.A.</th>
                                                                <th>CASH ALL</th>
                                                                <th>FIELD. A.</th>
                                                                <th>Arrear</th>
                                                                <th>Interim Relief</th>
                                                                <th>Gross Salary</th>
                                                                <th>LWP</th>
                                                                <th>GROSS SALARY (after deduction)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tot_final_gross = 0;
                                                            $tot_basic = 0;
                                                            $tot_sp = 0;
                                                            $tot_da = 0;
                                                            $tot_hra = 0;
                                                            $tot_ma = 0;
                                                            $tot_sa = 0;
                                                            $tot_ta = 0;
                                                            $tot_arrear = 0;
                                                            $tot_ot = 0;
                                                            $tot_gross = 0;
                                                            $tot_lwp = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                foreach ($sal_list as $sal) {
                                                                    $tot_final_gross += $sal['final_gross'];
                                                                    $tot_basic += $sal['basic'];
                                                                    $tot_sp += $sal['sp'];
                                                                 //   $tot_da += round(($sal['basic']*111)/100);$sal['da']
																	$tot_da += $sal['da'];
                                                                    $tot_hra += $sal['hra'];
                                                                    $tot_ma += $sal['ma'];
                                                                    $tot_sa += $sal['sa'];
                                                                    $tot_ta += $sal['ta'];
                                                                    $tot_arrear += $sal['arrear'];
                                                                    $tot_ot += $sal['ot'];
                                                                    $tot_gross += $sal['gross'];
                                                                    $tot_lwp += $sal['lwp'];
																	
                                                            ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="emp_name[]" class="form-control required" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" readonly />
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="basic[]" class="form-control required" id="basic_<?= $i ?>" value="<?= $sal['basic']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="da[]" class="form-control required" id="da_<?= $i ?>" value="<?php echo $sal['da']; ?><?php //echo round(($sal['basic']*111)/100); ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <input type="hidden" name="sp[]" class="form-control required" id="sp_<?= $i ?>" value="<?= $sal['sp']; ?>" readonly />
                                                                        <!-- <td>
                                                                            <div class="form-group">
                                                                                
                                                                            </div>
                                                                        </td> -->
                                                                        
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="hra[]" class="form-control required" id="hra_<?= $i ?>" value="<?= $sal['hra']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ma[]" class="form-control required" id="ma_<?= $i ?>" value="<?= $sal['ma']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="sa[]" class="form-control required" id="sa_<?= $i ?>" value="<?= $sal['sa']; ?>" onchange="calculate_bal(<?= $i ?>)"/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ta[]" class="form-control required" id="ta_<?= $i ?>" value="<?= $sal['ta']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="arrear[]" class="form-control required" id="arrear_<?= $i ?>" value="<?= $sal['arrear']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="ot[]" class="form-control required" id="ot_<?= $i ?>" value="<?= $sal['ot']; ?>" onchange="calculate_bal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="gross[]" class="form-control required" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="lwp[]" class="form-control required" id="lwp_<?= $i ?>" value="<?= $sal['lwp']; ?>" onchange="lwp_cal(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" name="final_gross[]" class="form-control required" id="final_gross_<?= $i ?>" value="<?= $sal['final_gross'] ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                    </tr>

                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>Total:</td>
                                                                <td><span id="tot_basic"><?= $tot_basic ?></span></td>
                                                                <td><span id="tot_da"><?= $tot_da ?></span></td>
                                                                <!-- <td><span id="tot_sp"><?= $tot_sp ?></span></td> -->
                                                                <td><span id="tot_hra"><?= $tot_hra ?></span></td>
                                                                <td><span id="tot_ma"><?= $tot_ma ?></span></td>
                                                                <td><span id="tot_sa"><?= $tot_sa ?></span></td>
                                                                <td><span id="tot_ta"><?= $tot_ta ?></span></td>
                                                                <td><span id="tot_arrear"><?= $tot_arrear ?></span></td>
                                                                <td><span id="tot_ot"><?= $tot_ot ?></span></td>
                                                                <td><span id="tot_gross"><?= $tot_gross ?></span></td>
                                                                <td><span id="tot_lwp"><?= $tot_lwp ?></span></td>
                                                                <td><span id="tot_final_gross"><?= $tot_final_gross ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <label class="mt-3"><b>Total Gross Salary (After Deduction): </b>&#8377 <span id="tot_gross_show"><?= $tot_gross ?></span>/-</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                            <a href="<?= site_url() ?>/slrydtl" class="btn btn-light">Back</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>

    <script>
        $('#sal_date').on('change', function() {
            var sal_date = $(this).val()
            var catg_id = $('#catg_id').val()
            if (catg_id > 0) {
                $.ajax({
                    type: "GET",
                    url: "<?= site_url() ?>/salary/chk_sal",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's earning");
                            $('#submit').attr('disabled', 'disabled')
                        } else {
                            $('#submit').removeAttr('disabled')
                        }
                    }
                });
            }
        })
        $('#catg_id').on('change', function() {
            var catg_id = $(this).val()
            var sal_date = $('#sal_date').val()
            $.ajax({
                type: "GET",
                url: "<?= site_url() ?>/salary/chk_sal",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's earning");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function calculate_bal(id) {
            var basic = $('#basic_'+id).val() > 0 ? $('#basic_'+id).val() : 0,
            sp = $('#sp_'+id).val() > 0 ? $('#sp_'+id).val() : 0,
            da = $('#da_'+id).val() > 0 ? $('#da_'+id).val() : 0,
            hra = $('#hra_'+id).val() > 0 ? $('#hra_'+id).val() : 0,
            ma = $('#ma_'+id).val() > 0 ? $('#ma_'+id).val() : 0,
            sa = $('#sa_'+id).val() > 0 ? $('#sa_'+id).val() : 0,
            ta = $('#ta_'+id).val() > 0 ? $('#ta_'+id).val() : 0,
            arrear = $('#arrear_'+id).val() > 0 ? $('#arrear_'+id).val() : 0,
            ot = $('#ot_'+id).val() > 0 ? $('#ot_'+id).val() : 0,
            lwp = $('#lwp_'+id).val() > 0 ? $('#lwp_'+id).val() : 0,
            gross = $('#gross_'+id).val();

            tot_gross = parseInt(basic) + parseInt(sp) + parseInt(da) + parseInt(hra) + parseInt(ma) + parseInt(sa) + parseInt(ta) + parseInt(arrear) + parseInt(ot)
            tot_gross_after_did = parseInt(tot_gross) - parseInt(lwp)

            $('#gross_'+id).val(tot_gross)
            $('#final_gross_'+id).val(tot_gross_after_did)
            cal_tot_amt()
        }

        function cal_tot_amt(){
            var tot_basic = 0,
            tot_sp = 0,
            tot_da = 0,
            tot_hra = 0,
            tot_ma = 0,
            tot_sa = 0,
            tot_ta = 0,
            tot_arrear = 0,
            tot_ot = 0,
            tot_lwp = 0,
            tot_gross = 0;
            
            $('input[name="basic[]"]').each(function() {
                tot_basic = parseInt(tot_basic) + parseInt(this.value)
            });
            $('input[name="sp[]"]').each(function() {
                tot_sp = parseInt(tot_sp) + parseInt(this.value)
            });
            $('input[name="da[]"]').each(function() {
                tot_da = parseInt(tot_da) + parseInt(this.value)
            });
            $('input[name="hra[]"]').each(function() {
                tot_hra = parseInt(tot_hra) + parseInt(this.value)
            });
            $('input[name="ma[]"]').each(function() {
                tot_ma = parseInt(tot_ma) + parseInt(this.value)
            });
            $('input[name="sa[]"]').each(function() {
                tot_sa = parseInt(tot_sa) + parseInt(this.value)
            });
            $('input[name="ta[]"]').each(function() {
                tot_ta = parseInt(tot_ta) + parseInt(this.value)
            });
            $('input[name="arrear[]"]').each(function() {
                tot_arrear = parseInt(tot_arrear) + parseInt(this.value)
            });
            $('input[name="ot[]"]').each(function() {
                tot_ot = parseInt(tot_ot) + parseInt(this.value)
            });
            $('input[name="lwp[]"]').each(function() {
                tot_lwp = parseInt(tot_lwp) + parseInt(this.value)
            });
            $('input[name="gross[]"]').each(function() {
                tot_gross = parseInt(tot_gross) + parseInt(this.value)
            });

            $('#tot_sa').text(tot_sa)
            $('#tot_ta').text(tot_ta)
            $('#tot_arrear').text(tot_arrear)
            $('#tot_ot').text(tot_ot)
            $('#tot_gross').text(tot_gross)
            $('#tot_lwp').text(tot_lwp)
            $('#tot_final_gross').text(parseInt(tot_gross)-parseInt(tot_lwp))

            $('#tot_gross_show').text($('#tot_final_gross').text())
        }
        function cash_cal(id) {
            var cash_val = $('#cash_swa_' + id).val();
            var gross_val = $('#gross_' + id).val();
            var gross = $('#final_gross_' + id).val();
            $('#gross_' + id).val(parseInt(cash_val) + parseInt(gross_val))
            $('#final_gross_' + id).val(parseInt(cash_val) + parseInt(gross))
            var final_gross = 0;
            $('input[name="final_gross[]"]').each(function() {
                final_gross = parseInt(final_gross) + parseInt(this.value);
            })
            $('#tot_final_gross').text(final_gross)
            var tot_cash_swa = 0;
            $('input[name="cash_swa[]"]').each(function() {
                tot_cash_swa = parseInt(tot_cash_swa) + parseInt(this.value);
            })
            $('#tot_cash_swa').text(tot_cash_swa)
			
			var tot_gross = 0
			$('input[name="gross[]"]').each(function() {
                tot_gross = parseInt(tot_gross) + parseInt(this.value);
            })
			$('#tot_gross').text(tot_gross);

            // console.log(final_gross);
        }

        function lwp_cal(id) {
            var lwp_val = $('#lwp_' + id).val();
            //var final_gross = $('#final_gross_' + id).val();
			var gross = $('#gross_' + id).val();
            $('#final_gross_' + id).val(parseInt(gross) - parseInt(lwp_val))
            var final_gross = 0;
            $('input[name="final_gross[]"]').each(function() {
                final_gross = parseInt(final_gross) + parseInt(this.value);
            })
            $('#tot_final_gross').text(final_gross)
            var tot_lwp = 0;
            $('input[name="lwp[]"]').each(function() {
                tot_lwp = parseInt(tot_lwp) + parseInt(this.value);
            })
            $('#tot_lwp').text(tot_lwp)
	    //$('#tot_final_gross').text(final_gross - tot_lwp)
        }
    </script>

    <script>
        $(document).ready(function() {
            var catg_id = <?= $selected['catg_id'] ?> > 0 ? <?= $selected['catg_id'] ?> : 0;
            if (catg_id > 0) {
                $('#sal_date').attr('readonly', 'readonly')
                <?php if (!isset($_REQUEST['submit'])) { ?>
                    $('#submit').click();
                <?php } ?>
            }
        })
    </script>

    