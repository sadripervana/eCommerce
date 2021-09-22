</div>
	</div>

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
		jQuery(window).scroll(function(){
			var vscroll = jQuery(this).scrollTop();
			jQuery('#logotext').css({
				"transform" : "translate(0px, "+vscroll/2+"px)"
			})

			var vscroll = jQuery(this).scrollTop();
			jQuery('#back-flower').css({
				"transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
			})

			var vscroll = jQuery(this).scrollTop();
			jQuery('#fore-flower').css({
				"transform" : "translate(0px, -"+vscroll/2+"px)"
			})
		});


		function detailsmodal(id){
	  	var data = {"id" : id};
	  	jQuery.ajax({
	  		url 	: 	'/PHPProjects/PHPeCommerce1/includes/detailsmodal.php',
	  		method 	: 	"post",
	  		data 	: 	data,
	  		success : 	function(data){
	  			jQuery('body').append(data);
	  			jQuery('#details-modal').modal('toggle');
	  		},
	  		error  	: 	function(){
	  			alert("Something went wrong!");
	  		}
	  	});
	  }

	</script>
</body>
</html>