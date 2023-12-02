@extends('delivery_user.layouts.master')

@section('title', 'Order Detail')

@section('main-content')
<div class="card">
    <h5 class="card-header">Order Edit</h5>
    <div class="card-body">
        <form action="{{ route('delivery_user.order.orderUpdate', $order->id) }}" method="POST" id="orderForm">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="status">Status :</label>
                <select name="status" id="status" class="form-control" {{ ($order->status == 'delivered') ? 'disabled' : '' }}>
                    <option value="">--Select Status--</option>
                    {{-- <option value="new" {{ ($order->status == 'new') ? 'selected' : '' }}>New</option> --}}
                    {{-- <option value="processing" {{ ($order->status == 'processing') ? 'selected' : '' }}>Processing</option> --}}
                    <option value="shipped" {{ ($order->status == 'shipped') ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ ($order->status == 'delivered') ? 'selected' : '' }}>Delivered</option>
                    <option value="cancel" {{ ($order->status == 'cancel') ? 'selected' : '' }}>Cancel</option>
                </select>
            </div>

            <div class="form-group" id="additionalInfoGroup" @if ($order->status == 'shipped') style="display: block;" @else style="display: none;" @endif>
                <label for="location_info">Input your location:</label>
                <input type="text" value="{{$order->location_info}}" name="location_info" id="location_info" class="form-control" @if ($order->status == 'shipped') required @endif>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#status').change(function () {
            if ($(this).val() === 'shipped') {
                $('#additionalInfoGroup').show();
                $('#location_info').prop('required', true);
            } else {
                $('#additionalInfoGroup').hide();
                $('#location_info').prop('required', false);
            }
        });

        // Check the initial status on page load
        if ($('#status').val() === 'shipped') {
            $('#additionalInfoGroup').show();
            $('#location_info').prop('required', true);
        }
    });
</script>

@endsection

@push('styles')
<style>
    .order-info, .shipping-info {
        background: #ECECEC;
        padding: 20px;
    }

    .order-info h4, .shipping-info h4 {
        text-decoration: underline;
    }
</style>
@endpush
