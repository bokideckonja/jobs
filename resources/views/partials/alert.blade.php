@if(session()->has('flash-message'))
	<div class="alert alert-{{ session()->has('flash-level')?session('flash-level'):'success' }} alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
		{{ session('flash-message') }}
	</div>
@endif