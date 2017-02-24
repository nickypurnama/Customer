<script type="text/javascript">
function hapus(id){
	//alert(id);
    jConfirm("Do you want delete level approval?", "VI|VE|RE", function(r) {
	if(r == true){
	    $.ajax({
		type: 'POST', 
		url: "<?php echo site_url('customer/hapus_level'); ?>",
		data: "id="+id,
		cache: false,
		success: function(msg){
		    document.location='<?php echo site_url('customer/master_level'); ?>';
		}
	    });	
	}
    });

}
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Change Contact Person</a>
	<a class="current" href="#">Form Change Contact Person (Edit)</a>
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
    <div class="row-fluid">
        <div class="span6"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Detail Change Contact Person</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_edit_change_cp'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                     <div class="control-group">
                        <label class="control-label"><b>Type</b></label>
                        <div class="controls">
                            <input  type="text"  class="span10" readonly="readonly"  value="<?php echo $jenis; ?>">
                        </div>
                    </div>
		    <div class="control-group">
                        <label class="control-label"><b>Cust. Account</b></label>
                        <div class="controls">
                            <input  type="text"  class="span10" readonly="readonly" name="cust_account" id="cust_account" value="<?php echo $kunnr; ?>">
                            <input type="hidden" name="id_cp" id="id_cp" value="<?php echo $id_cp_edit; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>C. Person Number</b></label>
                        <div class="controls">
                            <input  type="text" class="span10" readonly="readonly" name="parnr" id="parnr" value="<?php echo $parnr; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Title * | Name</b></label>
                        <div class="controls">
                            <select name="title_cp" id="title_cp" readonly="readonly"  class="span4" placeholder="Title" >
                                <option></option>
                                <?php
                                    if($title == "Company"){
                                        echo "<option selected='selected' value='Company'>Company</option>
                                            <option value='Mr.'>Mr.</option>
                                            <option value='Ms.'>Ms.</option>
                                            <option value='Mr. and Ms. '>Mr. and Mrs.</option>";
                                    }elseif($title == "Mr."){
                                        echo "<option value='Company'>Company</option>
                                            <option  selected='selected' value='Mr.'>Mr.</option>
                                            <option value='Ms.'>Ms.</option>
                                            <option value='Mr. and Ms. '>Mr. and Mrs.</option>";
                                    }elseif($title == "Ms."){
                                        echo "<option value='Company'>Company</option>
                                            <option   value='Mr.'>Mr.</option>
                                            <option selected='selected' value='Ms.'>Ms.</option>
                                            <option value='Mr. and Ms. '>Mr. and Mrs.</option>";
                                    }elseif($title == "Mr. and Ms. "){
                                        echo "<option value='Company'>Company</option>
                                            <option value='Mr.'>Mr.</option>
                                            <option  value='Ms.'>Ms.</option>
                                            <option selected='selected' value='Mr. and Ms. '>Mr. and Mrs.</option>";
                                    }else{
                                        echo "<option value='Company'>Company</option>
                                            <option value='Mr.'>Mr.</option>
                                            <option value='Ms.'>Ms.</option>
                                            <option  value='Mr. and Ms. '>Mr. and Mrs.</option>";
                                    }
                                ?>
                              
                            </select>
                            <input style="margin-left:4px;" readonly="readonly" type="text" class="span4" maxlength="35" name="firstname_cp" id="firstname_cp" placeholder="First Name" value="<?php echo $firstname; ?>">
                              <input  type="text" class="span4" readonly="readonly" name="name_cp" id="name_cp" maxlength="35" placeholder="Name" value="<?php echo $lastname; ?>">
                              <br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Gender</b></label>
                        <div class="controls">
                            <select name="gender" id="gender" readonly="readonly" class="span3" placeholder="Gender">
                              <option ></option>
                              <?php
                                    if($gender == "1"){
                                        echo '<option selected="selected" value="1">1 - Male</option>
                                                <option value="2">2 - Female</option>';
                                    }elseif($gender == "2"){
                                        echo '<option value="1">1 - Male</option>
                                                <option selected="selected"  value="2">2 - Female</option>';
                                    }else{
                                        echo '<option value="1">1 - Male</option>
                                                <option  value="2">2 - Female</option>';
                                    }
                              ?>
                              
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Date of Birth</b></label>
                        <div class="controls">
                            
                            <input type="text" readonly="readonly"  value="<?php echo $tgl_lahir; ?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Telp | Ext</b></label>
                        <div class="controls">
                            <input type="text" class="span4" readonly="readonly" name="tlp_cp" id="tlp_cp" placeholder="Telp" maxlength="16" value="<?php echo $tlp; ?>">
                            <input type="text" class="span2" readonly="readonly" name="ext_cp" id="ext_cp" placeholder="Ext." maxlength="4" value="<?php echo $ext; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Mobile Phone</b></label>
                        <div class="controls">
                            <input type="text" class="span4" readonly="readonly" name="hp_cp" id="hp_cp" maxlength="16" value="<?php echo $hp; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Fax | Email</b></label>
                        <div class="controls">
                            <input type="text" class="span4" readonly="readonly" name="fax_cp" id="fax_cp" placeholder="Fax" maxlength="16" value="<?php echo $fax; ?>">
                            <input type="text" class="span7" readonly="readonly" name="email_cp" id="email_cp" placeholder="Email" maxlength="30" value="<?php echo $email; ?>">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><b>Call Frequency</b></label>
                        <div class="controls">
                            <select name="call_frequency" readonly="readonly" id="call_frequency" class="span4" placeholder="Call Frequency" >
                              <option value="-">-</option>
                              <?php
                                foreach($call_frequency as $key11 => $cfr){
                                   if($key8 == 0 and !isset($cfr['BRYTH'])){
                                      continue;}
                                    if($cfr['BRYTH'] > 2000){
                                        if($call_freq == $cfr['BRYTH']){
                                            echo "<option selected='selected' value='".$cfr['BRYTH']."'>".$cfr['BRYTH']." - ".$cfr['VTEXT']."</option>";
                                        }else{
                                            echo "<option value='".$cfr['BRYTH']."'>".$cfr['BRYTH']." - ".$cfr['VTEXT']."</option>";
                                        }
                                      

                                    }
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Register Date</b></label>
                        <div class="controls">
                            <input type="text" readonly="readonly" value="<?php echo $tgl_register; ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Departement</b></label>
                        <div class="controls">
                            <select name="departemen" readonly="readonly" id="departemen" class="span7" placeholder="Departement">
                              <option value="-">-</option>
                              <?php
                                foreach($departemen as $key8 => $dep){
                                   if($key8 == 0 and !isset($dep['ABTNR'])){
                                      continue;}
                                    if($xdepartemen == $dep['ABTNR']){
                                         echo "<option selected='selected' value='".$dep['ABTNR']."'>".$dep['ABTNR']." - ".$dep['VTEXT']."</option>";
                                    }else{
                                         echo "<option value='".$dep['ABTNR']."'>".$dep['ABTNR']." - ".$dep['VTEXT']."</option>";
                                    }
                                   
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Function</b></label>
                        <div class="controls">
                            <select name="function" readonly="readonly" id="function" class="span7" placeholder="Function">
                              <option value="-">-</option>
                              <?php
                                foreach($function as $key9 => $f){
                                  if($key9 == 0 and !isset($f['PAFKT'])){
                                      continue;}
                                    if($xfunction == $f['PAFKT']){
                                         echo "<option selected='selected' value='".$f['PAFKT']."'>".$f['PAFKT']." - ".$f['VTEXT']."</option>";
                                    }else{
                                         echo "<option value='".$f['PAFKT']."'>".$f['PAFKT']." - ".$f['VTEXT']."</option>";
                                    }
                                   
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    
                </form>
	</div>
        </div>
      </div>
        <div class="span6">
            <div class="widget-box">
                <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>History</h5>
                <div class="buttons"></div>
            </div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td style="width: 30%;"><b>Status</b></td>
                            <td><?php echo $new_st; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>User Request</b></td>
                            <td><?php echo $nik_create; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date Request</b></td>
                            <td><?php echo $tgl_create; ?></td>
                        </tr>
			 <tr>
                            <td style="width: 30%;"><b>Last Modified</b></td>
                            <td><?php echo $tgl_modif; ?></td>
                        </tr>
			  <tr>
                            <td style="width: 30%;"><b>Last Modified By</b></td>
                            <td><?php echo $nik_modif; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>Date Posting</b></td>
                            <td><?php echo $date_posting; ?></td>
                        </tr>
                       
                        <tr>
                            <td style="width: 30%;"><b>Date IS Approval</b></td>
                            <td><?php echo $date_is; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30%;"><b>User IS Approval</b></td>
                            <td><?php echo $nik_is; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
            
        </div>
    </div>
    
  </div>
</div>

