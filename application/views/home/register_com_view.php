<div class="row">
	<div class="col-md-4 col-md-offset-4 sqrrel-brand-sm">
		<h1>Sqrrel</h1>
		<h2>Social & Lean CRM</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">

		<div id="register_com_form_error" class="bg-danger"><p>fadsfdsf</p></div>
		<form id="register_com_form" class="form-horizontal" role="form" method="post" action="<?=site_url('api/register_com')?>">
			
			<div class="form-group">
				<label class="col-sm-4 control-label">Company Name</label>
				<div class="col-sm-8">
					<input type="text" name="com_name" class="form-control">
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
				<button type="submit" value="Register Company" class="btn btn-primary">Register Company</button>
				<a href="<?=site_url()?>" class="btn btn-link">Back</a>
			</div>

		</form>
	</div>
</div>

<script type="text/javascript">
$(function() {
    
    $("#register_com_form_error").hide();
    
    $("#register_com_form").submit(function(evt) {
        evt.preventDefault();
        var url = $(this).attr('action');
        var postData = $(this).serialize();
        
        $.post(url, postData, function(o) {
            if (o.result == 1) {
                window.location.href = '<?=site_url('home')?>';
            } else {
                $("#register_com_form_error").show();
                var output = '<ul>';
                for (var key in o.error) {
                    var value = o.error[key];
                    output += '<li>' + value + '</li>';
                }
                output += '</ul>';
                $("#register_com_form_error").html(output);
            }
        }, 'json');
        
    });
    
});
</script>

