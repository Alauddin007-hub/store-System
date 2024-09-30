@extends ('backend.layouts.app')

@section('title', 'Add Customer')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>কাস্টমার</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">অ্যাড কাস্টমার</li>
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
                            <h3 class="card-title">অ্যাড কাস্টমার </h3>
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
                        <form method="post" action="{{ route('customer.store') }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">কাস্টমারের নাম</label>
                                    <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="কাস্টমারের নাম লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">ফোন নম্বর</label>
                                    <input type="text" name="phone" value="{{old('phone')}}" placeholder="ফোন নম্বর লিখুন" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">ঠিকানা</label>
                                    <textarea name="address" class="form-control">{{old('address')}}</textarea>
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

