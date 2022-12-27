
@if ($products->count() > 0) 
    <div class="table-responsive">
    {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
        <table class="table table-bordered table-striped">
            <thead class="bg-danger text-light">
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Tình trạng</th>
                    <th width="10%"></th>
                </tr>
            </thead>
            
            <tbody id="productList">
                @foreach($products as $key => $value)
                    <tr>
                        <th class="product_id" style="vertical-align: middle;">{{$value['product_id']}}</th>
                        <td class="preview">{{$value['product_name']}}
                            <img src="{{ asset($value['product_image']) }}" 
                            style="display: none; z-index: 100; position: absolute;"
                            width="100" height="100" />
                        </td>

                        <td>{{$value['description']}}</td>
                        <td>${{$value['product_price']}}</td>
                        @if($value['is_sales'] == 1)
                            <td class="text-success status">Đang bán</td>
                        @else
                            <td class="text-danger status">Ngưng bán</td>
                        @endif
                        <td>
                            <a href="" class="mr-3 edit_btn" title="Update Record" data-id="{{$value['product_id']}}" data-name="{{$value['product_name']}}" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                            <a href="" class="delete_btn" title="Delete Record" data-id="{{$value['product_id']}}" data-name="{{$value['product_name']}}" data-toggle="modal" data-target="#deleteProduct"><span class="fa fa-trash" style="color:red"></span></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    </div>  
@else
        <b>Oops! Không có dữ liệu</b>
@endif

<script>
    $(document).ready(function() {
        $(".preview").hover(function() {
            $(this).find('img').fadeIn();
        }, function() {
            $(this).find('img').fadeOut();
        });
    });

</script>
