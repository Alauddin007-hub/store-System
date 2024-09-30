@extends ('backend.layouts.app')

@section('title', 'Add Book')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>বই</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">বই এডিট</li>
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
                            <h3 class="card-title">বই এডিট</h3>
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
                        <form method="post" action="{{ route('boi.update', $book->id) }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="book_english_name">বইয়ের ইংরেজি নাম</label>
                                    <input type="text" name="book_english_name" value="{{$book->book_english_name ? $book->book_english_name : old('book_english_name') }}" class="form-control" placeholder="বইয়ের ইংরেজি নাম লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="book_bangla_name">বইয়ের বাংলা নাম</label>
                                    <input type="text" name="book_bangla_name" value="{{$book->book_bangla_name ? $book->book_bangla_name : old('book_bangla_name') }}" class="form-control" placeholder="বইয়ের বাংলা নাম লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="category_id">ক্যাটাগরি নাম</label>
                                    <select name="category_id" class="form-control" id="category_id">
                                        <option disabled>ক্যাটাগরি নাম সিলেক্ট করুন</option>
                                        @foreach($cats as $cat)
                                        <option value="{{$cat->id}}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="writer_id">লেখক নাম</label>
                                    <select name="writer_id" class="form-control" id="writer_id">
                                        <option disabled>লেখক নাম সিলেক্ট করুন</option>
                                        @foreach($lekhok as $item)
                                        <option value="{{$item->id}}" {{ $book->writer_id == $item->id ? 'selected' : '' }}>{{$item->writer_name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">শর্ট ডেসক্রিপশন</label>
                                    <textarea name="short_description" class="form-control">{{$book->short_description ? $book->short_description : old('short_description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">বইয়ের কভার ফটো</label><br>
                                    <img alt="avatar" src="@if(!empty($book->image)) {{asset('book/'.$book->image)}} @else {{ asset('book/default.png') }} @endif" width="60px" height="90px">
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="image">বইয়ের দাম</label>
                                    <input type="number" name="price" value="{{$book->price ? $book->price : old('price') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="publising_date">পাবলিশিং তারিখ</label>
                                    <input type="date" name="publising_date" value="{{$book->publising_date ? $book->publising_date : old('publising_date') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="book_of_page">বইয়ের পৃষ্টা</label>
                                    <input type="number" name="book_of_page" value="{{$book->book_of_page ? $book->book_of_page : old('book_of_page') }}" class="form-control" placeholder="বইয়ের পৃষ্টা লিখুন">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">আপডেট</button>
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