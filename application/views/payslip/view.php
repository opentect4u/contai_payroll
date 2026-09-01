<?php 
$bank->address = str_replace("h5>", "p>", str_replace("h4>", "p>", $bank->address));
$src = base64_encode(file_get_contents(str_replace('\/', '/', base_url('assets/images/' . $bank->logo_path))));
$logo = 'data:image/png;base64,' . $src;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payslip</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" />
        <style>
        @media print {
            .row {
                display: block;
            }
            
            .col-6 {
                width: 50%;
                max-width: 50%;
                display: block;
                margin-bottom: 20px; /* Adds space between tables */
            }
            
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid #000; /* Add border for clarity */
                padding: 5px;
                
            }
            
            .t2 {
                font-weight: bold;
                background-color: #f0f0f0; /* Light background for table headers */
            }
        }
        th, td {
                padding: 5px;        
        }
        </style>    
    </head>
    <body>
        <div>
            <div class="row">
                <div class="sm-col-1 payslip_logo_Uts"><a href="javascript:void()"><img src="<?= $logo ?>" alt="logo" height="100" width="100" /></a></div>
                <div class="sm-col-11 payslip_logo_Desc_Uts">
                    <?php echo '<b>' . $bank->address . '</b>'; ?>
                    <h4>Pay Slip for <?php echo MONTHS[$month] . '-' . $year; ?></h4>
                </div>
            </div>                
            <div class="row" style="margin-bottom:10px">
                <div class="col-12">
                    <table  style="width:100%;">
                        <tbody>
                            <tr>
                                <td style="width:15%;">Name</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?php echo $emp->emp_name; ?></td>
                                <td style="width:15%;"> Code </td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td><?php if (strlen($emp->prefix_emp_cd) > 0) echo $emp->prefix_emp_cd; ?><?php echo $emp->emp_code; ?></td>
                            </tr>
                            <tr>
                                <td style="width:15%;">DoB</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?= (($emp->dob != "0000-00-00") && ($emp->dob != NULL)) ? date('d.m.Y', strtotime($emp->dob)) : ''; ?></td>
                                <td style="width:15%;">DoJ</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?= (($emp->join_dt != "0000-00-00") && ($emp->join_dt != NULL)) ? date('d.m.Y', strtotime($emp->join_dt)) : ''; ?></td>
                            </tr>
                            <tr>
                                <td style="width:15%;">Posting</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?php echo $emp->branch_name; ?></td>
                                <td style="width:15%;">A/C No. </td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td><?php echo $emp->bank_ac_no; ?></td>
                            </tr>
                            <tr>
                                <td style="width:15%;">Designation</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?php echo $emp->designation; ?></td>
                                <td style="width:15%;">Mobile</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td class="left_algn" style="width:33%;"><?php echo $emp->phn_no; ?></td>                                            
                            </tr>
                            <tr>
                                <td style="width:15%;">PAN</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td><?php echo $emp->pan_no; ?></td>
                                <td style="width:15%;">UAN</td>
                                <td class="left_algn" style="width:2%;">:</td>
                                <td><?php echo $emp->UAN; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>   
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-12">
                    <table  style="width:100%;">
                        <tbody>
                            <tr>
                                <td style="width:50%;">
                                    <table  style="width:100%;">
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>Earning</td>
                                                <td align="right">Amount</td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </td>
                                <td style="width:50%;">
                                    <table  style="width:100%;">
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>Deduction</td>
                                                <td align="right">Amount</td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%;">
                                    <table  style="width:100%;">                                       
                                    <tbody>
                                    <?php      
                                    $tot_earning = 0 ; $tot_deduction = 0;
                                        foreach($sal as $ekey) {
                                        if($ekey->pay_head_type == 'E') {
                                            $tot_earning += $ekey->amount;
                                        ?>
                                        <tr>
                                        <td class="left_algn"><?= $ekey->pay_head; ?></td>
                                        <td class="right_algn" align="right"><?= $ekey->amount; ?></td>
                                        </tr>
                                        <?php } 
                                        } ?>
                                    </tbody>
                                    </table>  
                                </td>
                                <td style="width:50%;">
                                    <table style="width:100%;">
                                    <tbody>
                                        <?php      
                                        foreach($sal as $ekey) {
                                            if($ekey->pay_head_type == 'D') {
                                            $tot_deduction += $ekey->amount;
                                    ?>
                                        <tr>
                                            <td class="left_algn"><?= $ekey->pay_head; ?></td>
                                            <td class="right_algn" align="right"><?= $ekey->amount; ?></td>
                                            
                                        </tr>
                                        <?php } 
                                        } ?>
                                    </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:50%;">
                                    <table  style="width:100%;">
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>Total</td>
                                                <td align="right"><?= sprintf("%.2f", $tot_earning); ?></td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </td>
                                <td style="width:50%;">
                                    <table  style="width:100%;">
                                        <tbody>
                                            <tr style="font-weight:bold">
                                                <td>Total</td>
                                                <td align="right"><?= sprintf("%.2f", $tot_deduction); ?></td>
                                            </tr>
                                            </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>   
            </div>
            <div class="row" style="margin-bottom:20px">
                <div class="col-12">
                    <br>
                        <b><p style="display: inline;">Net Salary: <?php echo sprintf("%.2f", $tot_earning-$tot_deduction) . ' (<i>' . getIndianCurrency($tot_earning-$tot_deduction) . '</i>)'; ?></p></b>
                        <p><b>Accumulated Income Tax: </b><?= $tds ?></p>
                </div>
            </div>
            <div class="row" style="margin-bottom:10px">
                <div class="col-12" style="text-align: center;">
                <br>
                <p style="display: inline;text-transform: uppercase; font-size: 10px;"><b><?= PAYSLIP_FOOTER ?></b></p>
                </div>
            </div>
        </div>
    </body>
</html>