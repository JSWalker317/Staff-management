@extends('base')

@section('content')
<div id="product_container">

    <h3>Sản Phẩm</h3>
 
    <hr>
    <div class="container-fuild">
        <span id="form_output"></span>

        <form id="fetchDataForm" method="GET">
            <div class="row">
                <div class="col-md-6 row">
                        <div class="col-md-6">
                            <label for="inputName" class="form-label">Tên</label>
                            <input type="text" class="form-control" name="product_name" placeholder="Nhập tên sản phẩm">
                        </div>
                        <div class="col-md-6">
                            <label for="inputStatus" class="form-label">Trạng thái</label>
                            <!-- <input type="text" class="form-control" id="inputStatus" placeholder="Chọn trạng thái"> -->
                            <div class="input-group mb-3" >
                                <select class="form-select form-control" name="is_sales" placeholder="Chọn trạng thái">
                                    <option value=""></option>
                                    <option value="1">Đang bán</option>
                                    <option value="0">Ngưng bán</option>
                                </select>
                            </div>
                        </div>                              
                </div>
                <div class="col-md-6 row">
                    <div class="col"> 
                        <label for="" class="form-label">Giá bán từ</label>
                        <input type="text" class="form-control" name="price_from">
                    </div>
                    <div class="col">
                        <label for="" class="form-label">Giá bán đến</label>
                        <input type="text" class="form-control" name="price_to">
                    </div>
                        
                </div>
                
            </div>
            <div class="row mt-2">
                <div class="col-sm-3 ">
                    <button type="button" name='add' id="add_product" class="btn btn-primary"><span class="fa fa-user-plus" aria-hidden="true"></span> Thêm mới</button>
                </div>
            
                <div class=" col-sm-9 d-flex justify-content-md-end ">
                    <button type="submit" class="btn btn-primary mr-3"><span class="fa fa-search" aria-hidden="true"></span> Tìm kiếm</button>
                    <button type="button" id="cancelSearch" class="btn btn-danger"><span class="fa fa-times" aria-hidden="true"></span> Xóa tìm</button>
               
                </div>
            </div>
        </form>
       
        
    </div>

    <div class="row mt-2 clearfix" >

            <!-- <div class="col-4"></div>
            <div class="col-4 d-flex justify-content-center">
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
                    <button>1</button>
            </div>
            <div class="col-4 d-flex justify-content-end">
                Hiển thị từ 1 ~ 10 trong tổng số 100 user
            </div>         -->
    </div>

    <!-- table -->
    <div class="mt-2 text-center" id="product_table">
        @include('layouts.productlist')
    </div>

</div>
  
    <!-- delete -->
    <div class="modal fade" id="deleteProduct" tabindex="-1" aria-labelledby="deleteProductModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModal">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="delete_form" method="GET">
                <div class="modal-body">
                    <!-- <input type="hidden" name="id" id="userId"> -->
                    

                    <div>Bạn có muốn xóa sản phẩm <b class="productName">Product no name</b> không ?</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit"  class="btn btn-danger">Xóa</button>
                </div>
            </form>

            </div>
        </div>
    </div>


    <script>
        // ajax run link not reload page
        var form_data ;
        function refresh_data(page)
        {
            // alert(1);
            $.ajax({
                url: 'http://localhost/product/fetchData?'+form_data+'&page='+page,
                method: "GET",
                data: {form_data : form_data},
                success:function(respone){
                    // console.log(respone);
                    // console.log(form_data);
                    $('#product_table').empty().html(respone);  
                }
            })
        }
        
        $(document).ready(function () {
            $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                refresh_data(page);
            });
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

            $(document).on('click', '.delete_btn', function(e){
                e.preventDefault();
                // var name = $(this).closest('tr').find('.name').text();
                // var id = $(this).closest('tr').find('.id').text();
                var id = $(this).data('id');
                var name = $(this).data('name');

                console.log(id);
                $('.productName').html(name);
                // $('#userId').val(id);
                $('#delete_form').on('submit', function (e) {
                    e.preventDefault();
                    $.ajax({
                        url: 'http://localhost/product/delete/'+id,
                        method: "GET",
                        data: {id: id},
                        dataType: "json",
                        success:function(respone){
                            console.log(respone);

                            $('#form_output').html('<div class="alert alert-success">'+
                            respone.success+'</div>');

                            $("#form_output").fadeTo(2000, 500).slideUp(500, function(){
                                $("#form_output").slideUp(500);
                            });

                            $('#deleteProduct').modal('hide');
                            refresh_data();

                        }
                    })
                });
          
            });
            // // set form add
            $('#add_product').click(function (e) { 
                e.preventDefault();

                $('#form_output').html('');
                var action = 'insert';
                var title = 'Thêm sản phẩm';

                // console.log(action);
                $.ajax({
                    url: 'http://localhost/product/getViewPost',
                    method: "GET",
                    data: {
                        action: action,
                        title: title
                    },
                    success:function(respone){
                        // console.log(respone.action);
                        // $.each(respone, function(k, v) {
                        //     console.log(v);
                        // });
                        $('#product_container').empty().html(respone);  
                    }
                });
            });

            $(document).on('click', '.edit_btn', function(e){
                e.preventDefault();
                $('#form_output').html('');
                var id = $(this).data('id');
                var action = 'update';
                var title = 'Chỉnh sửa sản phẩm';

                // console.log(action);
                $.ajax({
                    url: 'http://localhost/product/getViewPost',
                    method: "GET",
                    data: {
                        action: action,
                        id: id,
                        title: title
                    },
                    success:function(respone){
                        // console.log(respone.action);
                        // $.each(respone, function(k, v) {
                        //     console.log(v);
                        // });
                        $('#product_container').empty().html(respone);  
                    }
                });

            });
           
            $("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
        });
    </script>
@endsection

