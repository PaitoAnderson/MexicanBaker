$(function() {

	//Comment
	$("#submit").click(function() {
		var name1 = $("#author").val();
		var email = $("#email").val();
		var website = $("#url").val();
		var comment = $("#comment").val();
		var post_id = $("#comment_post_ID").val();
	   	var dataString = 'name=' + name1 + '&email=' + email + '&website=' + website + '&comment=' + comment + '&post_id=' + post_id;
	
		if(name1=='' || comment=='' || email=='') {
	    	alert('Please Complete Comment Form!');
	    } else {
			$.ajax({
				type: "POST",
				url: "/include/comment.php",
				data: dataString,
				cache: false,
				success: function(html1){
					$("#newcomment").html(html1);
					$("#newcomment").fadeIn("slow");
					document.getElementById('author').value='';
					document.getElementById('email').value='';
					document.getElementById('url').value='';
					document.getElementById('comment').value='';
					$("#author").focus(); 
					//$("#flash").hide();
				  }
			});
		}
	return false;
	});
	
	//Contact Us
	$("#contactus").click(function() {
		var name1 = $("#author").val();
		var email = $("#email").val();
		var subject = $("#subject").val();
		var comment = $("#message").val();
	   	var dataString = 'name=' + name1 + '&email=' + email + '&subject=' + subject + '&comment=' + comment;
	
		if(name1=='' || comment=='' || email=='' || subject=='') {
	    	alert('Please Complete Contact Us Form!');
	    } else {
			$.ajax({
				type: "POST",
				url: "/include/contactus.php",
				data: dataString,
				cache: false,
				success: function(html1){
					$("#status").html(html1);
					$("#status").fadeIn("slow");
					document.getElementById('author').value='';
					document.getElementById('email').value='';
					document.getElementById('subject').value='';
					document.getElementById('message').value='';
					$("#author").focus(); 
				  }
			});
		}
	return false;
	});
});