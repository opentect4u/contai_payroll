<table class="table" style="width:100%">
    <tr>
        <th>SL</td>
        <th>Emp Name</th>
        <th>Designation</th>
        <th>Basic</th>
        <th>Field/Others Allow</th>
        <th>DA</th>
        <th>CA</th>
        <th>HRA</th>
        <th>MA</th>
        <th>Rec Keep Allowance</th>
        <th>Gross</th>
        <th>Provident Fund</th>
        <th>IT</th>
        <th>HB Loan Prn.</th>
        <th>HB Loan Intt.</th>
        <th>Festival</th>
        <th>PC Loan Prn</th>
        <th>PC Loan Intt</th>
        <th>PF Arrear</th>
        <th>Association</th>
        <th>Total Deduction</th>
        <th>Net Pay</th>
    </tr>
    <tbody>
        <?php 
            $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
            $i=0;
            $basic_tot = $oth_tot = $da_tot = $ca_tot = $hra_tot = $ma_tot = $rec_tot = $pfd_tot = $it_tot = $fest_tot = $pf_tot = $asso_tot = $ded_tot = 0;
            foreach($emp_list as $elist) {
                $emp_tot_er  = 0; 
                $ded_tot = 0;
        ?>
        <tr>
            <td><?=++$i?></td>
            <td><?=$elist->emp_name?></td>
            <td><?=$elist->designation?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
            $basic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,303);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,303);
            $oth_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,303);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,305);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,305);
            $da_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,305);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,226);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,226);
            $ca_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,226);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,302);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,302);
            $hra_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,302);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,222);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,222);
            $ma_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,222);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,306);
            $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,306);
            $rec_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,306);
            ?></td>

            <td><?= $emp_tot_er;  $tot_earning +=$emp_tot_er; ?></td>

            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,307);
            $ded_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,307);
            $pfd_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,307);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,308);
            $ded_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,308);
            $it_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,308);
            ?></td>
            <td><?= 0 ?></td>
            <td><?= 0 ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,310);
            $ded_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,310);
            $fest_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,310);
            ?></td>
            <td><?= 0 ?></td>
            <td><?= 0 ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,309);
            $ded_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,309);
            $pf_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,309);
            ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,311);
            $ded_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,311);
            $asso_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,311);
            ?></td>
            <td><?= $ded_tot; $tot_dedu +=$ded_tot; ?></td>
            <td><?= $emp_tot_er-$ded_tot ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Total</td>
            <th></th>
            <th></th>
            <th><?=$basic_tot?></th>
            <th><?=$oth_tot?></th>
            <th><?=$da_tot?></th>
            <th><?=$ca_tot?></th>
            <th><?=$hra_tot?></th>
            <th><?=$ma_tot?></th>
            <th><?=$rec_tot?></th>
            <th><?=$tot_earning?></th>
            <th><?=$pfd_tot?></th>
            <th><?=$it_tot?></th>
            <th><?= 0 ?></th>
            <th><?= 0 ?></th>
            <th><?=$fest_tot?></th>
            <th><?= 0 ?></th>
            <th><?= 0 ?></th>
            <th><?=$pf_tot?></th>
            <th><?=$asso_tot?></th>
            <th><?=$tot_dedu?></th>
            <th><?= $tot_earning-$tot_dedu ?></th>
        </tr>
    </tfoot>
</table>