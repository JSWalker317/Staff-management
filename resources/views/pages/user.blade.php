@extends('base')

@section('content')
    <h3>Users</h3>
    <hr>
    <div class="container-fuild">
        @if($message = Session::get('success'))
        <div class="alert alert-success" id="success-alert">
            {{ $message }}
        </div>
        @endif
        <form action="#" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3">
                        <label for="inputName" class="form-label">Tên</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập họ tên">
                       
                </div>
                <div class="col-md-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Nhập email">
                      
                </div>
                <div class="col-md-3">
                        <label for="inputGroup" class="form-label">Nhóm</label>
                        <!-- <input type="text" class="form-control" id="inputGroup" placeholder="Chọn nhóm"> -->
                        <div class="input-group mb-3" >
                            <select class="form-select form-control" name="group_role" placeholder="Chọn nhóm">
                                <option value="Admin">Admin</option>
                                <option value="Editer">Editer</option>
                                <option value="Reviewer">Reviewer</option>
                            </select>
                        </div>
                </div>
                <div class="col-md-3">
                        <label for="inputStatus" class="form-label">Trạng thái</label>
                        <!-- <input type="text" class="form-control" id="inputStatus" placeholder="Chọn trạng thái"> -->
                        <div class="input-group mb-3" >
                            <select class="form-select form-control" name="is_active" placeholder="Chọn trạng thái">
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Tạm khóa</option>
                            </select>
                        </div>
                </div>
                
            </div>
            <div class="row mt-2">
                <div class="col-sm-3 ">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUser"><span class="fa fa-user-plus" aria-hidden="true"></span> Thêm mới</button>
                </div>
            
                <div class="modal-footer col-sm-9 d-flex justify-content-md-end ">
                    <button type="submit" class="btn btn-primary mr-3"><span class="fa fa-search" aria-hidden="true"></span> Tìm kiếm</button>
                    <button type="button" class="btn btn-danger"><span class="fa fa-times" aria-hidden="true"></span> Xóa tìm</button>
               
                </div>
                
            </div>
        </form>
       
        
    </div>
    <div class="position-relative">
            <div class="d-flex justify-content-sm-center">
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
            </div>
            <div class="position-absolute  translate-middle">
                Hiển thị từ 1 ~ 10 trong tổng số 100 user
            </div>
          
    </div>
    <div class="mt-2 text-center">
            @if ($users != null) 
                <table class="table table-bordered table-striped">
                    <thead class="bg-danger text-light">
                        <tr>
                            <th>#</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Nhóm</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($users as $key => $value)
                        <tr>
                            <th class="id">{{$value['id']}}</th>
                            <td>{{$value['name']}}</td>
                            <td>{{$value['email']}}</td>
                            <td>{{$value['group_role']}}</td>
                            @if($value['is_active'] == 1)
                                <td class="text-success">Đang hoạt động</td>
                            @else
                                <td class="text-danger">Tạm khóa</td>
                            @endif
                            
                            <td>
                                <a href="" class="mr-3 edit_btn" title="Edit Record" data-toggle="modal" data-target="#editUser"><span class="fa fa-pencil "></span></a>
                                <a href="" class="mr-3 delete_btn" title="Delete Record" data-toggle="modal" data-target="#deleteUser"><span class="fa fa-trash" style="color:red"></span></a>
                                <a href="http://localhost/user/status/{{$value['id']}}" class="lock_btn" title="Lock Record" data-toggle="tooltip"><span class="fa fa-user-times" style="color:black"></span></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    
            
            @else
                <span>Oops! Something went wrong. Please try again later</span>
            @endif

    </div>

    <div class="d-flex justify-content-sm-center">
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
    </div>





<!-- Ajax -->
<script>
      $(document).ready(function () {
        $('.edit_btn').click(function (e) { 
            e.preventDefault();
            
            var id = $(this).closest('tr').find('.id').text();
            console.log(id);
            $('#edit_id').val(id);             

            // $.ajax({
            //     type: "GET",
            //     url: 
            //     "http://localhost/user/"+id
            //     ,
            //     data: {
            //         'id': id,
            //     },
            //     success: function (response) {
            //         console.log(response);
        
            //     }
            // });
        });
        // jqclick
        $('.delete_btn').click(function (e) { 
            e.preventDefault();
            var id = $(this).closest('tr').find('.id').text();
            console.log(id);
            $('#delete_id').val(id);             
        });

        $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
    });
</script>

<!-- Add -->
    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Add User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="http://localhost/user/store" method="POST">
            @csrf
            <div class="modal-body">
            
                <!-- <input type="hidden" name="pId" id="edit_pId"> -->
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tên</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" id="edit_pName" class="form-control" placeholder="Nhập họ tên">
                        @error('name')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" id="edit_pCategory" class="form-control" placeholder="Nhập email">
                        @error('email')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 form-label">Mật khẩu</label>
                    <div class="col-sm-9">
                        <input type="text" name="password" id="edit_pImage" class="form-control" placeholder="Mật khẩu">
                        @error('password')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 form-label">Xác nhận</label>
                    <div class="col-sm-9">
                        <input type="text" name="password_confirmation" id="edit_pImage" class="form-control" placeholder="Xác nhận mật khẩu">
                        @error('password_confirmation')
                            <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Nhóm</label>
                    <div class="col-sm-9">
                        <div class="input-group" >
                            <select class="form-select form-control" name="group_role" placeholder="Chọn nhóm">
                                <option value="Admin">Admin</option>
                                <option value="Editer">Editer</option>
                                <option value="Reviewer">Reviewer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Trạng thái</label>
                    <div class="col-sm-9 mt-2">
                        TRUE
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>

        </div>
    </div>
    </div>
<!-- Edit -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModal">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="http://localhost/user/edit" method="POST">
                @csrf
                <div class="modal-body">
                
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Tên</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" id="edit_pName" class="form-control" placeholder="Nhập họ tên">
                            @error('name')
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" name="email" id="edit_pCategory" class="form-control" placeholder="Email" readonly>
                            @error('email')
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 form-label">Mật khẩu</label>
                        <div class="col-sm-9">
                            <input type="text" name="password" id="edit_pImage" class="form-control" placeholder="Mật khẩu">
                            @error('password')
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 form-label">Xác nhận</label>
                        <div class="col-sm-9">
                            <input type="text" name="password_confirmation" id="edit_pImage" class="form-control" placeholder="Xác nhận mật khẩu">
                            @error('password_confirmation')
                                <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Nhóm</label>
                        <div class="col-sm-9">
                            <div class="input-group" >
                                <select class="form-select form-control" name="group_role" placeholder="Chọn nhóm">
                                    <option value="Admin">Admin</option>
                                    <option value="Editer">Editer</option>
                                    <option value="Reviewer">Reviewer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Trạng thái</label>
                        <div class="col-sm-9 mt-2">
                            TRUE
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>

            </div>
        </div>
    </div>
<!-- delete -->
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModal">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="http://localhost/user/delete" method="GET">
                <div class="modal-body">
                    <input type="hidden" name="id" id="delete_id">
                    <h3>Are you sure to delete this User</h3>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-danger">Delete</button>
                </div>
            </form>

            </div>
        </div>
    </div>


@endsection
