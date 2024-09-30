@extends ('backend.layouts.app')

@section('title', 'New Transaction')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/ajax/css/select2.min.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>নিউ ট্রানসাকশান</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">নিউ ট্রানসাকশান</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
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

                            <form action="{{ route('transactions.store', $sale->id) }}" method="POST" class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label for="customer_id" class="col-lg-2">Customer :</label>
                                    <div class="col-lg-5">
                                        <select name="customer_id" id="customer_id" class="form-control select2">
                                            <option selected>Customer Select</option>
                                            @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div><br>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-4">
                                        <label for="">Customer Name</label>
                                        <input type="text" name="name" value="{{old('name', $sale->customer->name)}}" class="form-control" placeholder="Enter Customer Name">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Phone Number</label>
                                        <input type="text" name="phone" value="{{old('phone', $sale->customer->phone)}}" placeholder="Enter Phone Number" class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Address</label>
                                        <textarea name="address" class="form-control">{{old('address', $sale->customer->address)}}</textarea>
                                    </div>
                                </div><br>

                                <div class="form-group row">
                                    <label for="book_search" class="col-lg-2">বইয়ের সিলেক্ট করুন:</label>
                                    <div class="col-lg-5">
                                        <select name="book_id" id="book_search" class="form-control select2">
                                            <option value="" disabled selected>সার্চ ফর বুক...</option>
                                            @foreach ($books as $item)
                                            <option value="{{$item->id}}" data-price="{{$item->price}}">{{$item->book_bangla_name}}</option>
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
                                                        <th>Stock Id</th>
                                                        <th>Book</th>
                                                        <th>Quantity</th>
                                                        <th>Price</th>
                                                        <th>Discount (%)</th>
                                                        <th>Sub-total</th>
                                                        <th width="15%"><i class="fa fa-cog"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="sale-details">
                                                    <!-- Sale details will be dynamically added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card">
                                            <div class="card-header">
                                                <p>Subtotal <span id="subtotal-price">0.00</span></p>
                                                <input type="number" name="discount" class="form-control" id="discount-percentage" placeholder="Discount (%)" min="0" max="100" value="0">
                                                <hr>
                                                <h4>Total <span id="total-price">0.00</span></h4>
                                            </div>
                                            <div class="card-body">
                                                <button type="submit" class="btn btn-primary">Save Transaction</button>
                                            </div>
                                        </div>
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

<!-- Modal -->
<div class="modal fade" id="modal-book" tabindex="-1" role="dialog" aria-labelledby="modal-book">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Select Product</h4>
            </div>
            <div class="modal-body">
                <input type="text" id="book-search-input" class="form-control" placeholder="Search for books...">
                <table class="table table-striped table-bordered table-product table-hover">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>In Stock</th>
                            <th>Name</th>
                            <th>Purchase Price</th>
                            <th><i class="fa fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody id="book-list">
                        <!-- Book search results will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/ajax/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        // When a book is selected from the dropdown
        $('#book_search').on('change', function() {
            const selectedBookId = $(this).val();
            const selectedBookName = $(this).find('option:selected').text();
            const selectedBookPrice = $(this).find('option:selected').data('price');

            if (selectedBookId) {
                const query = selectedBookName;
                if (query.length >= 2) {
                    fetch(`/select2_sales_sms_backend/books/search?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            let html = '';
                            data.forEach((item, index) => {
                                html += `
                                <tr>
                                    <td width="5%">${index + 1}</td>
                                    <td hidden>${item.id}</td>
                                    <td hidden>${item.book_id}</td>
                                    <td>${item.quantity}</td>
                                    <td>${item.book.book_bangla_name}</td>
                                    <td>${item.price}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-xs btn-flat select-product" data-id="${item.id}" data-book-id="${item.book.id}" data-book-name="${item.book.book_bangla_name}" data-price="${item.price}">
                                            <i class="fa fa-check-circle"></i> Select
                                        </button>
                                    </td>
                                </tr>
                            `;
                            });
                            $('#book-list').html(html);
                        });
                }
            }
        });

        // Event delegation to handle dynamically added buttons
        $(document).on('click', '.select-product', function() {
            const stockId = $(this).data('id');
            const bookId = $(this).data('book-id');
            const bookName = $(this).data('book-name');
            const price = $(this).data('price');
            selectProduct(stockId, bookId, bookName, price);
        });

        // Function to select a product and add it to the sale details
        function selectProduct(stockId, bookId, bookName, price) {
            const index = $('#sale-details tr').length;
            const row = `
            <tr>
                <td>${index + 1}</td>
                <td>
                    <input type="hidden" name="books[${index}][id]" value="${stockId}" hidden>
                    ${stockId}
                </td>
                <td hidden>
                    <input type="hidden" name="books[${index}][book_name]" value="${bookName}">
                    ${bookName}
                </td>
                <td>
                    <input type="hidden" name="books[${index}][book_id]" value="${bookId}">
                    ${bookName}
                </td>
                <td><input type="number" name="books[${index}][quantity]" class="form-control" onchange="updateSubtotal(${index}, ${price})" min="1" value="1"></td>
                <td>
                    <input type="hidden" name="books[${index}][price]" value="${price}">
                    ${price}
                </td>
                <td><input type="number" name="books[${index}][discount]" class="form-control" onchange="updateSubtotal(${index}, ${price})" value="0" min="0" max="100"></td>
                <td><input type="text" name="books[${index}][subtotal]" class="form-control" value="${price.toFixed(2)}" readonly></td>
                <td><button type="button" class="btn btn-danger btn-xs remove-product" data-index="${index}"><i class="fa fa-times"></i></button></td>
            </tr>
            `;
            $('#sale-details').append(row);
            calculateSubTotal();
        }

        // Event delegation to handle dynamically added remove buttons
        $(document).on('click', '.remove-product', function() {
            const index = $(this).data('index');
            removeProduct(index);
        });

        window.updateSubtotal = function(index, price) {
            const quantityElement = $(`input[name="books[${index}][quantity]"]`);
            const discountElement = $(`input[name="books[${index}][discount]"]`);
            const quantity = parseFloat(quantityElement.val());
            const discount = parseFloat(discountElement.val());
            const subtotal = (quantity * price) * ((100 - discount) / 100);
            $(`input[name="books[${index}][subtotal]"]`).val(subtotal.toFixed(2));
            calculateSubTotal();
        };

        function calculateSubTotal() {
            let subtotal = 0;
            $('input[name$="[subtotal]"]').each(function() {
                subtotal += parseFloat($(this).val());
            });
            $('#subtotal-price').text(subtotal.toFixed(2));
            calculateTotal(subtotal);
        }

        function calculateTotal(subtotal) {
            const discountPercentage = parseFloat($('#discount-percentage').val()) || 0;
            const total = subtotal * ((100 - discountPercentage) / 100);
            $('#total-price').text(total.toFixed(2));
        }

        $('#discount-percentage').on('change', function() {
            const subtotal = parseFloat($('#subtotal-price').text());
            calculateTotal(subtotal);
        });

        window.removeProduct = function(index) {
            $(`#sale-details tr:eq(${index})`).remove();
            calculateSubTotal();
        };
    });
</script>

@endsection