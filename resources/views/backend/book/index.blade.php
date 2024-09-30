@extends ('backend.layouts.app')

@section('title', 'Books')

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
            <li class="breadcrumb-item active">বই</li>
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
              <h3 class="card-title">বইয়ের ইনফরমেশন</h3><br>
              <div>
                <a href="{{route('boi.create')}}" class="btn btn-info"> অ্যাড বই</a>
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
                    <th>#SL</th>
                    <th>বইয়ের কভার ফটো</th>
                    <th>বইয়ের বাংলা নাম</th>
                    <th>বইয়ের ক্যাটাগরি নাম</th>
                    <th>বইয়ের লেখক নাম</th>
                    <th>প্রাইস</th>
                    <th>পাব্লিশ ডেট</th>
                    <th hidden>Book of page</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $books as $key=>$item )
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>
                      <a href="javascript:void(0)" class="avatar">
                        <img alt="avatar" src="@if(!empty($item->image)) {{ asset('book/'.$item->image) }} @else {{ asset('book/default.png') }} @endif" width="60px" height="90px">
                      </a>
                    </td>
                    <td>{{ $item->book_bangla_name }}</td>
                    <td>{{ $item->category->name }}</td>
                    <td>{{ $item->writer->writer_name }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->publising_date }}</td>
                    <td hidden>{{ $item->book_of_page }}</td>
                    <td>
                      <a class="btn btn-secondary" href="{{ route('boi.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                      <a class="btn btn-danger" href="{{ route('boi.delete', $item->id) }}" onclick="return confirm('Are you sure to delete?')"><i class="fa-solid fa-trash"></i></a>
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
