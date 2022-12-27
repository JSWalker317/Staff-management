<div class="container row">
    <h3 class='col'>{{$data['title']}}</h3>
    <div class='col d-flex justify-content-end text-primary'><b class="text-dark">Sản phẩm ></b> {{$data['title']}}
    </div>

</div>
<span id="form_output"></span>

<form  id="product_form" method="POST" enctype="multipart/form-data"> 
    @csrf
    <div class="modal-body row">

        <input type="hidden" name="id" id="id">
        <div class="col-md">
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-8">
                    <input type="text" name="product_name" id="product_name" class="form-control" placeholder="Nhập tên sản phẩm">
                    <span class="text-danger" id="error_name"></span>

                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Giá bán</label>
                <div class="col-sm-8">
                    <input type="text" name="product_price" id="product_price"  class="form-control" placeholder="Nhập giá bán">
                    <span class="text-danger" id="error_price"></span>
                    
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 form-label">Mô tả</label>
                <div class="col-sm-8 " >
                    <input type="text"  style="height: 200px;" name="description" id="description" class="form-control" placeholder="Mô tả sản phẩm">
                    <span class="text-danger" id="error_description"></span>

                </div>
                
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-4 col-form-label">Trạng thái</label>
                <div class="col-sm-8">
                    <div class="input-group" >
                        <select class="form-select form-control" name="is_sales" id="is_sales" placeholder="Chọn trạng thái">
                            <option value=""></option>
                            <option value="1">Đang bán</option>
                            <option value="0">Ngừng bán</option>
                        </select>
                    </div>
                    <span class="text-danger" id="error_status"></span>
                </div>
            </div>
          
        </div>

        <div class="col-md">
            <label for="" class="row-form-label">Hình ảnh</label>
            <div class=" row m-4">
                <img id="showPhoto" name="showPhoto"  style="height: 200px;" alt="Hình sản phẩm">
                <span class="text-danger" id="error_image"></span>
                <input type="hidden" name="img_del" id="img_del" value="0">
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <label class="btn btn-primary">
                        <input name="file_photo" id="file_photo" type="file" hidden  
                        onchange="$('#upload-file-info').val(this.files[0].name); readURL(this);" accept=".png,.jpg,.jpeg">
                        Upload
                    </label>
                </div>
                <div class="col-lg-3">
                    <input id="removeFile" class="btn btn-danger" type="button" value="Xóa file">
                </div>
                <div class="col-lg-6 mt-2">
                    <input class='label label-info' name="upload-file-info" id="upload-file-info" readonly>
                </div>
            </div>
        </div>
    </div>
  
    <div class="modal-footer">
        <!-- <input class="form-control" name="photo" type="file" id="photo"> -->
        <input type="hidden" name="button_action" id="button_action" value= "{{$data['action']}}">
        <a type="button" href="{{ route('product.products') }}" class="btn btn-danger" data-dismiss="modal">Hủy</a>
        <input type="submit" name="submit" id="action" value="Lưu" class="btn btn-primary">
    </div>
</form>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#showPhoto').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }


    function get_detail()
        {
            var id = "<?php echo $data['id']; ?>";

            // console.log(id);
            if(id != ''){
                $('#id').val(id);
                var url = '{{ route("product.show",":id")}}'
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {id: id},
                    success:function(respone){
                        console.log(respone);
                        $.each(respone, function (key, value){
                            console.log(value['product_image']);
                            $('#product_name').val(value['product_name']);
                            $('#product_price').val(value['product_price']);
                            $('#description').val(value['description']);
                            $('#is_sales').val(value['is_sales']);
                            $('#showPhoto').attr('src', value['product_image']); 
                            // $('#file_photo').val('');
                            // $('#upload-file-info').val('');
                        });
                    }
                })
            }
        }
    $(document).ready(function () {
        get_detail();
        $('#removeFile').on('click', function() {    
            // console.log('ddd');
            $('#img_del').val('1');
            $('#file_photo').val('');
            $('#upload-file-info').val('');
            $('#showPhoto').attr('src', '');

            // console.log($('#showPhoto').attr('src'));

        });

        // submit form add edit
        $('#product_form').on('submit', function (e) {
            e.preventDefault();
            // var form_data_add = $(this).serialize();
            var form = $('form')[0]; // You need to use standard javascript object here
            var formData = new FormData(form);
            
            console.log(formData);
            // ajax get file phai co encryptype mutilpart
            //After this it will send ajax request like you submit 
            //regular form with enctype="multipart/form-data"
            $.ajax({
                url: "{{ route('product.store') }}",
                _token: "{{ csrf_token() }}" ,
                data: formData,
                type: 'POST',
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                dataType: "json",
                success:function(respone){
                    console.log(respone);

                    if(respone.error.length !== 0) {

                        if(respone.error[0].product_name !== undefined){
                            $('#error_name').html('<span class="text-danger">'+
                            respone.error[0].product_name+'</span>');
                        }else {$( '#error_name').html(''); }

                        if(respone.error[0].product_price !== undefined){
                            $('#error_price').html('<span class="text-danger">'+
                            respone.error[0].product_price+'</span>');
                        }else {$( '#error_price').html(''); }

                        if(respone.error[0].is_sales !== undefined){
                            $('#error_status').html('<span class="text-danger">'+
                            respone.error[0].is_sales+'</span>');
                        }else {$( '#error_status').html(''); }

                        if(respone.error[0].file_photo !== undefined){
                            $('#error_image').html('<span class="text-danger">'+
                            respone.error[0].file_photo+'</span>');
                        }else {$( '#error_image').html(''); }
                        
                    }else {
                        $('#form_output').html('<div class="alert alert-success">'+
                        respone.success+'</div>');

                        $("#form_output").fadeTo(4000, 500).slideUp(500, function(){
                            $("#form_output").slideUp(500);
                        });
                        $('#product_form')[0].reset();
                        // $('#action').val('Add');
                        $('#error_name').html('');
                        $('#error_price').html('');
                        $('#error_status').html('');
                        $('#error_image').html('');
                        
                        window.location.reload();
                        // refresh_data();
                    }

                }
            })
        });       
    });
</script>