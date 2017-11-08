<script>
	$(document).ready(function() {
		// actionCall();
		// actionRelease();
		// actionDisconnect();
	});
	function actionCall() {
		$.ajax({
	        dataType: 'html',
	        type:"POST",
	        url: '<?php echo site_url('Dashboard/getActCall'); ?>/',
	        data: {
	        		'actionType' : 'outboundCall',
	        		'currentNumber' : $('#currentNum').val(),
	        		'outNumber' : $('#NoTujuan').val()
	    		  },
	        success: function(data) {
	        	$('#respons').html(data);
	        }
	    });
	}
	function actionRelease() {
		$.ajax({
	        dataType: 'html',
	        type:"POST",
	        url: '<?php echo site_url('Dashboard/getActCall'); ?>/',
	        data: {
	        		'actionType' : 'releaseCall',
	        		'currentNumber' : $('#currentNum').val(),
	        		'outNumber' : $('#NoTujuan').val()
	    		  },
	        success: function(data) {
	        	$('#respons').html(data);
	        }
	    });
	}
	function actionDisconnect() {
		$.ajax({
	        dataType: 'html',
	        type:"POST",
	        url: '<?php echo site_url('Dashboard/getActCall'); ?>/',
	        data: {
	        		'actionType' : 'disconnectCall',
	        		'currentNumber' : $('#currentNum').val(),
	        		'outNumber' : $('#NoTujuan').val()
	    		  },
	        success: function(data) {
	        	$('#respons').html(data);
	        }
	    });
	}
</script>