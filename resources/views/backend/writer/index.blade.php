@extends ('backend.layouts.app')

@section('title', 'Writer')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>লেখকের তালিকা</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">হোম</a></li>
            <li class="breadcrumb-item active">লেখক</li>
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
              <h3 class="card-title">লেখকের ইনফরমেশন</h3><br>
              <div>
                <a href="{{route('lekhok.create')}}" class="btn btn-info"> অ্যাড লেখক</a>
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
                    <th>লেখক ফটো</th>
                    <th>লেখক নাম</th>
                    <th>শর্ট ডেসক্রিপশন</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $lekhok as $key=>$item )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>
                    <a href="javascript:void(0)" class="avatar"><img alt="avatar" src="@if(!empty($item->image)) {{asset('writer/'.$item->image)}} @else {{asset('writer/default.png ')}}@endif" width="60px" height="90px"></a>
                    </td>
                    <td>{{$item->writer_name}}</td>
                    <td>{{$item->short_description}}</td>
                    <td>
                      <a class="btn btn-secondary" href="{{route('lekhok.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>

                      <a class="btn btn-danger" href="{{route('lekhok.delete', $item->id)}}" onclick="return confirm('Are you sure to delete')"><i class="fa-solid fa-trash"></i></a>
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