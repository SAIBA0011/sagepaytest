@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<form action="{{ $data['ACSURL'] }}" method="post">
						<input type="hidden" name="MD" value="{{ $data['MD'] }}">
						<input type="hidden" name="PaReq" value="{{ $data['PAReq'] }}">
						<input type="hidden" name="TermUrl" value="http://saaa.app/test">
						<input type="submit" value="Go to 3D Secure">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
