@extends ('backend.layouts.app')

@section('title', 'supplier')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>সরবরাহকারীর তালিকা</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">হোম</a></li>
            <li class="breadcrumb-item active">সরবরাহকারী</li>
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
              <h3 class="card-title">সরবরাহকারী</h3><br>
              <div>
                <a href="{{route('supplier.create')}}" class="btn btn-info"> অ্যাড সরবরাহকারী</a>
              </div>
            </div>

            @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>#SL</th>
                    <th>ছাপাখানার নাম</th>
                    <th>বইয়ের নাম</th>
                    <th>ছাপাখানায় প্রদত্ত অর্ডার</th>
                    <th>বাধাইকারীর কাছে প্রেরণ(নাম)</th>
                    <!-- <th>বাধাইকারীর কাছে প্রেরণ অর্ডার</th> -->
                    <th>বাধাইকারীর কাছে সরবরাহকৃত বই</th>
                    <th>সরবরাহ করা বাকি আছে</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $details as $key=>$item )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>{{$item->printing_press_name}}</td>
                    <td>{{$item->book->book_bangla_name}}</td>
                    <td>{{$item->order_printing_press}}</td>
                    <td>{{$item->send_to_binder_name}}</td>
                    <!-- <td>{{$item->total_send_order_quantity}}</td> -->
                    <td>{{$item->supplied_from_Binder}}</td>
                    <td>{{$item->rest_of_supply}}</td>
                    <td>
                      <a class="btn btn-secondary" href="{{route('supplier.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>

                      <a class="btn btn-danger" href="{{route('supplier.delete', $item->id)}}" onclick="return confirm('Are you sure to delete')"><i class="fa-solid fa-trash"></i></a>
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