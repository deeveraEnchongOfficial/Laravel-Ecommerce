@extends('user.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Add Location</h5>
        <div class="card-body">
            <form method="post" action="{{ route('location.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Location Name <span class="text-danger">*</span></label>
                    <input id="address-input" type="text" name="location_name" placeholder="Enter Location Name"
                        value="{{ old('type') }}" class="form-control" readonly>
                    @error('type')
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
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
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
    <!-- Include jQuery, Popper.js, and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Load the Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV9Jh6vmTaVoyA4fDzCEz4Djeln_4eNDM&callback=initMap" async defer>
    </script>
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwUDCRqogDsvcAU7sdVh6oVBbjfZOjXcc&callback=initMap" async defer>
    </script> --}}

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

                console.log('latlng', latlng);

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
@endpush
