@extends ('backend.layouts.app')

@section('title', 'Available Stock')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>এভেইলেবল স্টক</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">হোম</a></li>
            <li class="breadcrumb-item active">স্টক</li>
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
              <h3 class="card-title">বইয়ের স্টক</h3><br>
              <div>
                <a href="{{route('store.create')}}" class="btn btn-info">রিস্টোর</a>
              </div>
            </div>

            @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
            @endif

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
                    <th>ক্রম</th>
                    <th>কভার</th>
                    <th>বইয়ের নাম</th>
                    <th>মোট বইয়ের পরিমাণ </th>
                    <th>মোট দাম</th>
                    <th>সর্বশেষ স্টকের তারিখ</th>
                    <!-- <th>Status</th> -->
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $stock as $key=>$item )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>
                      <a href="javascript:void(0)" class="avatar">
                        <img alt="avatar" src="@if(!empty($item->book->image)) {{ asset('book/' . $item->book->image) }} @else {{ asset('book/default.png') }} @endif" width="60px" height="90px">
                      </a>
                    </td>
                    <td>{{$item->book->book_bangla_name}}</td>
                    <td>{{$item->total_quantity}}</td>
                    <td>{{$item->total_price}}</td>
                    <td>{{$item->created_at_formatted}}</td>
                    <!-- <td>{{$item->status}}</td> -->
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