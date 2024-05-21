@extends('backend.layouts.master')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Create Refund</h5>
        <div class="card-body">
            <form method="post" action="{{ route('order.refund.store') }}">
                {{ csrf_field() }}

                <!-- Loop through product images -->
                @if ($order && $order->cart)
                    <div class="form-group">
                        <label for="inputImages" class="col-form-label">Product Images</label>
                        <div class="row">
                            @foreach ($order->cart as $item)
                                <div class="col-md-3 text-center">
                                    <img src="{{ asset($item->product->photo) }}" alt="Product Image" class="img-fluid">
                                    <p class="mt-2">{{ $item->product->title }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <input type="hidden" name="order_id" value="{{$order->id}}">
                <div class="form-group">
                    <label for="inputRefundAmount" class="col-form-label">Refund Amount <span
                            class="text-danger">*</span></label>
                    <input id="inputRefundAmount" value="{{ $order->total_amount }}" type="number" name="refund_amount"
                        placeholder="Enter Refund Amount" value="{{ old('refund_amount') }}" class="form-control" readonly>
                    @error('refund_amount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="reason">Reason</label>
                    <select name="reason" class="form-control">
                        <option value="">--Select Reason--</option>
                        <option value="I didnt Recieve">I didnt Recieve</option>
                        <option value="I want to Refund">I want to Refund</option>
                        <option value="other">other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="inputDesc" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
