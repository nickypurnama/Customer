<!--Header-part-->
<div id="header">
  <h1 style="width: 300px;"><a href="#">Sistem Informasi Penjualan & Pembelian</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-messaages-->
<div class="btn-group rightzero"> <a class="top_message tip-left" title="Manage Files"><i class="icon-file"></i></a> <a class="top_message tip-bottom" title="Manage Users"><i class="icon-user"></i></a> <a class="top_message tip-bottom" title="Manage Comments"><i class="icon-comment"></i><span class="label label-important">5</span></a> <a class="top_message tip-bottom" title="Manage Orders"><i class="icon-shopping-cart"></i></a> </div>
<!--close-top-Header-messaages--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li class=" dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-user"></i> <span class="text"><?php echo $this->session->userdata('NIK'); ?></span> <b class="caret"></b></a>
      <!--<ul class="dropdown-menu">
        <li><a class="sAdd" title="" href="<?php echo site_url('home/ubah_password'); ?>">Ubah Password</a></li>
      </ul>-->
    </li>
    <li class=""><a title="" href="<?php echo site_url('home/logout'); ?>"><i class="icon icon-share-alt"></i> <span class="text">Logout</span></a></li>
  </ul>
</div>
<!--close-top-Header-menu-->