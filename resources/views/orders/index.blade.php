@extends('layouts.default')

@section('content')
<div class="row">
	<div class="col-12">
		<create-order-component></create-order-component>
		<div id="accordion">
			<div class="card mt-4">
				<div class="card-header">
					<h5>All Orders ({{ $orders->count() }})</h5>
				</div>
				<div class="card-bpdy">
					<table class="table table-striped table-sm mb-0 table-responsive">
						<thead>
							<tr>
								<th>S.N</th>
								<th>Name</th>
								<th>Company</th>
								<th>Customer</th>
								<th>Supplier</th>
								<th>Product</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Description</th>
								<th style="min-width: 280px !important">Manage</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($orders as $key=>$order)
							<tr>
								<td>{{ $key+1 }}</td>
								<td>{{ $order->name }}</td>
								<td>{{ $order->company->name ?? '---' }}</td>
								<td>{{ $order->customer->name ?? '---' }}</td>
								<td>{{ $order->supplier->name ?? '---' }}</td>
								<td>{{ $order->product->name ?? '---' }}</td>
								<td>{{ $order->type ?? '---' }}</td>
								<td>{{ $order->amount ?? '---' }}</td>
								<td>{{ $order->status == 1 ? 'Completed':'Pending'}}</td>
								<td>{{ $order->description ?? '---' }}</td>
								<td>
									<form method="post" action="{{ action('OrderController@destroy', $order->id) }}">
										@csrf
										@method('DELETE')
										@if (!$order->status)
										<a class="btn btn-sm btn-secondary" href="">
											<i class="fas fa-truck"></i>
										</a>
										<a class="btn btn-sm btn-secondary"
											href="{{ action('OrderController@edit', $order->id) }}">
											<i class="fas fa-edit"></i>
										</a>
										<a class="btn btn-sm btn-secondary"
											href="{{ action('OrderController@markAsCompleted', $order->id) }}">
											<i class="fas fa-check-circle"></i>
											Mark Complete
										</a>
										@endif
										<button class="btn btn-danger btn-sm">
											<i class="fas fa-trash"></i>
										</button>
									</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
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
</script>
@endsection