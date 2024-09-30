@extends ('backend.layouts.app')

@section('title', 'Add Press')

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
                    <h1>ছাপাখানা</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">বইয়ের ছাপাখানা</li>
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
                            <h3 class="card-title">বইয়ের ছাপাখানা</h3>
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
                        <form method="post" action="{{ route('press.store') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="book_id">বইয়ের নাম</label>
                                    <select name="book_id" class="form-control select2" id="">
                                        <option disabled selected>বইয়ের নাম সিলেক্ট করুন</option>
                                        @foreach($book as $item)
                                        <option value="{{$item->id}}" {{ old('book_id') == $item->id ? 'selected' : '' }}>{{$item->book_bangla_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="printing_list_id">ছাপাখানার নাম</label>
                                    <select name="printing_list_id" class="form-control select2">
                                        <option disabled selected>ছাপাখানার নাম সিলেক্ট করুন</option>
                                        @foreach($press as $item)
                                        <option value="{{$item->id}}" {{ old('printing_list_id') == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="received_order">ছাপাখানায় প্রদত্ত অর্ডার</label>
                                    <input type="number" name="received_order" value="{{old('received_order')}}" class="form-control" placeholder="ছাপাখানায় প্রদত্ত অর্ডার কোয়ান্টিটি লিখুন">
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

<script src="{{asset('assets/ajax/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

@endsection