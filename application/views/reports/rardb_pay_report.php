<table class="table" style="width:100%">
    <tr>
        <th>SL</td>
        <th>Emp Name</th>
        <th>Designation</th>
        <th>Basic</th>
        <th>D.A.</th>
        <th>HRA</th>
        <th>M.A.</th>
        <th>Spl.Pay</th>
        <th>S.A.</th>
        <th>GROSS</th>
        <th>P.F.</th>
        <th>LIC</th>
        <th>I.T.</th>
        <th>P.T.</th>
        <th>F.A.</th>
        <th>L.W.P.</th>
    </tr>
    <tbody>
    <?php 
        $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
    
        $i=0;
        $basic_tot = 0;$da_tot = 0; $hra_tot = 0; $ma_tot = 0;
        $sa_tot = 0; $pf_tot = 0; $lic_tot = 0;$it_tot = 0;$pt_tot = 0;
        $fa_tot = 0;$lwp_tot = 0;
    
    foreach($emp_list as $elist) {
            $emp_tot_er  = 0; 
            $emp_tot_ded = 0; 
        ?>
    
    <tr>
        <td><?=++$i?></td>
        <td><?=$elist->emp_name?></td>
        <td><?=$elist->designation?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        $basic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        $da_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        $hra_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        $ma_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        ?></td>
        
        <td><?php //echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        // $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        $sa_tot  +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        ?></td>
        <td><?php echo $emp_tot_er;  $tot_earning +=$emp_tot_er; ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        $pf_tot += $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        $lic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        $it_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        $pt_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        $fa_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        $lwp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        ?></td>
    </tr>
    
    <?php 

        } ?>
    
    
        <tr>
        <th>Total</td>
        <th></th>
        <th></th>
        <th><?=$basic_tot?></th>
        <th><?=$da_tot?></th>
        <th><?=$hra_tot?></th>
        <th><?=$ma_tot?></th>
        <th></th>
        <th><?=$sa_tot?></th>
        <th><?=$tot_earning?></th>
        <th><?=$pf_tot?></th>
        <th><?=$lic_tot?></th>
        <th><?=$it_tot?></th>
        <th><?=$pt_tot?></th>
        <th><?=$fa_tot?></th>
        <th><?=$lwp_tot?></th>
    </tr>
    <tr>
        <th></td>
        <th></th>
        <th></th>
        <th>HBL <br> Loan</th>
        <th>Innt.On<br> HBL.Loan</th>
        <th>Emergency <br>Loan</th>
        <th>Innt.On<br> E.Loan</th>
        <th>P.loan</th>
        <th>Innt.On<br> P.Loan</th>
        <th>Net Salary</th>
        <th colspan="6">Signature of Payee</th>
    </tr>
    </tbody>
    <tbody>
    <?php 
        $tot_dedu = 0; $tot_earning = 0; $net_sal = 0;
    
        $i=0;
        $basic_tot = 0;$da_tot = 0; $hra_tot = 0; $ma_tot = 0;
        $sa_tot = 0;$lic_tot = 0;$it_tot = 0;$pt_tot = 0;
        $fa_tot = 0;$lwp_tot = 0;$hblp_tot =0;$hbli_tot=0;$el_tot=0;$eli_tot=0;$pl_tot=0;$pli_tot=0;
    foreach($emp_list as $elist) {
            $emp_tot_er  = 0; 
            $emp_tot_ded = 0; 
        ?>
        <tr style="display:none">
        <td></td>
        <td><?=$elist->emp_name?></td>
        <td><?=$elist->designation?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        $basic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        $da_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,104);
        ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        $hra_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,105);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        $ma_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,107);
        ?></td>
        
        <td><?php //echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        // $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,0);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        $emp_tot_er +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        $sa_tot  +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,108);
        ?></td>
        <td><?php echo $emp_tot_er;  $tot_earning +=$emp_tot_er; ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        $pt_tot += $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,201);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        $lic_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,206);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        $it_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,207);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        $pt_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,215);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        $fa_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,202);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        $lwp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,102);
        ?></td>
    </tr>
    <tr style="" class="btmborder">
        <td><?=++$i?></td>
        <td><?=$elist->emp_name?></td>
        <td><?=$elist->designation?></td>
        <td style="">
        <?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
        $hblp_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,209);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
        $hbli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,210);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
        $el_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,213);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
        $eli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,214);
        ?></td>
        <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
        $pl_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,211);
        ?></td>
            <td><?php echo $this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
        $emp_tot_ded +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
        $pli_tot +=$this->Report_Process->getempsalryd($elist->emp_code,$sal_month,$year,$bank_id,212);
        ?></td>
        <td><?php echo $emp_tot_er-$emp_tot_ded; $net_sal += $emp_tot_er-$emp_tot_ded; ?></td>
        <td colspan="6"></td>
    </tr>
    <?php 

        } ?>
    
    <!-- <tr>
        <th>Total</td>
        <th></th>
        <th></th>
        <th>HBL <br> Loan</th>
        <th>Innt.On<br> HBL.Loan</th>
        <th>Emergency <br>Loan</th>
        <th>Innt.On<br> E.Loan</th>
        <th>P.loan</th>
        <th>Innt.On<br> P.Loan</th>
        <th>Net Salary</th>
        <th colspan="3"></th>
    </tr> -->
    <tr>
        <th>Total</td>
        <th></th>
        <th></th>
        <th><?=$hblp_tot?></th>
        <th><?=$hbli_tot?></th>
        <th><?=$el_tot?></th>
        <th><?=$eli_tot?></th>
        <th><?=$pl_tot?></th>
        <th><?=$pli_tot?></th>
        <th><?=$net_sal?></th>
        <th colspan="6"></th>
    </tr>
    </tbody>
</table>