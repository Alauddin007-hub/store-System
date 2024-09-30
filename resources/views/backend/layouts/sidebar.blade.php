@php

//$user_type = Auth::user()->user_type;
//dd($user_type);

//$redirecturl = 'user.dashboard';

//switch($user_type){
# super admin
//case 1 :
//$redirecturl = 'superadmin.dashboard';
//break;
# admin
//case 2 :
//$redirecturl = 'admin.dashboard';
//break;
//default:
//$redirecturl = 'user.dashboard';
//break;
//}

@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
        <img src="{{asset('')}}assets/logo/logo8.jpg" alt="SM-System" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Siddikia Publication</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image">
                <img src="{{asset('')}}assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div> -->
            <div class="info">
                <a href="" class="d-block text-center">{{ Auth::user()->name ?? 'N/A' }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            @if(Auth::user()->user_type_id == 1)
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                            with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="" class="nav-link active">
                        <!-- <i class="nav-icon fas fa-solid fa-tachometer-alt"></i> -->
                        <i class="nav-icon fas fa-solid fa-gauge-high"></i>
                        <p>
                            ড্যাশবোর্ড
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                </li>

                <li class="nav-item">
                    <a href="{{route('lekhok.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-pen-nib"></i>
                        <p>
                            লেখক
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <!-- <i class="nav-icon fas fa-copy"></i> -->
                        <i class="nav-icon fas fa-solid fa-layer-group"></i>
                        <p>
                            ক্যাটাগরি
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('categories')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ক্যাটাগরি লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('category.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড ক্যাটাগরি</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-book"></i>
                        <!-- <i class="fa-solid fa-book"></i>boi -->
                        <p>
                            বই
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('boi')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বই লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('boi.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড বই</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-book"></i>
                        <!-- <i class="fa-solid fa-book"></i>boi -->
                        <p>
                            ছাপাখানা
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('press_list.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ছাপাখানা লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('press_list.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>এ্যাড ছাপাখানা</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('press.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ছাপাখানায় অর্ডার লিস্ট</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('press.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>ছাপাখানায় অর্ডার</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-brands fa-supple"></i>
                        <!-- <i class="fa-solid fa-book"></i>boi -->
                        <p>
                            বাধাইখানা (সরবরাহকারী)
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('binder_list.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বাধাইখানার লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('binder_list.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>এ্যাড বাধাইখানা</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('binder.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বাধাইখানায় অর্ডার ডিটেইলস</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('total.binder')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বর্তমান বাধাইখানায় অর্ডার পরিমাণ</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('binder.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বাধাইখানায় অর্ডার</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item" hidden>
                    <a href="#" class="nav-link">
                        <i class="fa-brands fa-supple"></i>
                        <p>
                            সরবরাহকারী
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('supplier.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>সরবরাহকারীর লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('supplier.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড সরবরাহকারী</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-store"></i>
                        <!-- <i class="fa-solid fa-store"></i> -->
                        <p>
                            স্টক
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('store.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড স্টক</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('nonbinder.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড স্টক(নন-বাইন্ডার)</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('stockDetails')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>স্টক ডিটেইলস</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('stocks')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>বর্তমান স্টকের পরিমাণ</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <!-- <i class="nav-icon fas fa-copy"></i> -->
                        <i class="nav-icon fas fa-duotone fa-person"></i>
                        <p>
                            কাস্টমার
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('customers')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>কাস্টমার লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('customer.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>অ্যাড কাস্টমার</p>
                                <!-- <span class="right badge badge-danger">New</span> -->
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            সেলস
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('transactions.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>সেলস লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('transactions.today')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>আজকের সেলস লিস্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('transactions.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>নিউ ট্রানসাকশান</p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item" hidden>
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            রিপোর্ট
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('reports.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>সেলস রিপোর্ট</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>স্টক রিপোর্ট</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" hidden>
                    <a href="" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-users"></i>
                        <!-- <i class="fa-solid fa-users"></i> -->
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage User Role</p>

                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
            @elseif(Auth::user()->user_type_id == 2)


            @elseif(Auth::user()->user_type_id == 3)


            @endif


        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>