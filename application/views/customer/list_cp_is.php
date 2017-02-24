<script type="text/javascript">


</script>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
        <a  href="#">Customer</a>
	<a class="current" href="#">List Contact Person Request (Transport)</a>
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
                      <th style="width:3%;">No.</th>
		      <th style="width:7%;">Date</th>
		      <th style="width:8%;">Requestor</th>
		      <th style="width:5%;">ID Request</th>
                      <th style="width:5%;">Type</th>
                      <th style="width:5%;">Cust. Account</th>
                      <th style="width:5%;">C.Person ID</th>
                      <th style="width:5%;">Title</th>
		      <th style="width:7%;">Firstname</th>
		      <th style="width:7%;">Lastname</th>
                      <th style="width:9%;">Status</th>
                      <th style="width:17%;">Action</th>
		  </tr>
		</thead>
		<tbody>
		    <?php
			$no=1;
			foreach($row as $a){
			    $urlTransport=base_url()."index.php/customer/form_transport_cp/".$a['ID_CP_EDIT'];
			    $urlEdit=base_url()."index.php/customer/form_edit_cp_edit/".$a['ID_CP_EDIT'];
			    $id_req=$a['ID_CP_EDIT'];
			    
			    echo "
				<tr>
				    <td>$no</td>
				    <td>".$a['DATE_CREATE']."</td>
				     <td>".$a['NAME_CREATE']."</td>
				    <td>".$a['ID_CP_EDIT']."</td>
                                    <td>".$a['JENIS']."</td>
				    <td>".$a['KUNNR']."</td>
				    <td>".$a['PARNR']."</td>
				    <td>".$a['TITLE_CP']."</td>
				    <td>".$a['FIRSTNAME_CP']."</td>
				    <td>".$a['NAME_CP']."</td>
				    <td>".$a['NEW_ST']."</td>";
			    echo "<td style='text-align: center;'>";
			    
                            echo "
                                <a class='btn btn-warning btn-mini' href='".$urlEdit."'>Edit</a>
                                <a class='btn btn-success btn-mini' href='".$urlTransport."'>Transport</a>
                                ";
			   
			     echo "</td>"; 
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
