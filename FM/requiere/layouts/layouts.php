<?php
function layoutexample(){
	echo('<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
	      </div>
	      <div class="modal-body">
	        Hola Mundo xD
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>');
}



function layoutUploadLogo(){
	echo('
		<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
	      <link href="/FM/css/imgstyle.css" rel="stylesheet" />
	        
	      
			<div id="drop">
				<center>Drop Here</center>

				<a>Browse</a>
				<input type="file" name="upl" multiple />
			</div>

			<ul>
				<!-- The file uploads will be shown here -->
			</ul>

		</form>

		<!-- JavaScript Includes -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
		<script src="/FM/requiere/imgRequiere/js/jquery.knob.js"></script>

		<!-- jQuery File Upload Dependencies -->
		<script src="/FM/requiere/imgRequiere/js/jquery.ui.widget.js"></script>
		<script src="/FM/requiere/imgRequiere/js/jquery.iframe-transport.js"></script>
		<script src="/FM/requiere/imgRequiere/js/jquery.fileupload.js"></script>
		
		<!-- Our main JS file -->
		<script src="/FM/requiere/imgRequiere/js/script.js"></script>

	     ');
}




?>