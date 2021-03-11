@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="col-12">
			<div id="accordion">
			  <div class="card">
			    <div class="card-header bg-secondary" id="headingOne">
			      <h5 class="mb-0">
			      	<a class="btn btn-secondary" href="{{ action('UnitController@index') }}">
		        		<i class="fas fa-arrow-circle-left"></i>
		        	</a>
			        <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			        	<strong>
				        	Edit: {{ $unit->name }}
				        </strong>
			        </button>
			      </h5>
			    </div>
			    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form method="post" action="{{ action('UnitController@update', $unit->id) }}">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="col-md-6 col-sm-12">
									<div class="form-group">
			                            <label for="name">{{ __('Name') }}</label>

		                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $unit->name }}" required autocomplete="off" autofocus>

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

		                                <textarea rows="1" id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ $unit->description }}</textarea>

		                                @error('description')
		                                    <span class="invalid-feedback" role="alert">
		                                        <strong>{{ $message }}</strong>
		                                    </span>
		                                @enderror
			                        </div>
								</div>
								<div class="col-md-12">
									<div class="form-group text-right">
			                        	<button class="btn btn-success">Update Unit</button>
			                        </div>
								</div>
							</div>
						</form>
					</div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
@endsection
