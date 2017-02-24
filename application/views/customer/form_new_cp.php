<script type="text/javascript">

</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb">
        <a href="<?php echo site_url('home/index'); ?>" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a>
         <a  href="#">Change Contact Person</a>
	<a class="current" href="#">Form Change Contact Person (New)</a>
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
        <div class="span12"> 
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="icon-tasks"></i></span>
                <h5>Form Change Contact Person</h5>
                <div class="buttons"></div>
            </div>

            <div class="widget-content nopadding">
	    
                <form class="form-horizontal" method="post" action="<?php echo site_url('customer/save_new_cp'); ?>" name="basic_validate" id="basic_validate" novalidate="novalidate">
                    <div class="control-group">
                        <label class="control-label"><b>Cust. Account</b></label>
                        <div class="controls">
                            <input  type="text" class="span2" readonly="readonly" name="cust_account" id="cust_account" value="<?php echo $kunnr; ?>">
                        </div>
                    </div>
                    <!--<div class="control-group">
                        <label class="control-label"><b>C. Person Number</b></label>
                        <div class="controls">
                            <input  type="text" class="span2" readonly="readonly" name="parnr" id="parnr" value="">
                        </div>
                    </div>-->
                    <div class="control-group">
                        <label class="control-label"><b>Title * | Name</b></label>
                        <div class="controls">
                            <select name="title_cp" id="title_cp" class="span4" placeholder="Title" >
                              <option></option>
                              <option value='Company'>Company</option>
                              <option value='Mr.'>Mr.</option>
                              <option value='Ms.'>Ms.</option>
                              <option value='Mr. and Ms. '>Mr. and Mrs.</option>
                            </select>
                            <input style="margin-left:4px;" type="text" class="span4" maxlength="35" name="firstname_cp" id="firstname_cp" placeholder="First Name">
                              <input  type="text" class="span4" name="xname_cp" id="xname_cp" maxlength="35" placeholder="Name">
                              <br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Gender</b></label>
                        <div class="controls">
                            <select name="gender" id="gender" class="span3" placeholder="Gender">
                              <option ></option>
                              <option value="1">1 - Male</option>
                              <option value="2">2 - Female</option>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Date of Birth</b></label>
                        <div class="controls">
                            <input type="text" data-date="01-02-2013" name="tgl_lahir" id="tgl_lahir" data-date-format="dd-mm-yyyy" class="datepicker" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Telp | Ext</b></label>
                        <div class="controls">
                            <input type="text" class="span4" name="tlp_cp" id="tlp_cp" placeholder="Telp" maxlength="16">
                            <input type="text" class="span2" name="ext_cp" id="ext_cp" placeholder="Ext." maxlength="4">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Mobile Phone</b></label>
                        <div class="controls">
                            <input type="text" class="span4" name="hp_cp" id="hp_cp" maxlength="16">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Fax | Email</b></label>
                        <div class="controls">
                            <input type="text" class="span4" name="fax_cp" id="fax_cp" placeholder="Fax" maxlength="16">
                            <input type="text" class="span4" name="email_cp" id="email_cp" placeholder="Email" maxlength="30">
                        </div>
                    </div>
                    
                    <div class="control-group">
                        <label class="control-label"><b>Call Frequency</b></label>
                        <div class="controls">
                            <select name="call_frequency" id="call_frequency" class="span4" placeholder="Call Frequency">
                              <option ></option>
                              <?php
                                foreach($call_frequency as $key11 => $cfr){
                                   if($key8 == 0 and !isset($cfr['BRYTH'])){
                                      continue;}
                                    if($cfr['BRYTH'] > 2000){
                                      echo "<option value='".$cfr['BRYTH']."'>".$cfr['BRYTH']." - ".$cfr['VTEXT']."</option>";

                                    }
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Register Date</b></label>
                        <div class="controls">
                            <input type="text" data-date="01-02-2013" name="tgl_register" id="tgl_register" data-date-format="dd-mm-yyyy" class="datepicker" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Departement</b></label>
                        <div class="controls">
                            <select name="departemen" id="departemen" class="span4" placeholder="Departement">
                              <option ></option>
                              <?php
                                foreach($departemen as $key8 => $dep){
                                   if($key8 == 0 and !isset($dep['ABTNR'])){
                                      continue;}
                                    echo "<option value='".$dep['ABTNR']."'>".$dep['ABTNR']." - ".$dep['VTEXT']."</option>";
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><b>Function</b></label>
                        <div class="controls">
                            <select name="function" id="function" class="span4" placeholder="Function">
                              <option ></option>
                              <?php
                                foreach($function as $key9 => $f){
                                  if($key9 == 0 and !isset($f['PAFKT'])){
                                      continue;}
                                    echo "<option value='".$f['PAFKT']."'>".$f['PAFKT']." - ".$f['VTEXT']."</option>";
                                }
                              ?>
                            </select><br/><br/>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" id="btnApprove" value="Save" class="btn btn-success">
                    </div>
                </form>
	</div>
        </div>
      </div>
    
    </div>
    
  </div>
</div>

