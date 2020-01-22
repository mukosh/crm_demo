<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					@if(count($posts)>0)
					  @foreach($posts as $post)
					  	<tr>
					  		<th>Contact</th>
					  		<th>Delete</th>
					  	</tr>
					  	<tr>
					  		<th>{{ $post->client_id }}</th>
					  		<th><a href="#">Del</a></th>
					  	</tr>
					  	<tr>
					  		<th>{{ $post->client_id }}</th>
					  		<th>del</th>
					  	</tr>
					  @endforeach
					@endif
					
				</table>
			</div>
		</div>
	</div>
</body>
</html>