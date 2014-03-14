<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form id="login_form" class="form-horizontal" role="form" method="post" action="<?=site_url('api/login')?>">
			
			<div class="form-group">
				<label class="col-sm-4 control-label">Login</label>
				<div class="col-sm-8">
					<input type="text" name="login" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label">Password</label>
				<div class="col-sm-8">
					<input type="password" name="password" class="form-control">
				</div>
			</div>

			<div class="col-sm-8 col-sm-offset-4">
				<button type="submit" value="login" class="btn btn-primary">Submit</button>
				<a href="<?=site_url('home/register')?>" class="btn btn-success">Register</a>
			</div>

		</form>
	</div>
</div>

<script type="text/javascript">
$(function() {
	
	$("#login_form").submit(function(evt) {
		evt.preventDefault();
		var url = $(this).attr('action');
		var postData = $(this).serialize();

		$.post(url, postData, function(o) {
			if (o.result == 1) {
				window.location.href = '<?=site_url('dashboard')?>';
			} else {
				alert('Invalid Login');
			}

		}, 'json');
	});
});
</script>
