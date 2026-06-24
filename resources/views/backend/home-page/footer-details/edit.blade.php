<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')
</head>

<body>
    @include('components.backend.header')
    @include('components.backend.sidebar')

    <div class="page-body">
        <div class="container-fluid">

            <!-- Page Header -->
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Footer Details</h4>
                    </div>
                    <div class="col-6 text-end">
                        <ol class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="{{ route('footer-details.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Footer Details</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Form Start -->
            <form action="{{ route('footer-details.update', $record->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Footer Info -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <strong>Footer Information</strong>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label>Logo Image <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(event)">
                            <div class="mt-2">
                                <img id="logoPreview" src="{{ asset('uploads/footer/' . $record->logo) }}" alt="Preview" style="max-height: 100px;">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label>Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter footer description">{{ $record->description }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label>Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" placeholder="Enter address" value="{{ $record->address }}">
                        </div>
                        <div class="col-md-6">
                            <label>Map Url <span class="text-danger">*</span></label>
                            <input type="text" name="map_url" class="form-control" placeholder="Enter map_url" value="{{ $record->mapurl }}">
                        </div>
                        <div class="col-md-3">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" value="{{ $record->email }}">
                        </div>

                         

                        <div class="col-md-3">
                            <label>Phone <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="Enter phone number" value="{{ $record->phone }}">
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                        <strong>Social Links</strong>
                        <button type="button" class="btn btn-sm btn-light" id="addSocial">+ Add</button>
                    </div>
                    <div class="card-body" id="socialWrapper">
                        @foreach($social_titles as $index => $title)
                            <div class="row g-2 social-group mt-2">
                                <div class="col-md-5">
                                    <input type="text" name="social_title[]" class="form-control" value="{{ $title }}" placeholder="Enter social title">
                                </div>
                                <div class="col-md-5">
                                    <input type="url" name="social_link[]" class="form-control" value="{{ $social_links[$index] ?? '' }}" placeholder="Enter social link">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-social">−</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="text-end mt-4">
                    <a href="{{ route('footer-details.index') }}" class="btn btn-danger">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>

    @include('components.backend.footer')
    @include('components.backend.main-js')

    <!-- JavaScript Section -->
    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('logoPreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        document.getElementById('addSocial').addEventListener('click', function () {
            const wrapper = document.getElementById('socialWrapper');
            const newGroup = document.createElement('div');
            newGroup.className = 'row g-2 social-group mt-2';
            newGroup.innerHTML = `
                <div class="col-md-5">
                    <input type="text" name="social_title[]" class="form-control" placeholder="Enter social title">
                </div>
                <div class="col-md-5">
                    <input type="url" name="social_link[]" class="form-control" placeholder="Enter social link">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-social">−</button>
                </div>`;
            wrapper.appendChild(newGroup);
        });

        document.getElementById('socialWrapper').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-social')) {
                e.target.closest('.social-group').remove();
            }
        });
    </script>

</body>
</html>
