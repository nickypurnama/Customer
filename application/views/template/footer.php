<div class="row-fluid">
      <div id="footer" class="span12"> 2014 &copy;  Author :  IS Department</div>
    </div>

<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.flot.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.flot.resize.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.peity.min.js"></script> 
<script src="<?php echo base_url(); ?>js/jquery.uniform.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>js/dataTables.fnGetHiddenNodes.js"></script>
<script src="<?php echo base_url(); ?>js/allert/jquery.alerts.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>js/maruti.form_validation.js"></script>
<script src="<?php echo base_url(); ?>js/maruti.js"></script> 
<script src="<?php echo base_url(); ?>js/maruti.tables.js"></script>
<script src="<?php echo base_url(); ?>js/maruti.form_common.js"></script>


<script type="text/javascript">
      $(document).ready(function() {
            $('.data-table2').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"sDom": '<""l>t<"F"fp><"F"i>'
		//"sDom": '<"F"f>t<"F"pl>'
            });
            //var oTable = $('.data-table2').dataTable();
            //
            //$('#basic_validate').submit(function(){
            //       $(oTable.fnGetHiddenNodes()).find('input:checked').appendTo(this).hide();
            // });
            $('.data-table5').dataTable({
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		//"sDom": '<""l>t<"F"fp><"F"i>'
		"sDom": '<"F"f>t<"F"p>i',
		"iDisplayLength": 5000,
		"aLengthMenu": [[5000, 6000, 7000, -1], [5000, 6000, 7000, "All"]]
	    });
	    var oTable = $('.data-table5').dataTable();
            
            $('#basic_validate').submit(function(){
                   $(oTable.fnGetHiddenNodes()).find('input:checked').appendTo(this).hide();
             });
	    
            $(".fancybox").fancybox({
                maxWidth    : 990,
                height      : 400,
                autoSize    : false,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none',
                    'afterClose':function () {
                        window.location.reload();
                    },
            });
	    
	    $(".fancybox2").fancybox({
                maxWidth    : 990,
                height      : 400,
                autoSize    : false,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none',
                    'afterClose':function () {
                        //window.location.reload();
                    },
            });      
      });
</script>
</body>

</html>