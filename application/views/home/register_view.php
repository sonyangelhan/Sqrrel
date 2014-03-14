<div class="row">
	<div class="col-md-4 col-md-offset-4">

		<div id="register_form_error" class="bg-danger"><p>fadsfdsf</p></div>
		<form id="register_form" class="form-horizontal" role="form" method="post" action="<?=site_url('api/register')?>">
			
			<div class="form-group">
				<label class="col-sm-4 control-label">Login</label>
				<div class="col-sm-8">
					<input type="text" name="login" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Email</label>
				<div class="col-sm-8">
					<input type="text" name="email" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="password" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Confirm Password</label>
				<div class="col-sm-8">
					<input type="password" name="confirm_password" class="form-control">
				</div>
			</div>

			<div class="col-sm-8 col-sm-offset-4">
				<button type="submit" value="Register" class="btn btn-primary">Register</button>
				<a href="<?=site_url()?>" class="btn btn-link">Back</a>
			</div>

		</form>
	</div>
</div>

<script type="text/javascript">
$(function() {
    
    $("#register_form_error").hide();
    
    $("#register_form").submit(function(evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var postData = $(this).serialize();
        
        $.post(url, postData, function(o) {
            if (o.result == 1) {
                window.location.href = '<?=site_url('home')?>';
            } else {
                $("#register_form_error").show();
                var output = '<ul>';
                for (var key in o.error) {
                    var value = o.error[key];
                    output += '<li>' + value + '</li>';
                }
                output += '</ul>';
                $("#register_form_error").html(output);
            }
        }, 'json');
        
    });
    
});
</script>

