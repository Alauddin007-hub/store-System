@extends ('backend.layouts.app')

@section('title', 'Add Stock')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>সরবরাহকারী</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">বই সরবরাহকারী</li>
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
                            <h3 class="card-title">বই সরবরাহকারী</h3>
                        </div>
                        <!-- /.card-header -->
                        @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                            <li>{{$err}}</li>
                            @endforeach
                        </div>
                        @endif
                        <!-- form start -->
                        <form method="post" action="{{ route('supplier.store') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="book_id">বইয়ের নাম</label>
                                    <select name="book_id" class="form-control" id="">
                                        <option selected>বইয়ের নাম সিলেক্ট করুন</option>
                                        @if(!empty($book->count()))
                                        @foreach($book as $item)
                                        <option value="{{$item->id}}">{{$item->book_bangla_name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="book_id">ছাপাখানার নাম</label>
                                    <input type="text" class="form-control" name="printing_press_name" value="{{old('printing_press_name')}}" placeholder="ছাপাখানার নাম লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="quantity">ছাপাখানায় প্রদত্ত অর্ডার</label>
                                    <input type="number" name="order_printing_press" value="{{old('order_printing_press')}}" class="form-control" placeholder="ছাপাখানায় প্রদত্ত অর্ডার কোয়ান্টিটি লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="price">বাধাইকারীর কাছে প্রেরণ(নাম)</label>
                                    <input type="text" name="send_to_binder_name" value="{{old('send_to_binder_name')}}" class="form-control" placeholder="বাধাইকারীর কাছে প্রেরণ(নাম) লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="price">বাধাইকারীর কাছে প্রেরণ অর্ডার</label>
                                    <input type="number" name="send_order_quantity" value="{{old('send_order_quantity')}}" class="form-control" placeholder="বাধাইকারীর কাছে প্রেরণ অর্ডার লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="price">বাধাইকারীর কাছ থেকে সরবরাহকৃত বই</label>
                                    <input type="number" name="supplied_from_Binder" value="{{old('send_to_binder')}}" class="form-control" placeholder="বাধাইকারীর কাছ থেকে সরবরাহকৃত বই কোয়ান্টিটি লিখুন">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">অ্যাড</button>
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

@endsection