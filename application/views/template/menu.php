<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Home</a>
  <ul>
    <li class="active"><a href="<?php echo site_url('home/index'); ?>"><i class="icon icon-home"></i> <span>Home</span></a></li>
    <li > <a href="<?php echo site_url('customer/find_customer');?>"><i class="icon icon-search"></i> <span>Find Customer</span> </a></li>
    <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'REQUESTER') !== false ): 
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-edit"></i> <span>Customer Request &raquo;</span> </a>
      <ul>
            <li><a href="<?php echo site_url('customer/form_cust');?>">New Customer</a></li>
            <li><a href="<?php echo site_url('customer/form_extend_cust');?>">Extend Customer</a></li>
            <li><a href="<?php echo site_url('customer/form_edit_cust_req1');?>">Change Customer</a></li>
            <li><a href="<?php echo site_url('customer/form_contact_person1');?>">Change Contact Person</a></li>
            <li><a href="<?php echo site_url('customer/form_upload');?>">Upload Customer</a></li>
      </ul>
    </li>
    <?php
      endif;
    ?>
     <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'REQUESTER') !== false ): 
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-list"></i> <span>List Customer Request &raquo;</span> </a>
      <ul>
            <li><a href="<?php echo site_url('customer/list_cust_req');?>">List New Customer</a></li>
            <li><a href="<?php echo site_url('customer/list_cust_extend');?>">List Extend Customer</a></li>
            <li><a href="<?php echo site_url('customer/list_cust_edit');?>">List Change Customer</a></li>
            <li><a href="<?php echo site_url('customer/list_cp_req');?>">List Change Contact Person</a></li>
      </ul>
    </li>
    <?php
      endif;
    ?>
    <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'APPROVAL') !== false): 
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-ok"></i> <span>Approval Accounting &raquo;</span> </a>
      <ul>
        <?php
          if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'APPROVAL') !== false ): 
        ?>
          <li><a href="<?php echo site_url('customer/list_cust_approval');?>">Approval New Customer</a></li>
          <li><a href="<?php echo site_url('customer/list_cust_approval_extend');?>">Approval Extend Customer</a></li>
          <li><a href="<?php echo site_url('customer/list_cust_approval_edit');?>">Approval Change Customer</a></li>
        <?php
          endif;
        ?>
         
      </ul>
    </li>
    <?php
      endif;
    ?>
    <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'MASTERDATA') !== false): 
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-forward"></i> <span>Transport SAP &raquo;</span> </a>
      <ul>
        
         <?php
          if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'MASTERDATA') !== false ): 
        ?>
          <li><a href="<?php echo site_url('customer/list_cust_is');?>">Transport New Customer</a></li>
          <li><a href="<?php echo site_url('customer/list_cust_is_extend');?>">Transport Extend Customer</a></li>
          <li><a href="<?php echo site_url('customer/list_cust_is_edit');?>">Transport Change Customer</a></li>
          <li><a href="<?php echo site_url('customer/list_cp_is');?>">Transport Contact Person</a></li>
          <?php
          endif;
        ?>
      </ul>
    </li>
    <?php
      endif;
    ?>
    <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false or strpos($this->session->userdata('role'),'MASTERDATA') !== false): 
    ?>
   <!-- <li > <a href="<?php echo site_url('customer/form_upload');?>"><i class="icon icon-upload"></i> <span>Upload</span> </a>
    </li>-->
    <?php
      endif;
    ?>
    <?php
      if(strpos($this->session->userdata('role'),'ADMINISTRATOR') !== false ): 
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-cog"></i> <span>Master &raquo;</span> </a>
      <ul>
          <!--<li><a href="<?php echo site_url('customer/master_level');?>">Level Approval</a></li>-->
          <li><a href="<?php echo site_url('customer/role_user');?>">User Role</a></li>
          <li><a href="<?php echo site_url('customer/user_privilege');?>">User Privilege</a></li>
          <li><a href="<?php echo site_url('customer/konfigurasi');?>">Company Conf.</a></li>
          <li><a href="<?php echo site_url('customer/email_setting');?>">Setting</a></li>
      </ul>
    </li>
    <?php
      endif;
    ?>
    <li class="submenu"> <a href="#"><i class="icon icon-book"></i> <span>History &raquo;</span> </a>
      <ul>
            <li><a href="<?php echo site_url('customer/cust_history');?>">New Customer</a></li>
            <li><a href="<?php echo site_url('customer/extend_history');?>">Extend Customer</a></li>
            <li><a href="<?php echo site_url('customer/edit_history');?>">Change Customer</a></li>
      </ul>
    </li>
    
   
   
   
    
    
    

    
  </ul>
</div>