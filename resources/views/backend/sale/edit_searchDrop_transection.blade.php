@extends('backend.layouts.app')

@section('title', 'Edit Transaction')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/ajax/css/select2.min.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>এডিট ট্রানসাকশান</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">এডিট ট্রানসাকশান</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                <li>{{$err}}</li>
                                @endforeach
                            </div>
                            @endif

                            <form action="{{ route('transactions.update', $sale->id) }}" method="POST" class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label for="customer_id" class="col-lg-2">কাস্টমার :</label>
                                    <div class="col-lg-5">
                                        <select name="customer_id" id="customer_id" class="form-control select2">
                                            <option selected>কাস্টমার সিলেক্ট করুন...</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="book_search" class="col-lg-2">Select Book:</label>
                                    <div class="col-lg-5">
                                        <select name="book_id" id="book_search" class="form-control select2">
                                            <option value="" disabled selected>বই সিলেক্ট করুন...</option>
                                            @foreach ($books as $item)
                                            @if($item->stock_detail->sum('quantity') > 0)
                                            <option value="{{$item->id}}" data-price="{{$item->price}}" {{ $sale->book_id == $item->id ? 'selected' : '' }}>{{$item->book_bangla_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modal-book"><i class="fa fa-search-plus"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <table class="table table-bordered table-striped table-sale">
                                                <thead>
                                                    <tr>
                                                        <th>#SL</th>
                                                        <th hidden>Stock Id</th>
                                                        <th>Book</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Discount (%)</th>
                                                        <th>Sub-total</th>
                                                        <th width="15%"><i class="fa fa-cog"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sale-details">
                                                    @foreach($sale->details as $index => $detail)
                                                    <tr data-id="{{ $detail->book_id }}">
                                                        <td>{{ $index + 1 }}</td>
                                                        <!-- <td><input type="hidden" name="books[{{ $index }}][sale_detail_id]" value="{{ $detail->id }}">{{ $detail->id }}</td> -->
                                                        <td hidden><input type="hidden" name="books[{{ $index }}][detail_id]" value="{{ $detail->id }}">{{ $detail->id }}</td>
                                                        <td hidden><input type="hidden" name="books[{{ $index }}][id]" value="{{ $detail->book_id }}">{{ $detail->book_id }}</td>
                                                        <td>{{ $detail->book->book_bangla_name }}<input type="hidden" name="books[{{ $index }}][book_id]" value="{{ $detail->book_id }}"></td>
                                                        <td><input type="number" name="books[{{ $index }}][quantity]" class="form-control book-quantity" value="{{ $detail->quantity }}" min="1"></td>
                                                        <td><input type="number" name="books[{{ $index }}][price]" class="form-control book-price" value="{{ $detail->price }}" readonly></td>
                                                        <td><input type="number" name="books[{{ $index }}][discount]" class="form-control book-discount" value="{{ $detail->discount }}" min="0" max="100"></td>
                                                        <td><input type="number" name="books[{{ $index }}][subtotal]" class="form-control book-subtotal" value="{{ $detail->subtotal }}" readonly></td>
                                                        <td><button type="button" class="btn btn-danger btn-sm btn-remove-book"><i class="fa fa-times"></i></button></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group row">
                                            <label for="discount" class="col-lg-4 control-label">Discount (%)</label>
                                            <div class="col-lg-8">
                                                <input type="number" name="discount" id="discount-percentage" class="form-control" value="{{ old('discount', $sale->discount) }}" min="0" max="100">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="subtotal-price" class="col-lg-4 control-label">Sub-total</label>
                                            <div class="col-lg-8">
                                                <span id="subtotal-price">{{ number_format($sale->total_price, 2) }}</span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="total-price" class="col-lg-4 control-label">Total</label>
                                            <div class="col-lg-8">
                                                <span id="total-price">{{ number_format($sale->total_price * ((100 - $sale->discount) / 100), 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/ajax/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        let saleDetails = @json($sale -> details);

        $('#book_search').change(function() {
            let bookId = $(this).val();
            let bookName = $('#book_search option:selected').text();
            let price = $('#book_search option:selected').data('price');
            let row = `
            <tr data-id="${bookId}">
                <td>${saleDetails.length + 1}</td>
                <td><input type="hidden" name="books[${saleDetails.length}][id]" value="${bookId}">${bookId}</td>
                <td>${bookName}<input type="hidden" name="books[${saleDetails.length}][book_id]" value="${bookId}"></td>
                <td><input type="number" name="books[${saleDetails.length}][quantity]" class="form-control book-quantity" value="1" min="1"></td>
                <td><input type="number" name="books[${saleDetails.length}][price]" class="form-control book-price" value="${price}" readonly></td>
                <td><input type="number" name="books[${saleDetails.length}][discount]" class="form-control book-discount" value="0" min="0" max="100"></td>
                <td><input type="number" name="books[${saleDetails.length}][subtotal]" class="form-control book-subtotal" value="${price}" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-book"><i class="fa fa-times"></i></button></td>
            </tr>
        `;

            $('#sale-details').append(row);
            saleDetails.push({
                id: bookId,
                quantity: 1,
                price: price,
                discount: 0,
                subtotal: price
            });
            calculateTotal();
        });

        $(document).on('click', '.btn-remove-book', function() {
            let row = $(this).closest('tr');
            let bookId = row.data('id');
            saleDetails = saleDetails.filter(book => book.id !== bookId);
            row.remove();
            calculateTotal();
        });

        $(document).on('change', '.book-quantity, .book-discount', function() {
            let row = $(this).closest('tr');
            let bookId = row.data('id');
            let quantity = row.find('.book-quantity').val();
            let price = row.find('.book-price').val();
            let discount = row.find('.book-discount').val();
            let subtotal = quantity * price * ((100 - discount) / 100);

            row.find('.book-subtotal').val(subtotal);

            let book = saleDetails.find(book => book.id === bookId);
            book.quantity = quantity;
            book.discount = discount;
            book.subtotal = subtotal;

            calculateTotal();
        });

        $('#discount-percentage').change(function() {
            calculateTotal();
        });

        $('input[name="name"], input[name="phone"], textarea[name="address"]').on('change', function() {
            // You can add code here to dynamically save or update customer details if required.
        });

        function calculateTotal() {
            let subtotal = 0;
            saleDetails.forEach(book => {
                subtotal += parseFloat(book.subtotal);
            });

            let discount = $('#discount-percentage').val();
            let total = subtotal * ((100 - discount) / 100);

            $('#subtotal-price').text(subtotal.toFixed(2));
            $('#total-price').text(total.toFixed(2));
        }
    });
</script>
@endsection