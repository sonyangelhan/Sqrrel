<div class="row">
	<div class="col-md-4 col-md-offset-4 sqrrel-brand">
		<h1>Sqrrel</h1>
		<h2>Social & Lean CRM</h2>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<form id="login_form" class="form-horizontal" role="form" method="post" action="<?=site_url('api/login')?>">
			
			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-2">
					<input type="text" name="login" class="form-control" placeholder="login name">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-8 col-sm-offset-2">
					<input type="password" name="password" class="form-control" placeholder="password">
				</div>
			</div>

			<div class="col-sm-8 col-sm-offset-2 text-center">
				<button type="submit" value="login" class="btn btn-primary">Login</button>
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
