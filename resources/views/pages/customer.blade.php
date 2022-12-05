@extends('base')

@section('content')
    <h3>Customer</h3>
    <hr>
    <div class="container-fuild">
        <span id="form_output"></span>

        <form id="fetchDataForm" method="GET">
            <div class="row">
                <div class="col-sm-3">
                        <label for="inputName" class="form-label">Tên</label>
                        <input type="text" class="form-control" name="customer_name" placeholder="Nhập họ tên">
                       
                </div>
                <div class="col-sm-3">
                        <label for="inputEmail" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Nhập email">
                      
                </div>
            
                <div class="col-sm-3">
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

                <div class="col-sm-3">
                        <label for="" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ">
                      
                </div>
                
            </div>
            <div class="row mt-2 ">
                <div class="col-md-6 mb-2">
                    <button type="button" name='add' id="add_customer" class="btn btn-primary" data-toggle="modal" data-target="#addEditCustomer"><span class="fa fa-user-plus" aria-hidden="true"></span> Thêm mới</button>
                    <button type="button" name='importCSV' id="import_CSV" class="btn btn-success" ><span class="fa fa-upload" aria-hidden="true"></span> Import CSV</button>
                    <button type="button" name='exportCSV' id="import_CSV" class="btn btn-success" ><span class="fa fa-download" aria-hidden="true"></span> Export CSV</button>

                </div>
            
                <div class=" col-md-6 d-flex justify-content-md-end mb-2">
                    <button type="submit" class="btn btn-primary mr-3"><span class="fa fa-search" aria-hidden="true"></span> Tìm kiếm</button>
                    <button type="button" id="cancelSearch" class="btn btn-danger"><span class="fa fa-times" aria-hidden="true"></span> Xóa tìm</button>
               
                </div>
                
            </div>
        </form>
       
        
    </div>
    <div class="row mt-2" >
            <div class="col-4"></div>
            <div class="col-4 d-flex justify-content-center">
                {{ $customers->links() }}
            </div>
            <div class="col-4 d-flex justify-content-end">
                <div class="hint-text">Showing <b>{{$customers->count()}}</b> out of <b>{{$customers->total()}}</b> entries</div>
                <!-- Hiển thị từ 1 ~ 10 trong tổng số 100 user -->
            </div>        
            <!-- {!! $customers->appends(Request::all())->links() !!} -->
            <!-- {!! $customers->appends(['sort' => 'votes'])->links() !!} -->

            <!-- <div class="clearfix">
                
            </div> -->
    </div>

    <!-- table -->
    <div class="mt-2 text-center">
            <table class="table table-bordered table-striped">
                <thead class="bg-danger text-light">
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Điện thoại</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody id="customerList">
                    <!-- @foreach($customers as $key => $value)
                    <tr>
                        <th class="customer_id">{{$value['customer_id']}}</th>
                        <td>{{$value['customer_name']}}</td>
                        <td>{{$value['email']}}</td>
                        <td>{{$value['address']}}</td>
                        <td>{{$value['tel_num']}}</td>
                        <td>
                            <a href="" class="mr-3 edit_btn" name='edit' id="edit_customer" title="Edit Customer" data-toggle="modal" data-target="#addEditCustomer"><span class="fa fa-pencil"></span></a>
                       </td>
                    </tr>
                    @endforeach -->
                </tbody>
            </table>
                  
        <div class="d-flex justify-content-center">
            {{ $customers->links() }}
        </div>

    </div>
  
    <!-- {!! $customers->withQueryString()->links('pagination::bootstrap-5') !!} -->

    <!-- add/edit -->
    <div class="modal fade" id="addEditCustomer" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="customerModalLabel">Add</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="customer_form" method="POST"> 
            @csrf
            <div class="modal-body">
                <input type="hidden" name="customer_id" id="customer_id">
                <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label">Tên</label>
                    <div class="col-sm-9">
                        <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="Nhập họ tên">
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
                    <label for="" class="col-sm-3 form-label">Điện thoại</label>
                    <div class="col-sm-9">
                        <input type="text" name="tel_num" id="tel_num" class="form-control" placeholder="Điện thoại">
                            <span class="text-danger" id="error_tel_num"></span>
                    </div>
                    
                </div>
                <div class="form-group row">
                    <label for="" class="col-sm-3 form-label">Địa chỉ</label>
                    <div class="col-sm-9">
                        <input type="text" name="address" id="address"  class="form-control" placeholder="Địa chỉ">
                            <span class="text-danger" id="error_address"></span>
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
                <input type="hidden" name="button_action" id="button_action" value="">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                <input type="submit" name="submit" id="action" value="" class="btn btn-primary">
            </div>
        </form>

        </div>
    </div>
    </div>

<script>
    // ajax run link not reload page
    // jqclick
    var form_data;
    function refresh_data()
    {
        // alert(1);
        $.ajax({
            url: 'http://localhost/customer/fetchData?'+form_data,
            method: "GET",
            Data: form_data,
            success:function(respone){
                //  console.log(form_data);
                $('#customerList').empty().html(respone);  
            }
        })
    }

    $(document).ready(function () {
        // setInterval(function(){
        //     $.ajax({
        //         url:'/customer',
        //         type:'GET',
        //         dataType:'json',
        //         success:function(response){
        //             if(response.customers.length>0){
        //                 var customers ='';
        //                 for(var i=0; i<response.customers.length; i++){
        //                     // console.log(response);
        //                     customers=customers+'<li>'+response.customers[i]['customer_id']+'</li>';
                            

                            
        //                 }
        //                 $('#customerList').empty();
        //                 $('#customerList').append(customers);
        //             }
        //         },error:function(err){

        //         }
        //     })
        // }, 5000);
        refresh_data();
        $('#fetchDataForm').on('submit', function (e) {
            e.preventDefault();
            form_data = $(this).serialize();
            // console.log(form_data);

            refresh_data();
        });
        // cancel search
        $('#cancelSearch').click(function (e) { 
            e.preventDefault();
            $('#fetchDataForm')[0].reset();
            form_data = $(this).serialize();
            refresh_data();
        });
        // set click add
        $('#add_customer').click(function (e) { 
            e.preventDefault();
            $('#customer_form')[0].reset();
            $('#form_output').html('');
            $('#customerModalLabel').html('Add Customer');
            $('#button_action').val('insert');
            $('#action').val('Add');

            $('#error_name').html('');
            $('#error_email').html('');
            $('#error_tel_num').html('');
            $('#error_address').html('');

        });
        // set click edit // set class, vi set id khong lay dc customer_id
        $(document).on('click', '.edit_btn', function(e){
            e.preventDefault();
            // console.log(customer_id);
            // var customer_id = $(this).closest('tr').find('.customer_id').text();
            // console.log(customer_id);
            var customer_id = $(this).data('customer_id');

            $('#customer_form')[0].reset();
            $('#form_output').html('');
            $('#customerModalLabel').html('Edit Customer');
            $('#button_action').val('update');
            $('#action').val('Update');

            $('#error_name').html('');
            $('#error_email').html('');
            $('#error_tel_num').html('');
            $('#error_address').html('');

            $.ajax({
                url: 'http://localhost/customer/'+customer_id,
                method: "GET",
                data: customer_id,
                dataType: "json",
                success:function(response){
                    // console.log(respone);
                    $.each(response, function (key, value){
                        // console.log(key);
                        // console.log(value);
                        $('#customer_id').val(value['customer_id']);
                        $('#customer_name').val(value['customer_name']);
                        $('#email').val(value['email']);
                        $('#tel_num').val(value['tel_num']);
                        $('#address').val(value['address']);
                        if (value['is_active'] == 1){
                            $('#status')[0].checked = true;
                        }
                    });
                }
            })
            // 
        });
        // submit form add
        $('#customer_form').on('submit', function (e) {
            e.preventDefault();
            var form_data = $(this).serialize();

            $.ajax({
                url: 'http://localhost/customer/postCustomer',
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

                        if(respone.error[0].customer_name !== undefined){
                            $('#error_name').html('<span class="text-danger">'+
                            respone.error[0].customer_name+'</span>');
                        }else {$( '#error_name').html(''); }

                        if(respone.error[0].email !== undefined){
                            $('#error_email').html('<span class="text-danger">'+
                            respone.error[0].email+'</span>');
                        }else {$( '#error_email').html(''); }

                        if(respone.error[0].tel_num !== undefined){
                            $('#error_tel_num').html('<span class="text-danger">'+
                            respone.error[0].tel_num+'</span>');
                        }else {$( '#error_tel_num').html(''); }

                        if(respone.error[0].address !== undefined){
                            $('#error_address').html('<span class="text-danger">'+
                            respone.error[0].address+'</span>');
                        }else {$( '#error_address').html(''); }
                        
                    }else {
                        $('#form_output').html('<div class="alert alert-success">'+
                        respone.success+'</div>');

                        $("#form_output").fadeTo(2000, 500).slideUp(500, function(){
                            $("#form_output").slideUp(500);
                        });
                        // $('#customer_form')[0].reset();
                        // $('#action').val('Add');
                        $('#error_name').html('');
                        $('#error_email').html('');
                        $('#error_tel_num').html('');
                        $('#error_address').html('');
                        // window.location.reload();
                        $('#addEditCustomer').modal('hide');

                        refresh_data();

                    }

                }
            })
        });
        

      
    
    });
</script>
@endsection
