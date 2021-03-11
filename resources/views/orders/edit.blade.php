@extends('layouts.default')

@section('content')
<div class="row">
	<div class="col-12">
		<div id="accordion">
			<div class="card">
				<div class="card-header bg-secondary" id="headingOne">
					<h5 class="mb-0">
						<a class="btn btn-secondary" href="{{ action('OrderController@index') }}">
							<i class="fas fa-arrow-circle-left"></i>
						</a>
						<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapseOne"
							aria-expanded="true" aria-controls="collapseOne">
							<strong>
								Edit: {{ $order->name }}
							</strong>
						</button>
					</h5>
				</div>
				<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
					<div class="card-body">
						<form method="post" action="{{ action('OrderController@update',$order->id) }}">
							<div class="row">
								@csrf
								@method('put')
								<div class="col-md-6">
									<div class="form-group ">
										<label for="name"
											class=" col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>
										<div class="col-md-12">
											<input id="name" type="text"
												class="form-control @error('name') is-invalid @enderror" name="name"
												value="{{ $order->name }}" required autocomplete="off" autofocus>

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
										<label for="type"
											class=" col-md-12 col-form-label text-md-left">{{ __('Type') }}</label>
										<div class="col-md-12">
											<select name="type" id="type" class="form-control select2 select2-default"
												data-placeholder="Select Product...">
												<option value="purchase" id='purchase'
													{{ $order->type=='purchase'? 'Selected':'' }}>
													Purchase</option>
												<option value="sell" id='sell'
													{{ $order->type=='sell'? 'Selected':'' }}>Sell
												</option>
											</select>
										</div>
										@error('type')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group ">
										<label for="entity"
											class=" col-md-12 col-form-label text-md-left">{{ __('Order For') }}</label>
										<div class="col-md-12">
											<select name="entity" id="entity"
												class="form-control select2 select2-default"
												data-placeholder="Select Product...">

												<option
													{{ $order->customer_id == null ? "Selected" : "" }}value="supplier">
													Supplier</option>
												<option {{ $order->supplier_id == null ? "Selected" : "" }}
													value="customer">Customer</option>
											</select>
										</div>

										@error('entity')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-6 customer" {{ !$order->customer_id ? 'style=display:none': '' }}>
									<div class="form-group ">
										<label for="customer"
											class="col-md-12 col-form-label text-md-left">{{ __('Customer') }}</label>

										<div class="col-md-12">
											<select name="customer" id="customer"
												class="form-control select2 select2-default"
												data-placeholder="Select Customer...">
												<option value="">Select Customer</option>
												@foreach ($customers as $customer)
												<option {{ $order->customer_id == $customer->id ? 'selected':'' }}
													value="{{ $customer->id }}">{{ $customer->name }}</option>
												@endforeach
											</select>

											@error('customer')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-6 supplier" {{ !$order->supplier_id ? 'style=display:none': '' }}>
									<div class="form-group ">
										<label for="supplier"
											class=" col-md-12 col-form-label text-md-left">{{ __('Supplier') }}</label>

										<div class="col-md-12">
											<select name="supplier" id="supplier"
												class="form-control select2 select2-default"
												data-placeholder="Select Supplier...">
												<option value="">Select Supplier</option>
												@foreach ($suppliers as $supplier)
												<option {{ $order->supplier_id == $supplier->id?'selected':'' }}
													value="{{ $supplier->id }}">{{ $supplier->name }}</option>
												@endforeach
											</select>

											@error('supplier')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group ">
										<label for="amount"
											class="col-md-12 col-form-label text-md-left">{{ __("Amount") }}</label>

										<div class="col-md-12">
											<textarea rows="1" id="amount"
												class="form-control @error('amount') is-invalid @enderror"
												name="amount">{{  $order->amount }}</textarea>

											@error('amount')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group ">
										<label for="description"
											class=" col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>
										<div class="col-md-12">
											<input id="description" type="text"
												class="form-control @error('description') is-invalid @enderror"
												name="description" value="{{ $order->description }}" autocomplete="off"
												autofocus>

											@error('description')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group ">
										<label for="status"
											class=" col-md-12 col-form-label text-md-left">{{ __('Status') }}</label>
										<div class="col-md-12">
											<select name="status" id="status"
												class="form-control select2 select2-default"
												data-placeholder="Select Product...">
												<option value="0" {{ $order->status=='0'? 'Selected':'' }}>
													Pending</option>
												<option value="1" {{ $order->status=='1'? 'Selected':'' }}>
													Completed
												</option>
											</select>
										</div>

										@error('status')
										<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
										</span>
										@enderror
									</div>
								</div>
								<div class="col-md-6 purchaseOnly">
									<div class="form-group ">
										<label for="color"
											class=" col-md-12 col-form-label text-md-left">{{ __('Color') }}</label>
										<div class="col-md-12">
											<input id="color" type="text"
												class="form-control @error('color') is-invalid @enderror" name="color"
												value="{{ old('color') }}" required autocomplete="off" autofocus>

											@error('color')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-3 purchaseOnly">
									<div class="form-group ">
										<label for="size"
											class=" col-md-12 col-form-label text-md-left">{{ __('Size') }}</label>
										<div class="col-md-12">
											<input id="size" type="text"
												class="form-control @error('size') is-invalid @enderror" name="size"
												value="{{ old('size') }}" required autocomplete="off" autofocus>

											@error('size')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-3 purchaseOnly">
									<div class="form-group ">
										<label for="length"
											class=" col-md-12 col-form-label text-md-left">{{ __('Length') }}</label>
										<div class="col-md-12">
											<input id="length" type="number"
												class="form-control @error('length') is-invalid @enderror" name="length"
												value="{{ old('length') }}" required autocomplete="off" autofocus>

											@error('length')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-3 purchaseOnly">
									<div class="form-group ">
										<label for="breadth"
											class=" col-md-12 col-form-label text-md-left">{{ __('Breadth') }}</label>
										<div class="col-md-12">
											<input id="breadth" type="number"
												class="form-control @error('breadth') is-invalid @enderror"
												name="breadth" value="{{ old('breadth') }}" required autocomplete="off"
												autofocus>

											@error('breadth')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-3 purchaseOnly">
									<div class="form-group ">
										<label for="height"
											class=" col-md-12 col-form-label text-md-left">{{ __('height') }}</label>
										<div class="col-md-12">
											<input id="height" type="number"
												class="form-control @error('height') is-invalid @enderror" name="height"
												value="{{ old('height') }}" required autocomplete="off" autofocus>

											@error('height')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group text-right">
										<button class="btn btn-success">Update Order</button>
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
@section('scripts')
<script>
	$('#entity').on('select2:select', function (e) {
		var data = e.params.data;
		if(data.id=="supplier"){
			$(".supplier").show();
			$(".customer").hide();
			return;
		}
		$(".supplier").hide();
		$(".customer").show();
	});
	$('#type').on('select2:select', function (e) {
            var data = e.params.data;
            let all = $(".purchaseOnly");;
            if(data.id=="sell"){
                for(var i=0; i<all.length; i++) {
                    var a = all.eq(i);
                    a.hide();
                }
                return;
            }
            for(var i=0; i<all.length; i++) {
                var a = all.eq(i);
                a.show();
            }
        });
</script>
@endsection