<div id='error' class="position-fixed top-0 start-0 end-0 alert alert-danger alert-dismissible fade show rounded-top-0 text-center" role="alert" style="z-index: 10000;">
	<p class="text-danger"> <?= $error ?></p>
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script type="text/javascript">
	setTimeout(function(){
		var errorAlert = document.getElementById('error');
    	var closeButton = errorAlert.querySelector('.btn-close');
    
	    // Periksa apakah elemen 'error' dan tombol ditemukan sebelum mengklik
	    if (errorAlert && closeButton) {
	        closeButton.click();
	    }
	}, 10000);
</script>