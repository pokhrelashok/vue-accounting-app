@extends('layouts.default')

@section('content')
<div class="row">
	<div class="col-12">
		{{-- <div id="accordion">
			<div class="card">
				<div class="card-header bg-secondary" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed text-dark" data-toggle="collapse"
							data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<strong>Add New Accounts</strong>
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form method="post" action="{{ action('accountController@store') }}">
		@csrf
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label for="name">{{ __('Name') }}</label>

					<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
						value="{{ old('name') }}" required autocomplete="off" autofocus>

					@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
				</div>
			</div>
			<div class="col-md-6 col-sm-12">
				<div class="form-group">
					<label for="description">{{ __('Description') }}</label>

					<textarea rows="1" id="description" class="form-control @error('description') is-invalid @enderror"
						name="description">{{ old('description') }}</textarea>

					@error('description')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
					@enderror
					</>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group text-right">
					<button class="btn btn-success">Add New Unit</button>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
</div>
</div> --}}
<div class="card mt-4">
	<div class="card-header">
		<h5>All Accounts ({{ $accounts->count() }})</h5>
	</div>
	<div class="card-body">
		<table class="table table-striped table-sm mb-0" id="myTable">
			<thead>
				<tr>
					<th>S.N</th>
					<th>Supplier Name</th>
					<th>Order Name</th>
					<th>Debit</th>
					<th>Credit</th>
					<th>Balance</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($accounts as $key=>$account)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>{{ $account->supplier->name }}</td>
					<td>{{ $account->order->name }}</td>
					<td>{{ $account->debit }}</td>
					<td>{{ $account->credit }}</td>
					<td>{{ $account->balance }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $accounts->links() }}
	</div>
</div>
{{-- </div> --}}
{{-- </div> --}}
@endsection

@section('scripts')
<link rel="stylesheet" href=" https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
	$(document).ready( function () {
        $('#myTable').DataTable({
			"bPaginate":false,
		});
    });
</script>
@endsection