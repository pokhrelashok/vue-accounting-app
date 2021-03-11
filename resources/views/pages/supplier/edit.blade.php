@extends('layouts.default')

@section('content')
	<div class="row">
		<div class="col-12">
			<div id="accordion">
			  <div class="card">
			    <div class="card-header bg-secondary" id="headingOne">
			      <h5 class="mb-0">
			      	<a class="btn btn-secondary" href="{{ action('SupplierController@index') }}">
		        		<i class="fas fa-arrow-circle-left"></i>
		        	</a>
			        <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			        	<strong>
				        	Edit: {{ $supplier->name }}
				        </strong>
			        </button>
			      </h5>
			    </div>
			    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form method="post" action="{{ action('SupplierController@update',$supplier->id) }}" >
                           <div class="row">
                            @csrf
                            @method('put')
                            <div class="col-md-6">
							    <div class="form-group ">                                
                                    <label for="name" class=" col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>
                                    <div class="col-md-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $supplier->name }}" required autocomplete="off" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="phone_number" class="col-md-12 col-form-label text-md-left">{{ __('Phone') }}</label>

                                    <div class="col-md-12">
                                        <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{  $supplier->phone_number }}" required autocomplete="off" autofocus>

                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('Email') }}</label>

                                    <div class="col-md-12">
                                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $supplier->email }}" required autocomplete="off" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="address" class=" col-md-12 col-form-label text-md-left">{{ __('Address') }}</label>

                                    <div class="col-md-12">
                                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{  $supplier->address }}" required autocomplete="off" autofocus>

                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="description" class="col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>

                                    <div class="col-md-12">
                                        <textarea rows="1" id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{  $supplier->description }}</textarea>

                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12 text-right">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="priority" name="priority" {{$supplier->priority==1?'checked':''}}>
                                        <label class="form-check-label" for="priority">Priority</label>
                                    </div>
                            </div>
                            <div class="col-md-12 text-right">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="favorite" name="favorite" {{$supplier->favorite==1?'checked':''}}>
                                        <label class="form-check-label" for="favorite">Favorite</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button class="btn btn-success">Update Supplier</button>
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