@extends('layouts.main')
@section('title', 'Cart Page')
@section('content')

<div class="checkout-area mt-100">
   <div class="container">
      <div class="row">
         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="checkout-bill-title">
               <h4>Billing address</h4>
            </div>
         </div>
      </div>
      <div class="row">

         <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
            <div class="cart-product-details-wrap checkout-product-details-wrap">

               <table id="cart" class="table table-hover table-condensed">
                   <thead>
                       <tr>
                           <th style="width:50%">Product</th>
                           <th style="width:10%">Price</th>
                           <th style="width:8%">Quantity</th>
                           <th style="width:22%" class="text-center">Subtotal</th>
                           <th style="width:10%"></th>
                       </tr>
                   </thead>
                   <tbody>
                       @php $total = 0 @endphp
                       @if(session('cart'))
                           @foreach(session('cart') as $id => $details)
                               @php $total += $details['price'] * $details['quantity'] @endphp
                               <tr data-id="{{ $id }}">
                                   <td data-th="Product">
                                       <div class="row">
                                           <div class="col-sm-3 hidden-xs"><img src="{{ $details['image'] }}" width="100" height="100" class="img-responsive"/></div>
                                           <div class="col-sm-9">
                                               <h4 class="nomargin">{{ $details['name'] }}</h4>
                                           </div>
                                       </div>
                                   </td>
                                   <td data-th="Price">${{ $details['price'] }}</td>
                                   <td data-th="Quantity">
                                       <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity update-cart" />
                                   </td>
                                   <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
                                   <td class="actions" data-th="">
                                       <button class="common-btn shop-details-review-btn btn-sm remove-from-cart">X</button>
                                   </td>
                               </tr>
                           @endforeach
                       @endif
                   </tbody>
                   <tfoot>
                       <tr>
                           <td colspan="5" class="text-right"><h3><strong>Total ${{ $total }}</strong></h3></td>
                       </tr>
                       <tr>
                           <td colspan="5" class="text-right">
                               <a href="{{ url('/shop') }}" class="common-btn shop-details-review-btn update-cart-content-btn"><i class="fa fa-angle-left"></i> Continue Shopping</a>
                               <a href="{{ url('/checkout') }}" class="common-btn shop-details-review-btn update-cart-content-btn">Checkout</a>
                           </td>
                       </tr>
                   </tfoot>
               </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $(".update-cart").change(function (e) {
        e.preventDefault();

        var ele = $(this);

        $.ajax({
            url: '{{ route('update.cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function (response) {
               window.location.reload();
            }
        });
    });

    $(".remove-from-cart").click(function (e) {
        e.preventDefault();

        var ele = $(this);

        if(confirm("Are you sure want to remove?")) {
            $.ajax({
                url: '{{ route('remove.from.cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id")
                },
                success: function (response) {
                    window.location.reload();
                }
            });
        }
    });
 });
</script>

@endsection
