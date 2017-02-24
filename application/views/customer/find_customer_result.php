<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="<?php echo site_url('customer/find_customer'); ?>">Find Customer</a>
	<a class="current" href="#">Result</a>
    </div>
  </div>
  
  <div class="container-fluid">
    <div class="row-fluid">
    <div class="span12">
        
        <?php
            $msg=$this->session->flashdata('msg');
            echo $msg;
	?>
    </div>
    </div>
   
    <br/>
    <div class="row-fluid">
    <div class="span12">
	<div class="widget-box " style="margin-top: -30px;">
	    <div class="widget-content nopadding">
	      <table  class="table table-bordered data-table">
		<thead>
		  <tr>
                      <th style="width:4%;">No.</th>
		      <th >Customer Account</th>
                      <th >Name</th>
		      <th >Company Code</th>
                      <th >Sales Org.</th>
		      <th >Dis. Channel</th>
		      <th >Division</th>
                      <th>Detail</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
                        $no=1;
			foreach($knvv as $a){
                            
                            $kunnr=$a['KUNNR'];
                            $sales_org=$a['VKORG'];
                            $dis_channel=$a['VTWEG'];
                            $division=$a['SPART'];
                            $urlDetail=base_url()."index.php/customer/view_cust_search/".$kunnr."/".$sales_org."/".$dis_channel."/".$division;
                            echo "<tr>
                                <td>$no</td>
                                <td>$kunnr</td>";
                            foreach($kna1 as $b){
                                $name=$b['NAME1'];
                                if($kunnr == $b['KUNNR']){
                                    echo "<td>$name</td>";
                                }
                            }
                            echo "<td>$sales_org</td>";
                            echo "<td>$sales_org</td>";
                            echo "<td>$dis_channel</td>";
                            echo "<td>$division</td>";
                             echo "<td style='text-align:center;'><a href='".$urlDetail."' class='btn btn-mini btn-success'>Detail</a></td>";
                            echo "</tr>";
                            $no++;
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
