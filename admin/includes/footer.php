</div><br><br>

	<footer class="text-center" id="footer">
		<h4>© 2021 Web App from SADRI PERVANA 
        <a href="https://github.com/sadripervana" target="_blank"> 
          <i class="fab fa-github"></i>
        </a>
        <a href="https://www.linkedin.com/in/sadri-pervana-b76a3421a/" target="_blank"> 
          <i class="fab fa-linkedin"></i>
        </a>
        <a href="https://wa.me/+355685101074" target="_blank"> 
          <i class="fab fa-whatsapp"></i>
        </a> 
       </h4>
	</footer>

  <script>
    function updateSizes(){
      var sizeString = '';
      for(var i = 1; i <= 12; i++){
        if(jQuery('#size'+i).val() !='') {
          sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
        }
      }
      jQuery('#sizes').val(sizeString);
    }

    // function get_child_options(){
    //   var parentID = jQuery('#parent').val();
    //     jQuery.ajax({
    //       url: '/PHPProjects/PHPeCommerce1/admin/parsers/child_categories.php',
    //       type: 'POST',
    //       data: {parentID :parentID},
    //       success: function(data){
    //         jQuery('#child').html(data);
    //       },
    //       error: function(){alert("Something went wrong with the child options.");}

    //     })
    // }
    // jQuery('select[name="parent"]').change(get_child_options);



    function get_child_options(selected){
    if(typeof selected === 'undefined'){
      var selected = '';
    }
    var parentID = jQuery('#parent').val();
    jQuery.ajax({
      url:  '/PHPProjects/PHPeCommerce1/admin/parsers/child_categories.php',
      type: 'POST',
      data: {parentID : parentID, selected : selected},
      success: function(data){
        jQuery('#child').html(data)
      },
      error: function(){alert("Something went wrong with the child options.")},
    });
  }
  jQuery('select[name="parent"]').change(function(){
    get_child_options();
  });
  </script>

</body>
</html>