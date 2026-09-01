<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-bottom:10px">
                    <div class="col-10">
                        <h3>Salary Approve</h3>
                    </div>
                    <div class="col-2"></div>
                    <span class="confirm-div" style="float:right; color:green;"></span>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="tbl" class="table stripe row-border order-column" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Category</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                     
                                        <th> Gross </th>
                                        <th> Deduction </th>
                                        <th>Total Net Amount</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($unapprove_tot_dtls) {
                                        foreach ($unapprove_tot_dtls as $d_dtls) {
                                    ?>
                                            <tr>
                                                <td data-sort="<?= strtotime($d_dtls->trans_date) ?>"><?= date('d.m.Y', strtotime($d_dtls->trans_date)); ?></td>
                                                <td><?= $d_dtls->category; ?></td>
                                                <td><?= date("F", mktime(0, 0, 0, $d_dtls->sal_month, 10)); ?></td>
                                                <td><?= $d_dtls->sal_year; ?></td>
                                               
                                                <td><?= $d_dtls->tot_earn; ?></td>
                                                <td><?= $d_dtls->tot_dedu; ?></td>
                                                <td><?= $d_dtls->tot_earn - $d_dtls->tot_dedu; ?></td>
                                                <?php if ($d_dtls->approval_status == 'U') { ?>
                                                <td>
                                                    <button class="btn btn-primary unapprove" id="<?= $d_dtls->trans_no; ?>" date="<?= $d_dtls->trans_date; ?>" catg="<?= $d_dtls->catg_cd; ?>" month="<?= $d_dtls->sal_month; ?>" year="<?= $d_dtls->sal_year; ?>" style="width: 100px;">Approve</button>
                                                </td>
                                                <?php } else if($d_dtls->approval_status == 'A') { ?>
                                                <td><button class="btn btn-success sms" id="<?= $d_dtls->bank_id; ?>" date="<?= $d_dtls->trans_date; ?>" style="width: 100px;">Send SMS</button></td>
                                                <?php } else { ?>
                                                <td align="left" style="color: green;">SMS Sent</td>
                                                <?php } ?>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            _datatable('Salary Status');
            $('.unapprove').click(function() {
                var approval = false,
                    id = $(this).attr('id'),
                    date = $(this).attr('date'),
                    catg = $(this).attr('catg'),
                    month = $(this).attr('month'),
                    year = $(this).attr('year');

                approval = confirm("Are you sure?");

                if (approval) {
                    window.location = "<?php echo site_url('approves/payapprove?trans_no="+id+"&trans_date="+date+"&catg_cd="+catg+"&month="+month+"&year="+year+"'); ?>";
                }
            });

            $('.sms').click(function() {
                var id = $(this).attr('id');
                var date = $(this).attr('date');
                var result = confirm("Do you really want to send sms?");
                if (result) {
                    window.location = "<?php echo site_url('payslip/sms/"+id+"/"+date+"'); ?>";
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('.confirm-div').hide();

            <?php if ($this->session->flashdata('msg')) { ?>

                $('.confirm-div').html('<?php echo $this->session->flashdata('msg'); ?>').show();

        });

        <?php } ?>
    </script>