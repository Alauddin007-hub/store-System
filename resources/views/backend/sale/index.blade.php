@extends ('backend.layouts.app')

@section('title', 'Sales List')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>সেলস লিস্ট</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">ট্রানসাকশান</a></li>
            <li class="breadcrumb-item active">সেলস লিস্ট</li>
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
              <h3 class="card-title">বইয়ের বিক্রয় তালিকা</h3>
              <div><br>
                <a href="{{route('transactions.create')}}" class="btn btn-info">নিউ ট্রানসাকশান</a>
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
                    <th>কাস্টমারের নাম</th>
                    <th>মোট কোয়ান্টিটি</th>
                    <th>ডিসকাউন্ট</th>
                    <th>মোট মূল্য</th>
                    <th>বই বিক্রয়ের তারিখ</th>
                    <th>প্রিন্ট</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($sales as $key => $item)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ optional($item->customer)->name ?? 'N/A' }}</td>
                    <td>{{ $item->total_quantity }}</td>
                    <td>{{ $item->discount }}</td>
                    <td>{{ $item->total_price }}</td>
                    <td>{{ $item->created_at_formatted }}</td>
                    <td>
                      <a class="btn btn-warning btn-flat" href="{{ route('transactions.invoice', $item->id) }}" target="_blank">Print invoice</a>

                      <!-- <i class="fa-solid fa-print"></i> -->
                      <!-- <i class="fa-solid fa-file-pdf"></i> -->
                    </td>
                    <td>
                    <a class="btn btn-secondary" href="{{route('transactions.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>
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