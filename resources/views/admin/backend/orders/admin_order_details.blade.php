@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Order Details</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Order Details</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card">

                        <form method="POST" action="{{ route('admin.profile.store') }}"  enctype="multipart/form-data">
                            @csrf

                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    ddddddddddd
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">User Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                   fffffffffffffffffff
                                </div>
                            </div>


                        </div> 
                    </form>


                    </div>

                </div>


<div class="col-lg-6">
    <div class="card">

        <form method="POST" action="{{ route('admin.profile.store') }}"  enctype="multipart/form-data">
            @csrf

        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    ddddddddddd
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">User Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                   fffffffffffffffffff
                </div>
            </div>



        </div> 
    </form>


    </div>



</div>
            </div>
        </div>
    </div>
</div>



@endsection