<style>
    .table td .form-group {
        width: 165px;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper content_wrapper_custom">
        <div class="card">
            <div class="card-body">
                <h3>Add Deductions</h3>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" id="form" action="<?php echo site_url("slrydedad"); ?>?catg_id=<?= $selected['catg_id'] ?>&sys_dt=<?= $selected['sal_date'] ?>&flag=<?= $selected['sal_flag'] ?>">
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
                    <h3>Add Deductions</h3>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body card_bodyCustom">
                                    <form method="POST" id="form" action="<?php echo site_url("slrydedsv"); ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive" id='permanent'>

                                                    <table class="table table-bordered">
                                                        <thead class="fixedHeaderTable">
                                                            <tr>
                                                                <th>Employee</th>
                                                                <th>GROSS SALARY (after deduction)</th>
                                                                <th>Income Tax</th>
                                                                <th>Contributory P.F.</th>
                                                                <th>GPF of<br>GOVT Staff</th>
                                                                <th>GISS</th>
                                                                <th>Lic Prem</th>
                                                                <th>OTH DED.</th>
                                                                <th>SSL LOAN PRIN</th>
                                                                <th>SSL LOAN INTT</th>
                                                                <th>PTAX</th>
                                                                <th>SWL Loan Prin.</th>
                                                                <th>SWL Loan Int.</th>
                                                                <th>Salary Adv.</th>
                                                                <th>Total Deduction</th>
                                                                <th style="display: none;">NET SALARY</th>
                                                            </tr>

                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $tot_it = 0;
                                                            $tot_cpf = 0;
                                                            $tot_gpf = 0;
                                                            $tot_gigs = 0;
                                                            $tot_lpf = 0;
                                                            $tot_fa = 0;
                                                            $tot_gi = 0;
                                                            $tot_top = 0;
                                                            $tot_eccs = 0;
                                                            $tot_hblp = 0;
                                                            $tot_hbli = 0;
                                                            $tot_s_adv = 0;
                                                            $tot_tot_diduction = 0;
                                                            $tot_net_sal = 0;
                                                            if ($sal_list) {
                                                                $i = 0;
                                                                foreach ($sal_list as $sal) {
                                                                    if ($sal['gross'] > 0) {
                                                                        $tot_it += $sal['it'];
                                                                        $tot_cpf += $sal['cpf'];
                                                                        $tot_gpf += $sal['gpf'];
                                                                        $tot_gigs += $sal['gigs'];
                                                                        $tot_lpf += $sal['lpf'];
                                                                        $tot_fa += $sal['fa'];
                                                                        $tot_gi += $sal['gi'];
                                                                        $tot_top += $sal['top'];
                                                                        $tot_eccs += $sal['eccs'];
                                                                        $tot_hblp += $sal['hblp'];
                                                                        $tot_hbli += $sal['hbli'];
                                                                        $tot_s_adv += $sal['s_adv'];
                                                                        $tot_tot_diduction += $sal['tot_diduction'];
                                                                        $tot_net_sal += $sal['net_sal'];
                                                                    }
                                                                    if ($sal['gross'] == 'Fill Income First') {
                                                                        $disabled = 'disabled';
                                                                    } ?>
                                                                    <tr>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="emp_name[]" id="emp_name_<?= $i ?>" value="<?= $sal['emp_name']; ?>" readonly />
                                                                                <input type="hidden" name="emp_code[]" id="emp_code_<?= $i ?>" value="<?= $sal['emp_code'] ?>">
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gross[]" id="gross_<?= $i ?>" value="<?= $sal['gross']; ?>" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="it[]" id="it_<?= $i ?>" value="<?= $sal['it']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="cpf[]" id="cpf_<?= $i ?>" value="<?= $sal['cpf']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gpf[]" id="gpf_<?= $i ?>" value="<?= $sal['gpf']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gigs[]" id="gigs_<?= $i ?>" value="<?= $sal['gigs']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="lpf[]" id="lpf_<?= $i ?>" value="<?= $sal['lpf']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="fa[]" id="fa_<?= $i ?>" value="<?= $sal['fa']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="gi[]" id="gi_<?= $i ?>" value="<?= $sal['gi']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="eccs[]" id="eccs_<?= $i ?>" value="<?= $sal['eccs']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="top[]" id="top_<?= $i ?>" value="<?= $sal['top']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly />
                                                                            </div>
                                                                        </td>
                                                                        
                                                                        <td <?= $display ?>>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hblp[]" id="hblp_<?= $i ?>" value="<?= $sal['hblp']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="hbli[]" id="hbli_<?= $i ?>" value="<?= $sal['hbli']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="s_adv[]" id="sa_<?= $i ?>" value="<?= $sal['s_adv']; ?>" onchange="cal_deduction(<?= $i ?>)" />
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="tot_diduction[]" id="tot_diduction_<?= $i ?>" value="<?= $sal['tot_diduction']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly/>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="net_sal[]" id="net_sal_<?= $i ?>" value="<?= $sal['net_sal']; ?>" onchange="cal_deduction(<?= $i ?>)" readonly />
                                                                            </div>
                                                                        </td>

                                                                    </tr>
                                                            <?php $i++;
                                                                }
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td colspan="2">TOTAL: </td>
                                                                <td><span id="tot_it"><?= $tot_it ?></span></td>
                                                                <td><span id="tot_cpf"><?= $tot_cpf ?></span></td>
                                                                <td><span id="tot_gpf"><?= $tot_gpf ?></span></td>
                                                                <td><span id="tot_gigs"><?= $tot_gigs ?></span></td>
                                                                <td><span id="tot_lpf"><?= $tot_lpf ?></span></td>
                                                                <td><span id="tot_fa"><?= $tot_fa ?></span></td>
                                                                <td><span id="tot_gi"><?= $tot_gi ?></span></td>
                                                                <td><span id="tot_eccs"><?= $tot_eccs ?></span></td>
                                                                <td><span id="tot_top"><?= $tot_top ?></span></td>
                                                               
                                                                <td><span id="tot_hblp"><?= $tot_hblp ?></span></td>
                                                                <td><span id="tot_hbli"><?= $tot_hbli ?></span></td>
                                                                <td><span id="tot_s_adv"><?= $tot_s_adv ?></span></td>
                                                                <td><span id="tot_tot_diduction"><?= $tot_tot_diduction ?></span></td>
                                                                <td><span id="tot_net_sal"><?= $tot_net_sal ?></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="sal_date" value="<?= $selected['sal_date']; ?>">
                                        <input type="hidden" name="catg_id" value="<?= $selected['catg_id']; ?>">
                                        <input type="hidden" name="flag" value="<?= $selected['sal_flag']; ?>">
                                        <div class="mt-3">
                                            <button type="submit" class="btn btn-primary mr-2" <?= $disabled ?>>Submit</button>
                                            <a href="<?= site_url() ?>/slryded" class="btn btn-light">Back</a>
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
                    url: "<?= site_url() ?>/salary/chk_deduction",
                    data: {
                        "sal_date": sal_date,
                        "catg_id": catg_id
                    },
                    dataType: 'html',
                    success: function(result) {
                        if (result) {
                            alert("You have already entered this month's deduction");
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
                url: "<?= site_url() ?>/salary/chk_deduction",
                data: {
                    "sal_date": sal_date,
                    "catg_id": catg_id
                },
                dataType: 'html',
                success: function(result) {
                    if (result) {
                        alert("You have already entered this month's deduction");
                        $('#submit').attr('disabled', 'disabled')
                    } else {
                        $('#submit').removeAttr('disabled')
                    }
                }
            });
        })
    </script>

    <script>
        function cal_deduction(id) {
            var gross = $('#gross_' + id).val() > 0 ? $('#gross_' + id).val() : 0;
            var it = $('#it_' + id).val() > 0 ? $('#it_' + id).val() : 0;
            var cpf = $('#cpf_' + id).val() > 0 ? $('#cpf_' + id).val() : 0;
            var gpf = $('#gpf_' + id).val() > 0 ? $('#gpf_' + id).val() : 0;
            var gigs = $('#gigs_' + id).val() > 0 ? $('#gigs_' + id).val() : 0;
            var lpf = $('#lpf_' + id).val() > 0 ? $('#lpf_' + id).val() : 0;
            var fa = $('#fa_' + id).val() > 0 ? $('#fa_' + id).val() : 0;
            var gi = $('#gi_' + id).val() > 0 ? $('#gi_' + id).val() : 0;
            var top = $('#top_' + id).val() > 0 ? $('#top_' + id).val() : 0;
            var eccs = $('#eccs_' + id).val() > 0 ? $('#eccs_' + id).val() : 0;
            var hblp = $('#hblp_' + id).val() > 0 ? $('#hblp_' + id).val() : 0;
            var hbli = $('#hbli_' + id).val() > 0 ? $('#hbli_' + id).val() : 0;
            var s_adv = $('#s_adv_' + id).val() > 0 ? $('#s_adv_' + id).val() : 0;
            
            var tot_diduction = $('#tot_diduction_' + id).val();
            var net_sal = $('#net_sal_' + id).val();
            var total_did = parseInt(it) + parseInt(cpf) + parseInt(gpf) + parseInt(gigs) + parseInt(lpf) + parseInt(fa) + parseInt(gi) + parseInt(top) + parseInt(eccs) + parseInt(hblp) + parseInt(hbli) + parseInt(s_adv)

            // var tot_gross_int = parseInt(gpf) + parseInt(lpf) + parseInt(gi)
            // $('#top_' + id).val(tot_gross_int)

            $('#tot_diduction_' + id).val(total_did)

            var diduction = parseInt(gross) - parseInt(total_did)
            $('#net_sal_' + id).val(diduction);
            cal_tot_amt();
        }

        function cal_tot_amt() {
            var tot_it = 0;
            var tot_cpf = 0;
            var tot_gpf = 0;
            var tot_gigs = 0;
            var tot_lpf = 0;
            var tot_fa = 0;
            var tot_gi = 0;
            var tot_top = 0;
            var tot_eccs = 0;
            var tot_hblp = 0;
            var tot_hbli = 0;
            var tot_s_adv = 0;
            var tot_tot_diduction = 0;
            var tot_net_sal = 0;

            $('input[name="it[]"]').each(function() {
                tot_it = parseInt(tot_it) + parseInt(this.value)
            });
            $('input[name="cpf[]"]').each(function() {
                tot_cpf = parseInt(tot_cpf) + parseInt(this.value)
            });
            $('input[name="gpf[]"]').each(function() {
                tot_gpf = parseInt(tot_gpf) + parseInt(this.value)
            });
            $('input[name="gigs[]"]').each(function() {
                tot_gigs = parseInt(tot_gigs) + parseInt(this.value)
            });
            $('input[name="lpf[]"]').each(function() {
                tot_lpf = parseInt(tot_lpf) + parseInt(this.value)
            });
            $('input[name="fa[]"]').each(function() {
                tot_fa = parseInt(tot_fa) + parseInt(this.value)
            });
            $('input[name="gi[]"]').each(function() {
                tot_gi = parseInt(tot_gi) + parseInt(this.value)
            });
            $('input[name="top[]"]').each(function() {
                tot_top = parseInt(tot_top) + parseInt(this.value)
            });
            $('input[name="eccs[]"]').each(function() {
                tot_eccs = parseInt(tot_eccs) + parseInt(this.value)
            });
            $('input[name="hblp[]"]').each(function() {
                tot_hblp = parseInt(tot_hblp) + parseInt(this.value)
            });
            $('input[name="hbli[]"]').each(function() {
                tot_hbli = parseInt(tot_hbli) + parseInt(this.value)
            });
            $('input[name="s_adv[]"]').each(function() {
                tot_s_adv = parseInt(tot_s_adv) + parseInt(this.value)
            });
            
            $('input[name="tot_diduction[]"]').each(function() {
                tot_tot_diduction = parseInt(tot_tot_diduction) + parseInt(this.value)
            });
            $('input[name="net_sal[]"]').each(function() {
                tot_net_sal = parseInt(tot_net_sal) + parseInt(this.value)
            });
            $('#tot_it').text(tot_it);
            $('#tot_cpf').text(tot_cpf);
            $('#tot_gpf').text(tot_gpf);
            $('#tot_gigs').text(tot_gigs);
            $('#tot_lpf').text(tot_lpf);
            $('#tot_fa').text(tot_fa);
            $('#tot_gi').text(tot_gi);
            $('#tot_top').text(tot_top);
            $('#tot_eccs').text(tot_eccs);
            $('#tot_hblp').text(tot_hblp);
            $('#tot_hbli').text(tot_hbli);
            $('#tot_s_adv').text(tot_s_adv);
            $('#tot_tot_diduction').text(tot_tot_diduction);
            $('#tot_net_sal').text(tot_net_sal);
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