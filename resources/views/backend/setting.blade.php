@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Edit Settings</h5>
        <div class="card-body">
            <form method="post" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf
                {{-- @method('PATCH') --}}
                {{-- {{dd($data)}} --}}
                <div class="form-group">
                    <label for="short_des" class="col-form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="quote" name="short_des">{{ $data->short_des }}</textarea>
                    @error('short_des')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description">{{ $data->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input id="thumbnail1" class="form-control" type="file" name="logo"
                            value="{{ $data->logo }}">
                    </div>
                    <div id="holder" style="margin-top: 15px; max-height: 100px;">
                        @if ($data->logo)
                            <img src="data:image/png;base64,{{ $data->logo }}" alt="{{ $data->logo }}" class="img-fluid"
                                style="max-height: 100px;">
                        @endif
                    </div>
                    <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

                    @error('logo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input id="thumbnail" class="form-control" type="file" name="photo"
                            value="{{ $data->photo }}">
                    </div>
                    <div id="holder" style="margin-top: 15px; max-height: 100px;">
                        @if ($data->photo)
                            <img src="data:image/png;base64,{{ $data->photo }}" alt="{{ $data->photo }}" class="img-fluid"
                                style="max-height: 100px;">
                        @endif
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="address-input" name="address" required
                        value="{{ $data->address }}" readonly>
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                    Pick a Location
                </button>
                <p style="display: none;">Selected Location: <span id="location-name">None</span></p>

                <!-- Modal -->
                <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mapModalLabel">Select Location</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="map"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" required value="{{ $data->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" required value="{{ $data->phone }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <!-- Include jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Load the Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async
        defer></script>

    <script>
        let map, marker;

        function initMap() {
            // Coordinates for the Philippines
            const philippines = {
                lat: 13.4125,
                lng: 122.5621
            };

            // Create a map centered on the Philippines
            map = new google.maps.Map(document.getElementById('map'), {
                center: philippines,
                zoom: 8
            });

            // Add a marker that users can move
            marker = new google.maps.Marker({
                position: philippines,
                map: map,
                draggable: true
            });

            // Add an event listener for the marker
            google.maps.event.addListener(marker, 'dragend', function() {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();
                getGeocode(lat, lng);
            });

            // Function to get the location name using Geocoding API
            function getGeocode(lat, lng) {
                var geocoder = new google.maps.Geocoder();
                var latlng = {
                    lat: parseFloat(lat),
                    lng: parseFloat(lng)
                };

                geocoder.geocode({
                    'location': latlng
                }, function(results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            document.getElementById('location-name').innerText = results[0].formatted_address;
                            document.getElementById('address-input').value = results[0]
                            .formatted_address; // Update the address input field
                        } else {
                            document.getElementById('location-name').innerText = 'No results found';
                        }
                    } else {
                        document.getElementById('location-name').innerText = 'Geocoder failed due to: ' + status;
                    }
                });
            }
        }

        // Ensure the map is properly initialized when the modal is shown
        $('#mapModal').on('shown.bs.modal', function() {
            google.maps.event.trigger(map, "resize");
            map.setCenter(marker.getPosition()); // Ensure the map is centered
        });
    </script>


    <script>
        $('#lfm').filemanager('image');
        $('#lfm1').filemanager('image');
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        $(document).ready(function() {
            $('#quote').summernote({
                placeholder: "Write short Quote.....",
                tabsize: 2,
                height: 100
            });
        });
        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
