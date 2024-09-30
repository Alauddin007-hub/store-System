@extends ('backend.layouts.app')

@section('title', 'Binder')

@section('content')

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>বাধাইখানায় অর্ডার তালিকা</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">হোম</a></li>
            <li class="breadcrumb-item active">বাধাইখানা</li>
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
              <h3 class="card-title">বাধাইখানায় অর্ডার</h3><br>
              <div>
                <a href="{{route('binder.create')}}" class="btn btn-info"> বাধাইখানায় অর্ডার</a>
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
                    <th>বইয়ের নাম</th>
                    <th>ছাপাখানার নাম</th>
                    <th>বাধাইখানার নাম</th>
                    <th>ছাপাখানা কর্তৃক সরবরাহ বইয়ের পরিমাণ</th>
                    <th>বাধাইখানায় অর্ডারের তারিখ</th>
                    <th>অ্যাকশন</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $binder as $key=>$item )
                  <tr>
                    <td>{{++$key}}</td>
                    <td>{{ $item->book ? $item->book->book_bangla_name : 'বই পাওয়া যায়নি' }}</td>
                    <td>{{ $item->pressL ? $item->pressL->name : 'ছাপাখানার নাম পাওয়া যায়নি' }}</td>
                    <td>{{ $item->binderL ? $item->binderL->name : 'বাধাইখানার নাম পাওয়া যায়নি' }}</td>
                    <td>{{ $item->received_to_press_order }}</td>
                    <td>{{$item->created_at_formatted}}</td>
                    <td>
                      <a class="btn btn-secondary" href="{{route('binder.edit', $item->id)}}"><i class="fa-solid fa-pen-to-square"></i></a>

                      <a class="btn btn-danger" href="{{route('binder.delete', $item->id)}}" onclick="return confirm('Are you sure to delete')"><i class="fa-solid fa-trash"></i></a>
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