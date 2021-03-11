@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12 col-md-4">
        <div class="card">
            <h5 class="card-header text-center mt-3"><strong>{{ $product->name }}</strong></h5>
            <div class="card-body">
                <div>
                    <table class="table table-striped">
                        <tr>
                            <th>Unit</th>
                            <th>{{ $product->unit->name }}</th>
                        </tr>
                        <tr>
                            <th>Brand</th>
                            <th>{{ $product->brand->name }}</th>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <th>{{ $product->category->name }}</th>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <th>{{ $product->description ?? '---' }}</th>
                        </tr>
                    </table>
                </div>
                <div class="text-right">
                    <a href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete this product.">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a href="/product/{{ $product->id }}/edit" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                        title="Edit this product's details.">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" class="btn btn-secondary btn-sm" data-toggle="tooltip"
                        title="Make an order for this product.">
                        <i class="fa fa-box-open"></i> Create Order
                    </a>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <h5 class="card-header clearfix">
                Images
                <button class="btn btn-sm float-right btn-secondary">
                    <i class="fa fa-plus"></i> Add More
                </button>
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="http://evostore.com.np/wp-content/uploads/2018/11/iphone-xs-max.jpg"
                            class="img-fluid">
                        <button class="btn btn-default text-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/MRWF2_AV1_GOLD_GEO_TH?wid=1144&hei=1144&fmt=jpeg&qlt=80&op_usm=0.5,0.5&.v=1553730851592"
                            class="img-fluid">
                        <button class="btn btn-default text-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="http://evostore.com.np/wp-content/uploads/2018/11/iphone-xs-max.jpg"
                            class="img-fluid">
                        <button class="btn btn-default text-danger">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-8">
        <div id="accordion">
            <div class="card">
                <div class="card-header bg-secondary" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link text-dark collapsed" data-toggle="collapse"
                            data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <strong>Add Stock</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                    <div class="card-body">
                        <form method="POST" action="{{ action('StockController@store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="supplier">{{ __('Supplier *') }}</label>
                                        <select class="form-control select2-default" id="supplier" name="supplier"
                                            data-placeholder="Select Supplier">
                                            @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('supplier')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="quantity">{{ __('Quantity *') }}</label>
                                        <input id="quantity" type="number"
                                            class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                            value="{{ old('quantity') }}" required autocomplete="off" autofocus>

                                        @error('quantity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="cost_price">{{ __('Cost Price *') }}</label>
                                        <input id="cost_price" type="text"
                                            class="form-control @error('cost_price') is-invalid @enderror"
                                            name="cost_price" value="{{ old('cost_price') }}" required
                                            autocomplete="off" autofocus>

                                        @error('cost_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="selling_price">{{ __('Selling Price *') }}</label>
                                        <input id="selling_price" type="text"
                                            class="form-control @error('selling_price') is-invalid @enderror"
                                            name="selling_price" value="{{ old('selling_price') }}" required
                                            autocomplete="off" autofocus>

                                        @error('selling_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="special_price">{{ __('Special Price') }}</label>
                                        <input id="special_price" type="text"
                                            class="form-control @error('special_price') is-invalid @enderror"
                                            name="special_price" value="{{ old('special_price') }}" autocomplete="off"
                                            autofocus>

                                        @error('special_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="color">{{ __('Color') }}</label>
                                        <input id="color" type="text"
                                            class="form-control @error('color') is-invalid @enderror" name="color"
                                            value="{{ old('color') }}" autocomplete="off" autofocus>

                                        @error('color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="size">{{ __('Size') }}</label>
                                        <input id="size" type="text"
                                            class="form-control @error('size') is-invalid @enderror" name="size"
                                            value="{{ old('size') }}" autocomplete="off" autofocus>

                                        @error('size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label for="length">{{ __('Length') }}</label>
                                        <input id="length" type="text"
                                            class="form-control @error('length') is-invalid @enderror" name="length"
                                            value="{{ old('length') }}" autocomplete="off" autofocus>

                                        @error('length')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label for="breadth">{{ __('Breadth') }}</label>
                                        <input id="breadth" type="text"
                                            class="form-control @error('breadth') is-invalid @enderror" name="breadth"
                                            value="{{ old('breadth') }}" autocomplete="off" autofocus>

                                        @error('breadth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label for="height">{{ __('Height') }}</label>
                                        <input id="height" type="text"
                                            class="form-control @error('height') is-invalid @enderror" name="height"
                                            value="{{ old('height') }}" autocomplete="off" autofocus>

                                        @error('height')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="keywords">{{ __('Keywords') }}</label>

                                        <textarea rows="1" id="keywords"
                                            class="form-control @error('keywords') is-invalid @enderror"
                                            name="keywords">{{ old('keywords') }}</textarea>

                                        @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="remarks">{{ __('Remarks') }}</label>

                                        <textarea rows="1" id="remarks"
                                            class="form-control @error('remarks') is-invalid @enderror"
                                            name="remarks">{{ old('remarks') }}</textarea>

                                        @error('remarks')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="added_at">{{ __('Added at*') }}</label>
                                        <input type="text" name="added_at" id="added_at" placeholder=""
                                            class="form-control datepicker">

                                        @error('added_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="manufactured_at">{{ __('Manufactured at') }}</label>
                                        <input type="text" name="manufactured_at" id="manufactured_at" placeholder=""
                                            class="form-control datepicker">

                                        @error('manufactured_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-12">
                                    <div class="form-group">
                                        <label for="expires_at">{{ __('Expires at') }}</label>
                                        <input type="text" name="expires_at" id="expires_at" placeholder=""
                                            class="form-control datepicker">

                                        @error('expires_at')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        </>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <div class="form-group">
                                        <button class="btn btn-secondary btn-sm">Add Stock</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header bg-secondary" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed text-dark" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <strong>Add New Order</strong>
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <form method="post" action="{{ action('OrderController@store') }}">
                            @csrf
                            <input type="hidden" name="user_id" value={{  Auth::id()}}>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="name"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Name') }}</label>
                                        <div class="col-md-12">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="type"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Type') }}</label>
                                        <div class="col-md-12">
                                            <select name="type" id="type" class="form-control select2 select2-default"
                                                data-placeholder="Select Product...">
                                                <option value="purchase" id='purchase'>Purchase</option>
                                                <option value="sell" id='sell'>Sell</option>
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
                                                <option value="supplier">Supplier</option>
                                                <option value="customer">Customer</option>
                                            </select>
                                        </div>

                                        @error('entity')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 customer" style="display: none;">
                                    <div class="form-group ">
                                        <label for="customer"
                                            class="col-md-12 col-form-label text-md-left">{{ __('Customer') }}</label>

                                        <div class="col-md-12">
                                            <select name="customer" id="customer"
                                                class="form-control select2 select2-default"
                                                data-placeholder="Select Customer...">
                                                <option value="">Select Customer</option>
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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
                                <div class="col-md-6 supplier">
                                    <div class="form-group ">
                                        <label for="supplier"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Supplier') }}</label>

                                        <div class="col-md-12">
                                            <select name="supplier" id="supplier"
                                                class="form-control select2 select2-default"
                                                data-placeholder="Select Supplier...">
                                                <option value="">Select Supplier</option>
                                                @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                                <input type="hidden" name="product" value="{{ $product->id  }}" id="">
                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="description"
                                            class=" col-md-12 col-form-label text-md-left">{{ __('Description') }}</label>
                                        <div class="col-md-12">
                                            <input id="description" type="text"
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description" value="{{ old('description') }}" autocomplete="off"
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
                                                <option value="0">
                                                    Pending</option>
                                                <option value="1">
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
                                <div class="col-md-12 mx-auto sellOnly" align="center" style="font-size:13px">
                                    <table class="table table-striped table-responsive sellOnly" style="display: none">
                                        <tr>
                                            <th>Check</th>
                                            <th>Supplier</th>
                                            <th>Quantity</th>
                                            <th>Cost Price</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Dimensions</th>
                                        </tr>
                                        @foreach( $stocks as $key=>$stock)
                                        @if ($stock->quantity>0)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                                        name="selectedSellStocks[]" value="{{ $stock->id }}">
                                                    <label class="form-check-label" for="exampleCheck1"></label>
                                                </div>
                                            </td>
                                            <td>{{ $stock->supplier->name }}</td>
                                            <td><strong class="text-danger">Available Stock:
                                                    {{ $stock->quantity }}</strong><br>
                                                <input class="form-control form-control-sm" type="number"
                                                    max="{{ $stock->quantity }}" min=0
                                                    name="stock_sell_quantity[{{ $stock->id }}]"
                                                    id='stock_sell_quantity' value="0" placeholder="Eg: 10">
                                            </td>
                                            <td id="stock_sell_cost_price">{{ $stock->cost_price }}</td>
                                            <td>{{ $stock->color ?? '---' }}</td>
                                            <td>{{ $stock->size ?? '---' }}</td>
                                            @if ($stock->dimensions)
                                            <td>L:{{ $stock->dimensions['length'] ?? '---' }}
                                                B:{{ $stock->dimensions['breadth'] ?? '---' }}
                                                H{{ $stock->dimensions['height'] ?? '---' }}
                                            </td>
                                            @endif
                                        </tr>
                                        @endif
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-md-12 purchaseOnly">
                                    <table class="table table-striped table-responsive" style="font-size:13px"
                                        id="addDynamicForm">
                                        <tr>
                                            <th style="min-width:40px">Remove Stock</th>
                                            <th style="min-width:120px">Quantity</th>
                                            <th style="min-width:120px">Cost Price</th>
                                            <th style="min-width:120px">Selling Price</th>
                                            <th style="min-width:120px">Special Price</th>
                                            <th style="min-width:120px">Color</th>
                                            <th style="min-width:120px">Size</th>
                                            <th style="min-width:240px">Dimensions</th>
                                            <th style="min-width:120px">Keywords</th>
                                            <th style="min-width:120px">Remarks</th>
                                            <th style="min-width:120px">Added at</th>
                                            <th style="min-width:120px">Manufactured at</th>
                                            <th style="min-width:120px">Expires at</th>
                                        </tr>
                                        <tr class="dynamicForm">
                                            <td> <a class="btn" href="#" id="removeDynamicForm" data-index=0>
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </td>
                                            <td><input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_quantity[]" id="stock_purchase_quantity"
                                                    value="0" placeholder="">
                                            </td>
                                            <td><input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_cost_price[]" id="stock_purchase_cost_price"
                                                    value="0" placeholder=""></td>
                                            <td><input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_selling_price[]" value="" placeholder=""></td>
                                            <td><input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_special_price[]" value="" placeholder=""></td>
                                            <td><input class="form-control form-control-sm" type="text"
                                                    name="stock_purchase_color[]" value="" placeholder=""></td>
                                            <td><input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_size[]" value="" placeholder=""></td>
                                            <td>L:<input class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_length[]"
                                                    style="display:inline-block; width:50px" value="" placeholder="">
                                                B:<input style="display:inline-block; width:50px"
                                                    class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_breadth[]" value="" placeholder="">
                                                H<input style="display:inline-block; width:50px"
                                                    class="form-control form-control-sm" type="number"
                                                    name="stock_purchase_height[]" value="" placeholder="">
                                            </td>
                                            <td><input class="form-control form-control-sm" type="text"
                                                    name="stock_purchase_keywords[]" value="" placeholder=""></td>
                                            <td><input class="form-control form-control-sm" type="text"
                                                    name="stock_purchase_remarks[]" value="" placeholder=""></td>
                                            <td>
                                                <div class="form-group ">
                                                    <input type="text" style="font-size:13px"
                                                        name="stock_purchase_added_at[]" id="added_at0" placeholder=""
                                                        class="form-control form-control-sm datepicker">

                                                    @error('stock_purchase_added_at[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    </>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" style="font-size:13px"
                                                        name="stock_purchase_manufactured_at[]" id="manufactured_at0"
                                                        placeholder="" class="form-control form-control-sm datepicker">

                                                    @error('stock_purchase_manufactured_at[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    </>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <input type="text" style="font-size:13px"
                                                        name="stock_purchase_expires_at[]" id="expires_at0"
                                                        placeholder="" class="form-control form-control-sm datepicker">

                                                    @error('stock_purchase_expires_at[]')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                    </>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            {{-- <input type="number" name="totalQuantity" id="totalQuantity"> --}}
                            {{-- <input type="number" name="totalPrice" id="totalPrice"> --}}
                            <span class="btn btn-primary btn-sm purchaseOnly" id="addStock">Add Another
                                Stock
                            </span>
                            <div class=" col-md-12 text-right">
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-sm">Add New Order</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>All Stocks</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-responsive">
                            <tr>
                                <th>S.N</th>
                                <th>Supplier</th>
                                <th>Quantity</th>
                                <th>Cost Price</th>
                                <th>Selling Price</th>
                                <th>Special Price</th>
                                <th>Color</th>
                                <th>Size</th>
                                <th>Dimensions</th>
                                <th>Keywords</th>
                                <th>Remarks</th>
                                <th>Added at</th>
                                <th>Manufactured at</th>
                                <th>Expires at</th>
                            </tr>
                            @foreach( $stocks as $key=>$stock)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $stock->supplier->name }}</td>
                                <td>{{ $stock->quantity }}</td>
                                <td>{{ $stock->cost_price }}</td>
                                <td>{{ $stock->selling_price }}</td>
                                <td>{{ $stock->special_price ?? '---' }}</td>
                                <td>{{ $stock->color ?? '---' }}</td>
                                <td>{{ $stock->size ?? '---' }}</td>
                                @if ($stock->dimensions)
                                <td>L:{{ $stock->dimensions['length'] ?? '---' }}
                                    B:{{ $stock->dimensions['breadth'] ?? '---' }}
                                    H{{ $stock->dimensions['height'] ?? '---' }}
                                </td>
                                @endif
                                <td>{{ $stock->keywords ?? '---' }}</td>
                                <td>{{ $stock->remarks ?? '---' }}</td>
                                <td>{{ $stock->added_at ?? '---' }}</td>
                                <td>{{ $stock->manufactured_at ?? '---' }}</td>
                                <td>{{ $stock->expires_at ?? '---' }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h5>Top 5 Orders (<a href={{"/orders?product_id=".$product->id}}>Show All</a>)</h5>
                    </div>
                    {{-- <div class="card-bpdy">
                        <table class="table table-striped table-responsive">
                            <tr>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Customer/Supplier</th>
                                <th>Status</th>
                                <th style="min-width: 250px !important">Manage</th>
                            </tr>
                            @foreach ($product->orders()->latest()->take(5)->get() as $recentOrder)
                            <tr>
                                <td>{{ $recentOrder->order_id}}</td>
                    <td>{{ $recentOrder->name }}</td>
                    <td>{{ $recentOrder->type }}</td>
                    <td>{{ $recentOrder->customer ?  $recentOrder->customer->name : $recentOrder->supplier->name}}
                    </td>
                    <td>{{ $recentOrder->status =='1'?'Completed':'Pending'}}</td>
                    <td>
                        <form method="post" action="{{ action('OrderController@destroy', $recentOrder->id) }}">
                            @csrf
                            @method('DELETE')
                            @if (!$recentOrder->status)
                            <a class="btn btn-sm btn-secondary"
                                href="{{ action('OrderController@edit', $recentOrder->id) }}">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-sm btn-secondary"
                                href="{{ action('OrderController@markAsCompleted', $recentOrder->id) }}">
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
                    </table>
                </div> --}}
            </div>
            <div class="card mt-4">
                <div class="card-header">
                    <h5>All deliveries</h5>
                </div>
                <div class="card-bpdy">
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
        document.querySelector("#addDynamicForm").addEventListener("click",(e)=>{
            if(e.target.id=="removeDynamicForm"){
                e.preventDefault();
                e.target.parentElement.parentElement.parentElement.removeChild(e.target.parentElement.parentElement)
            }
        })
    </script>
    @endsection