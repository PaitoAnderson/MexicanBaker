<div class="postbody">
	<h1>Contact Me</h1>
	<h2 id="status" style="display:none;background-color: #FFFF7E;padding:5px;margin-bottom:10px;"></h2>
	<form action="#" method="post" id="commentform">
	<p class="comment-form-author input-block">
		<label for="author"><b>Name</b> (required)</label>
		<input id="author" name="author" type="text" value="" size="30" placeholder="John Smith" aria-required="true" required="" />
	</p>
	<p class="comment-form-email input-block">
		<label for="email"><b>Email</b> (required)</label>
		<input id="email" name="email" type="email" value="" size="30" placeholder="someone@something.com" aria-required="true" required="" />
	</p>
	<p class="comment-form-url input-block">
		<label for="subject"><b>Subject</b> (required)</label>
		<input id="subject" name="subject" type="url" value="" placeholder="What Instagram filter do you use?" size="30" />
	</p>
	<p class="comment-form-comment">
		<label for="message"><b>Message</b></label>
		<textarea style="position: relative;z-index: 10;opacity: 0.8;color:#818181;background-color:#F4F4F4;border-color:#E5E5E5;" id="message" name="message" cols="45" rows="5" placeholder="Write your message here." aria-required="true" required=""></textarea>
	</p>
	<p class="form-submit">
		<input style="width: 150px;" name="contactus" type="submit" id="contactus" value="Send Message" />
	</p>
	</form>
</div>
<script type="text/javascript">
		$(document).ready(function() {
			var lockButton = false;
			
			//Lock button, send data and wait for success, if success display message if fail unlock button
			$("#ContactUs").click(function() {
				if (lockButton) {
					return false;
				} else {
					lockButton = true;
					
					//This variable will be populated from by AJAX call.
					var data;
					
					//add code for ajax if fail then
					//lockButton = false
					
					//Get data
					var urname = $("#formName").val();	
					var subject = $("#formSubject").val();	
					var email = $("#email").val();	
					var mainText = $("#formText").val();	
			
					//Compile data
					var dataString = 'formName='+ urname + '&formSubject=' + subject + '&email=' + email + '&formText=' + encodeURIComponent(mainText);
					
					//Debugging Data
					//alert(dataString);return false;
					
					//Scroll to the top of the page on submit
					$('html, body').animate({scrollTop:0}, 'fast');
							
					//Send data
					$.ajax({
						type: "POST",
						url: "ajaxmail.php",
						data: dataString,
						success: function(data) {
							//alert(data);
							if (data.indexOf("Message delivery failed...please try again.")!=-1) {
								lockButton = false; //Unlock submit button if failed	
							}
							
							//Show response from contactus.php in div
							$('#mainContent').css({height:'262px'});
							$("#responseMsg").html(data);
							$("#responseMsg").fadeIn(1000);					
					
						}
					});
					
					//exit function
					return false;
				};
			});
		});
</script>