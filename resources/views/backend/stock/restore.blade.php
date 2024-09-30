@extends ('backend.layouts.app')

@section('title', 'Add Stock')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/ajax/css/select2.min.css') }}">
@endsection

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>রি-স্টোর বই</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">রি-স্টোর বই</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Re-Store Book</h3>
                        </div>
                        <!-- /.card-header -->
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                            @endforeach
                        </div>
                        @endif
                        <!-- form start -->
                        <form method="post" action="{{ route('store.restock') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="book_id">বইয়ের নাম</label>
                                    <select name="book_id" class="form-control select2" id="">
                                        <option disabled selected> বই সিলেক্ট করুন...</option>
                                        @foreach($book as $item)
                                        <option value="{{$item->id}}" @if(session('bookid')) {{ session('bookid') == $item->id ? 'selected' : '' }} @else {{ old('book_id') == $item->id ? 'selected' : '' }} @endif >{{$item->book_bangla_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="binder_list_id">সাপ্লায়ার নাম</label>
                                    <select name="binder_list_id" class="form-control select2" id="">
                                        <option disabled selected>সাপ্লায়ার(বাধাইখানার) সিলেক্ট করুন...</option>
                                        @foreach($binder as $item)
                                        <option value="{{$item->id}}" @if(session('binderid')) {{ session('binderid') == $item->id ? 'selected' : '' }} @else {{ old('binder_list_id') == $item->id ? 'selected' : '' }} @endif >{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="quantity">কোয়ান্টিটি</label>
                                    <input type="number" name="quantity" @if (session('qty')) value="{{ session('qty') }}"
                                     @else value="{{old('quantity')}}" @endif class="form-control" placeholder="বইয়ের কোয়ান্টিটি লিখুন">
                                    
                                </div>
                                <div class="form-group">
                                    <label for="price">বইয়ের বিক্রয় মূল্য</label>
                                    <input type="number" name="price" @if (session('price')) value="{{ session('price') }}"
                                     @else value="{{old('price')}}" @endif class="form-control" placeholder="বইয়ের বিক্রয় মূল্য লিখুন">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">স্টোর</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="{{asset('assets/ajax/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection