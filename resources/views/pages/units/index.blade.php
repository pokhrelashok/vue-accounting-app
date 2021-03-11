@extends('layouts.default')

@section('content')
<div class="row">
	<div class="col-12">
		<div id="accordion">
			<div class="card">
				<div class="card-header bg-secondary" id="headingOne">
					<h5 class="mb-0">
						<button class="btn btn-link collapsed text-dark" data-toggle="collapse"
							data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
							<strong>Add New Unit</strong>
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form method="post" action="{{ action('UnitController@store') }}">
							@csrf
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
										<label for="name">{{ __('Name') }}</label>

										<input id="name" type="text"
											class="form-control @error('name') is-invalid @enderror" name="name"
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

										<textarea rows="1" id="description"
											class="form-control @error('description') is-invalid @enderror"
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
		</div>
		<div class="card mt-4">
			<div class="card-header">
				<h5>All Units ({{ $units->count() }})</h5>
			</div>
			<div class="card-bpdy">
				<table class="table table-striped table-sm mb-0">
					<thead>
						<tr>
							<th>S.N</th>
							<th>Name</th>
							<th>Description</th>
							<th width="150">Manage</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($units as $key=>$unit)
						<tr>
							<td>{{ $key+1 }}</td>
							<td>{{ $unit->name }}</td>
							<td>{{ $unit->description }}</td>
							<td>
								<form method="post" action="{{ action('UnitController@destroy', $unit->id) }}">
									@csrf
									@method('DELETE')
									<a class="btn btn-sm btn-secondary"
										href="{{ action('UnitController@edit', $unit->id) }}">
										<i class="fas fa-edit"></i>
									</a>
									<button class="btn btn-danger btn-sm">
										<i class="fas fa-trash"></i>
									</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
                {{ $units->links() }}
			</div>
		</div>
	</div>
</div>
@endsection
