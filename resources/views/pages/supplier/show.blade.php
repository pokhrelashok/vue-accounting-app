@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12 col-md-5">
        <div class="card">
            <h5 class="card-header text-center mt-3"><strong>{{ $supplier->name }}</strong></h5>
            <div class="card-body">
                <div>
                    <table class="table table-striped table-responsive">
                        <tr>
                            <th>Email</th>
                            <th>{{ $supplier->email  ?? '---'}}</th>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <th>{{ $supplier->phone ?? '---' }}</th>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th>{{ $supplier->address ?? '---' }}</th>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>{{ $supplier->description ?? '---' }}</th>
                        </tr>
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{ action('SupplierController@destroy',$supplier->id) }}" class="btn btn-danger btn-sm"
                        data-toggle="tooltip" title="Delete this supplier.">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a href="/supplier/{{ $supplier->id }}/edit" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                        title="Edit this supplier's details.">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="p-2">
                <a href="/supplier/{{ $supplier->id }}?filter=today" class="btn btn-secondary btn-sm"
                    data-toggle="tooltip" title="Accounts From Today">
                    Today
                </a>
                <a href="/supplier/{{ $supplier->id }}?filter=this_week" class="btn btn-secondary btn-sm"
                    data-toggle="tooltip" title="Accounts From This Week">
                    This Week
                </a>
                <a href="/supplier/{{ $supplier->id }}?filter=this_month" class="btn btn-secondary btn-sm"
                    data-toggle="tooltip" title="Accounts From This Month">
                    This Month
                </a>
                <a href="/supplier/{{ $supplier->id }}{{ Request::get("filter")? "?filter=".Request::get("filter") :""}}/filter"
                    class="btn btn-secondary btn-sm" data-toggle="tooltip" title="Get PDF of current filters">
                    <i class="fa fa-file"></i>
                    Get In PDF
                </a>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-7">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark collapsed" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <strong>Add New Balance</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                    <div class="card-body">
                        <form method="POST" action="{{ action('SupplierAccountController@store') }}">
                            @csrf
                            <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
                            <div class="row">
                                <input type="hidden" value="{{ $supplier->id }}" name="supplier">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="order">{{ __('Order Name *') }}</label>
                                        <select class="form-control select2-default" id="order" name="order"
                                            data-placeholder="Select order">
                                            @foreach($orders as $order)
                                            <option value="{{ $order->id }}">{{ $order->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('order')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="debit">{{ __('Debit (Rs) ') }}</label>
                                        <input id="debit" type="number" class="form-control" name="debit"
                                            value="{{ old('debit') }}" required autocomplete="off" autofocus>

                                        @error('debit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="credit">{{ __('Credit (Rs)') }}</label>
                                        <input id="credit" type="number" class="form-control" name="credit"
                                            value="{{ old('credit') }}" required autocomplete="off" autofocus>

                                        @error('credit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="balance">{{ __('New Balance') }}</label>
                                        <input id="balance" readonly type="number" class="form-control" name="balance"
                                            data-balance="{{ $accounts[0]->balance ?? 0 }}"
                                            value="{{ $accounts[0]->balance ?? 0 }}" required autocomplete="off"
                                            autofocus>

                                        @error('balance')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="hidden" name="account" id="account">

                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <button class="btn btn-secondary btn-sm">Add New Balance</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>All Balances of {{ $supplier->name }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm mb-0">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Order Name</th>
                                <th>Debit (Rs)</th>
                                <th>Credit (Rs)</th>
                                <th>Balance (Rs)</th>
                                {{-- <th width="150">Manage</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $key=>$account)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $account->order->name }}</td>
                                <td>{{ $account->debit }}</td>
                                <td>{{ $account->credit }}</td>
                                <td>{{ $account->balance }}</td>
                                {{-- <td>
                                    <form method="post"
                                        action="{{ action('SupplierBalanceController@destroy', $account->id) }}">
                                @csrf
                                @method('DELETE')
                                <a class="btn btn-sm btn-secondary"
                                    href="{{ action('SupplierBalanceController@show', $account->id) }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a class="btn btn-sm btn-secondary"
                                    href="{{ action('SupplierBalanceController@edit', $account->id) }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                                </form>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
                console.log("done");
                $( ".datepicker" ).datepicker({
                    'dateFormat': 'yy-mm-dd'
                });
            });
    </script>
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
            let allP = $(".purchaseOnly");
            let allS =$(".sellOnly");
            if(data.id=="sell"){
                for(var i=0; i<allP.length; i++) {
                    var a = allP.eq(i);
                    a.hide();
                }
                for(var i=0; i<allS.length; i++) {
                    var a = allS.eq(i);
                    a.show();
                }
                return;
            }
            for(var i=0; i<allP.length; i++) {
                var a = allP.eq(i);
                a.show();
            }
            for(var i=0; i<allS.length; i++) {
                var a = allS.eq(i);
                a.hide();
            }
        });
    </script>
    <script>
        //for purchase
        let index=0;
        let formHtml = "<tr class='dynamicForm'> <td> <a class='btn' href='#' id='removeDynamicForm'> <i class='fas fa-times'></i> </a> </td><td><input class='form-control form-control-sm' type='number' name='stock_purchase_quantity[]' id='stock_purchase_quantity' value='0' placeholder=''> </td><td><input class='form-control form-control-sm' type='number' name='stock_purchase_cost_price[]' id='stock_purchase_cost_price' value='0' placeholder=''></td><td><input class='form-control form-control-sm' type='number' name='stock_purchase_selling_price[]' value='' placeholder=''></td><td><input class='form-control form-control-sm' type='number' name='stock_purchase_special_price[]' value='' placeholder=''></td><td><input class='form-control form-control-sm' type='text' name='stock_purchase_color[]' value='' placeholder=''></td><td><input class='form-control form-control-sm' type='number' name='stock_purchase_size[]' value='' placeholder=''></td><td>L:<input class='form-control form-control-sm' type='number' name='stock_purchase_length[]' style='display:inline-block; width:50px' value='' placeholder=''> B:<input style='display:inline-block; width:50px' class='form-control form-control-sm' type='number' name='stock_purchase_breadth[]' value='' placeholder=''> H<input style='display:inline-block; width:50px' class='form-control form-control-sm' type='number' name='stock_purchase_height[]' value='' placeholder=''> </td><td><input class='form-control form-control-sm' type='text' name='stock_purchase_keywords[]' value='' placeholder=''></td><td><input class='form-control form-control-sm' type='text' name='stock_purchase_remarks[]' value='' placeholder=''></td><td> <div class='form-group '> <input type='text' style='font-size:13px' name='stock_purchase_added_at[]' id='added_at0' placeholder='' class='form-control form-control-sm datepicker'> @error('stock_purchase_added_at[]') <span class='invalid-feedback' role='alert'> <strong>{{$message}}</strong> </span> @enderror </> </div></td><td> <div class='form-group'> <input type='text' style='font-size:13px' name='stock_purchase_manufactured_at[]' id='manufactured_at0' placeholder='' class='form-control form-control-sm datepicker'> @error('stock_purchase_manufactured_at[]') <span class='invalid-feedback' role='alert'> <strong>{{$message}}</strong> </span> @enderror </> </div></td><td> <div class='form-group'> <input type='text' style='font-size:13px' name='stock_purchase_expires_at[]' id='expires_at0' placeholder='' class='form-control form-control-sm datepicker'> @error('stock_purchase_expires_at[]') <span class='invalid-feedback' role='alert'> <strong>{{$message}}</strong> </span> @enderror </> </div></td></tr>"
        $("#addStock").on("click",function(){
            $("#addDynamicForm").append(formHtml.replace(/at0/g,"at"+index));
        })

    </script>
    <script>
        function showNewBalance(){
            oldBalance = parseInt($("#balance").attr("data-balance"));
            $("#balance").val((parseInt($("#debit").val()) || 0 )+oldBalance-(parseInt($("#credit").val()) || 0 ));
        }

        $("#debit").on("keyup change",(e)=>{
            showNewBalance();
        })
        $("#credit").on("keyup change",(e)=>{
            showNewBalance();
        })

    </script>
    @endsection