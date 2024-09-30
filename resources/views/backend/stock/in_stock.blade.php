@extends ('backend.layouts.app')

@section('title', 'Stock Detail')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>স্টকের ডিটেলস</h1>
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
              <h3 class="card-title">বইয়ের স্টকের ইনফরমেশন</h3><br>
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
                    <th>ভাউচার নং</th>
                    <th>প্রারম্ভিক স্টোকের পরিমাণ</th>
                    <th>সাপ্লায়ার</th>
                    <th>অবশিষ্ট স্টকের পরিমাণ</th>
                    <th>বিক্রয় মূল্য</th>
                    <th>স্টকের তারিখ</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $stock_detail as $key=>$item )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>
                      <a href="javascript:void(0)" class="avatar">
                        <img alt="avatar" src="@if(!empty($item->book->image)) {{ asset('book/' . $item->book->image) }} @else {{ asset('book/default.png') }} @endif" width="60px" height="90px">
                      </a>
                    </td>
                    <td>{{$item->book->book_bangla_name}}</td>
                    <td>{{$item->uni_code}}</td>
                    <td>{{$item->s_quantity}}</td>
                    <td>{{$item->binder->name ?? 'N/A'}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->created_at_formatted}}</td>
                    <td>
                      <a class="btn btn-secondary" href="{{route('stock.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>

                      <a class="btn btn-danger" href="{{route('stock.delete', $item->id)}}" onclick="return confirm('Are you sure to delete')" hidden><i class="fa-solid fa-trash"></i></a>
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