@extends ('backend.layouts.app')

@section('title', 'Add Writer')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>লেখক</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">এডিট লেখক</li>
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
                            <h3 class="card-title">এডিট লেখক</h3>
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
                        <form method="post" action="{{ route('lekhok.update',$lekhok->id) }}" enctype="multipart/form-data">

                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">লেখকের নাম</label>
                                    <input type="text" name="writer_name" value="{{$lekhok->writer_name ? $lekhok->writer_name : old('writer_name') }}" class="form-control" placeholder="লেখকের নাম লিখুন">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">লেখকের ছবি</label><br>
                                    <img alt="avatar" src="@if(!empty($lekhok->image)) {{asset('writer/'.$lekhok->image)}} @else {{ asset('writer/default.png')}} @endif" width="60px" height="90px">
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">শর্ট ডেসক্রিপশন</label>
                                    <textarea name="short_description" class="form-control">{{$lekhok->short_description ? $lekhok->short_description : old('short_description') }}</textarea>
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

