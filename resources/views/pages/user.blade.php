@extends('base')

@section('content')
    <h3>Users</h3>
    <span id="success"></span>

    <hr>
    <div class="container-fuild">
       
        <form id="fetchDataForm" method="GET">
        
            <div class="row">
                <div class="col-md-3">
                        <label for="inputName" class="form-label">Tên</label>
                        <input type="text" class="form-control" name="name" placeholder="Nhập họ tên">
                       
                </div>
                <div class="col-md-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Nhập email">
                      
                </div>
                <div class="col-md-3">
                        <label for="inputGroup" class="form-label">Nhóm</label>
                        <!-- <input type="text" class="form-control" id="inputGroup" placeholder="Chọn nhóm"> -->
                        <div class="input-group mb-3" >
                            <select class="form-select form-control" name="group_role" placeholder="Chọn nhóm">
                                <option value=""></option>
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
                                <option value=""></option>
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Tạm khóa</option>
                            </select>
                        </div>
                </div>
                
            </div>
            <div class="row mt-2">
                <div class="col-sm-3 ">
                    <button type="button" class="btn btn-primary add_btn" data-toggle="modal" data-target="#addEditUser"><span class="fa fa-user-plus" aria-hidden="true"></span> Thêm mới</button>
                </div>
            
                <div class=" col-sm-9 d-flex justify-content-md-end ">
                    <button type="submit" class="btn btn-primary mr-3"><span class="fa fa-search" aria-hidden="true"></span> Tìm kiếm</button>
                    <button type="button" id="cancelSearch" class="btn btn-danger"><span class="fa fa-times" aria-hidden="true"></span> Xóa tìm</button>
               
                </div>
                
            </div>
        </form>

        
    </div>

<!-- table -->
    <div class="mt-2 text-center" id="user_table">
        @include('layouts.userlist')
    </div>
  
<!-- Add Edit -->
    <div class="modal fade" id="addEditUser" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="userTitle">Add User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="user_form" method="POST">
            @csrf
            <div class="modal-body">
                <span id="form_output"></span>

                <input type="hidden" name="id" id="id">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tên</label>
                    <div class="col-sm-9">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập họ tên">
                        <span class="text-danger" id="error_name"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" name="email" id="email"  class="form-control" placeholder="Nhập email">
                        <span class="text-danger" id="error_email"></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 form-label">Mật khẩu</label>
                    <div class="col-sm-9">
                        <input type="text" name="password"  class="form-control" placeholder="Mật khẩu">
                        <span class="text-danger" id="error_pass"></span>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 form-label">Xác nhận</label>
                    <div class="col-sm-9">
                        <input type="text" name="password_confirmation"  class="form-control" placeholder="Xác nhận mật khẩu">
                        <span class="text-danger" id="error_pass_confirm"></span>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Nhóm</label>
                    <div class="col-sm-9">
                        <div class="input-group" >
                            <select class="form-select form-control" name="group_role" id="group_role" placeholder="Chọn nhóm">
                                <option value="Admin">Admin</option>
                                <option value="Editer">Editer</option>
                                <option value="Reviewer">Reviewer</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label" >Trạng thái</label>
                    <div class="col-sm-9 mt-2">
                        <div class="form-check">
                            <input type='hidden' value='0' name='status'>
                            <input class="form-check-input" type="checkbox" value="1" name="status" id="status">
                            <label class="form-check-label" for="status">
                                TRUE
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="button_action" id="button_action" class="form-control" value="" readonly>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                <input type="submit" name="submit" id="action" value="" class="btn btn-primary">
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
            <form id="delete_form" method="GET">
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" id="userId"> -->
                    

                    <div>Bạn có muốn xóa thành viên <b class="userName">User no name</b> không ?</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-danger">Delete</button>
                </div>
            </form>

            </div>
        </div>
    </div>

<!-- status -->
    <div class="modal fade" id="statusUser" tabindex="-1" aria-labelledby="UserModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UserModal">Status User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="status_form" method="GET">
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" id="userId"> -->
                    <div>Bạn có muốn <b class="lock"></b> thành viên <b class="userName">User no name</b> không ?</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-danger lock">Mở khóa</button>
                </div>
            </form>

            </div>
        </div>
    </div>
<!-- Ajax -->
<script>
    var form_data;
    function refresh_data(page)
    {
        // alert(1);
        $.ajax({
                url: 'http://localhost/user/fetchData?'+form_data+'&page='+page,
                method: "GET",
                Data: form_data,
                success:function(respone){
                    //  console.log(form_data);
                    // console.log(respone.type);
                    // if(respone == null){
                    //     // $('#bodyTable').empty().html('khong co');
                    //     $('#bodyTable').html('<div>'+
                    //     'Không có dữ liệu'+'</div>');
                    $('#user_table').empty().html(respone);

                    
                }
        })
    }
    // ajax run link not reload page
    $(document).ready(function () {
        // 
        // setInterval(function(){
        //     refresh_data();
        // }, 100000);
        $(document).on('click', '.pagination a', function(e){
            e.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            refresh_data(page);
        });
        refresh_data();
        // search
        $('#fetchDataForm').on('submit', function (e) {
            e.preventDefault();
            form_data = $(this).serialize();
            
            refresh_data();
        });
        // cancel search
        $('#cancelSearch').click(function (e) { 
            e.preventDefault();
            $('#fetchDataForm')[0].reset();
            form_data = $(this).serialize();
            refresh_data();
        });
        // 
        $('.add_btn').click(function (e) { 
            e.preventDefault();

            $('#user_form')[0].reset();
            $('#form_output').html('');
            $('#userTitle').html('Thêm User');
            $('#button_action').val('insert');
            $('#action').val('Thêm');
            // $('#status').html('TRUE');

            $('#error_name').html('');
            $('#error_email').html('');
            $('#error_pass').html('');
            $('#error_pass_confirm').html('');

            
        });
        // // document moi lay duoc id ben data-id
        $(document).on('click', '.edit_btn', function(e){
            e.preventDefault(); 
            // var id = $(this).closest('tr').find('.id').text();
            var id = $(this).data('id');

            console.log(id);
            $('#id').val(id);
            $('#user_form')[0].reset();
            $('#form_output').html('');
            $('#userTitle').html('Chỉnh sửa User');
            $('#button_action').val('update');
            $('#action').val('Cập nhật');

            $('#error_name').html('');
            $('#error_email').html('');
            $('#error_pass').html('');
            $('#error_pass_confirm').html('');  

            $.ajax({
                type: "GET",
                url: 
                "http://localhost/user/"+id
                ,
                data: {
                    
                },
                success: function (response) {
                    // console.log(response);
                    $.each(response, function (key, value){
                        // console.log(value['name']);
                        $('#name').val(value['name']);
                        $('#email').val(value['email']);
                        $('#group_role').val(value['group_role']);
                        if (value['is_active'] == 1){
                            $('#status')[0].checked = true;
                        }
                    });
        
                }
            });
        });
        // submit form add edit
        $('#user_form').on('submit', function (e) {
            e.preventDefault();
            var form_data = $(this).serialize();

            $.ajax({
                url: 'http://localhost/user/postUser',
                method: "POST",
                data: form_data,
                dataType: "json",
                success:function(respone){
                    // var err_arr = [respone.error];
                    // console.log(respone.error);
                    // console.log(Object.keys(respone.error[0]));
                    // $('#customer_name').val('eeee');
                    console.log(respone.error.length);
                    console.log(respone);

                    if(respone.error.length !== 0) {
                        $('#form_output').html('<div class="alert alert-danger">'+
                        'Customer error added'+'</div>');

                        if(respone.error[0].name !== undefined){
                            $('#error_name').html('<span class="text-danger">'+
                            respone.error[0].name+'</span>');
                        }else {$( '#error_name').html(''); }

                        if(respone.error[0].email !== undefined){
                            $('#error_email').html('<span class="text-danger">'+
                            respone.error[0].email+'</span>');
                        }else {$( '#error_email').html(''); }

                        if(respone.error[0].password !== undefined){
                            $('#error_pass').html('<span class="text-danger">'+
                            respone.error[0].password+'</span>');
                        }else {$( '#error_pass').html(''); }

                        if(respone.error[0].password_confirmation !== undefined){
                            $('#error_pass_confirm').html('<span class="text-danger">'+
                            respone.error[0].password_confirmation+'</span>');
                        }else {$( '#error_pass_confirm').html(''); }

                        
                    }else {
                        
                        $('#success').html('<div class="alert alert-success">'+
                        respone.success+'</div>');

                        $("#success").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success").slideUp(500);
                        });

                        $('#user_form')[0].reset();
                        // $('#action').val('Add');
                        $('#error_name').html('');
                        $('#error_email').html('');
                        $('#error_pass').html('');
                        $('#error_pass_confirm').html('');
                        // window.location.reload();
                        $('#addEditUser').modal('hide');

                        refresh_data();

                    }

                }
            })
        });
        // jqclick

        $(document).on('click', '.delete_btn', function(e){
            e.preventDefault();
            // var name = $(this).closest('tr').find('.name').text();
            // var id = $(this).closest('tr').find('.id').text();
            var id = $(this).data('id');
            var name = $(this).data('name');


            console.log(id);
            $('.userName').html(name);
            // $('#userId').val(id);
            $('#delete_form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'http://localhost/user/delete/'+id,
                    method: "GET",
                    // data: id,
                    dataType: "json",
                    success:function(respone){
                        console.log(respone);

                        $('#success').html('<div class="alert alert-success">'+
                        respone.success+'</div>');

                        $("#success").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success").slideUp(500);
                        });
                        $('#deleteUser').modal('hide');
                        refresh_data();

                    }
                })
            });
          
        });
        //  
        $(document).on('click', '.status_btn', function(e){
            e.preventDefault();
            // var name = $(this).closest('tr').find('.name').text();
            // var id = $(this).closest('tr').find('.id').text();
            var id = $(this).data('id');
            var name = $(this).data('name');
            var status = $(this).data('status');


            var status = $(this).closest('tr').find('.status').text();
            if (status == 'Đang hoạt động'){
                status = 'Khóa';
            }else{
                status = 'Mở khóa';
            }
            // console.log(id);
            // console.log(name);
            $('.userName').html(name);
            $('.lock').html(status);

            // $('#userId').val(id);

            $('#status_form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: 'http://localhost/user/status/'+id,
                    method: "GET",
                    // data: id,
                    dataType: "json",
                    success:function(respone){
                        console.log(respone);
                        $('#success').html('<div class="alert alert-success">'+
                        respone.success+'</div>');
                        $("#success").fadeTo(2000, 500).slideUp(500, function(){
                            $("#success").slideUp(500);
                        });
                        
                        $('#statusUser').modal('hide');
                        refresh_data();
                    }
                
                })
            });
          

        });
     // 

        });

  
</script>
<!-- @include('layouts.userlist') -->
@endsection
