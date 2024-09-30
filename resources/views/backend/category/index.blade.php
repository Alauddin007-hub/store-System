@extends ('backend.layouts.app')

@section('title', 'Category')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>ক্যাটেগরীজ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">হোম</a></li>
                        <li class="breadcrumb-item active">ক্যাটাগরি</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header ">
                            <h3 class="card-title">ক্যাটাগরি ডিটেলস</h3><br>
                            <div>
                                <a href="{{route('category.create')}}" class="btn btn-info"> অ্যাড ক্যাটাগরি</a>
                            </div>
                        </div>

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#SL</th>
                                        <th>ক্যাটাগরি নাম</th>
                                        <th>ডেসক্রিপশন</th>
                                        <th>অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $cats as $key=>$item )
                                    <tr>
                                        <td>{{++$key}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->short_description}}</td>
                                        <td>
                                            <a class="btn btn-secondary" href="{{route('category.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>

                                            <a class="btn btn-danger" href="{{route('category.delete', $item->id)}}" onclick="return confirm('Are you sure to delete')"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection