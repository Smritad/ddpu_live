<!doctype html>
<html lang="en">
<head>
    @include('components.backend.head')

    <style>
        .remove-icon{
            position:absolute;
            top:-8px;
            right:-8px;
            background:#dc3545;
            color:#fff;
            width:22px;
            height:22px;
            border-radius:50%;
            font-size:14px;
            text-align:center;
            line-height:22px;
            cursor:pointer;
        }
    </style>
</head>

<body>

@include('components.backend.header')
@include('components.backend.sidebar')

                <div class="page-body">
                <div class="container-fluid">
                
                <!-- ================= PAGE TITLE ================= -->
                <div class="page-title">
                    <div class="row">
                        <div class="col-6">
                            <h4>Edit Compare Us</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('compare-us-details.index') }}" class="btn btn-secondary btn-sm">Back</a>
                        </div>
                    </div>
                </div>
                
                <!-- ================= FORM ================= -->
                <div class="card mt-3">
                <div class="card-header">
                    <h4>Compare Us Details</h4>
                </div>
                
                <div class="card-body">
                <form class="row g-4"
      action="{{ route('compare-us-details.update', $compareus->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <!-- ================= BANNER IMAGE ================= -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">
            Banner Image <span class="text-danger">*</span>
        </label>

        <input type="file"
               class="form-control"
               name="banner_image"
               accept=".jpg,.jpeg,.png,.webp"
               onchange="previewImage(this, 'bannerPreview', 'bannerSize', 'removeBannerBtn')">

        <div class="position-relative d-inline-block mt-2">

            {{-- OLD IMAGE --}}
            @if(!empty($compareus->banner_image))
                <img id="bannerPreview"
                     src="{{ asset('compareus/banner/'.$compareus->banner_image) }}"
                     width="150"
                     style="border:1px solid #ddd; padding:5px; border-radius:6px;">
                     
                <span id="removeBannerBtn"
                      onclick="removeImage('banner_image','bannerPreview','bannerSize','removeBannerBtn')"
                      style="cursor:pointer; position:absolute; top:-8px; right:-8px;
                             background:#dc3545; color:#fff; border-radius:50%;
                             width:22px; height:22px; text-align:center;
                             font-size:14px; line-height:22px;">
                    ×
                </span>
            @else
                <img id="bannerPreview" width="150" style="display:none;">
                <span id="removeBannerBtn" style="display:none;"></span>
            @endif
        </div>

        <small id="bannerSize" class="text-muted d-block"></small>
    </div>


    <!-- ================= HEADING ================= -->
    <div class="col-md-12">
        <label class="form-label fw-semibold">Heading</label>
        <input type="text" name="heading" class="form-control"
               value="{{ $compareus->heading }}">
    </div>


    <!-- ================= TABLE BUILDER ================= -->
    @php
        $columns = $compareus->details['columns'] ?? [];
        $rows    = $compareus->details['rows'] ?? [];
    @endphp

    <div class="col-md-12 mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between">
                <h5 class="mb-0">Table Data</h5>
                <div>
                    <button type="button" class="btn btn-success btn-sm" onclick="addColumn()">+ Column</button>
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRow()">+ Row</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center" id="dynamicTable">

                   <thead>
                        <tr id="tableHeadRow">
                            @foreach($columns as $index => $col)
                                <th class="position-relative">
                                    
                                    <input type="text"
                                           name="columns[]"
                                           class="form-control"
                                           value="{{ $col }}"
                                           {{ $index==0 ? 'readonly' : '' }}>
                    
                                    {{-- REMOVE COLUMN BUTTON (except first column) --}}
                                    @if($index != 0)
                                        <span class="remove-icon"
                                              onclick="removeColumn({{ $index }})">
                                            ×
                                        </span>
                                    @endif
                    
                                </th>
                            @endforeach
                    
                            <th width="70">Action</th>
                        </tr>
                    </thead>


                    <!-- BODY -->
                    <tbody id="tableBody">

                        @foreach($rows as $rIndex => $row)
                            <tr>
                                @foreach($row as $cIndex => $cell)

                                    @if($cIndex == 0)
                                        <td>
                                            <textarea name="rows[{{ $rIndex }}][]"
                                                      class="form-control"
                                                      required>{{ $cell }}</textarea>
                                        </td>
                                    @else
                                        <td>
                                            <input type="text"
                                                   name="rows[{{ $rIndex }}][]"
                                                   value="{{ $cell }}"
                                                   class="form-control">
                                        </td>
                                    @endif

                                @endforeach

                                <td>
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            onclick="removeRow(this)">×</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>


   <!-- ================= BUTTONS ================= -->
    <div class="col-12 text-end">

        <a href="{{ route('compare-us-details.index') }}"
           class="btn btn-secondary px-4 me-2">
            Cancel
        </a>

        <button class="btn btn-primary px-4" type="submit">
            Update
        </button>
    </div>

</form>

</div>
</div>

</div>
</div>

@include('components.backend.footer')
@include('components.backend.main-js')

<script>

let rowIndex = {{ count($rows) }};


// ================= IMAGE PREVIEW =================
function previewImage(input, previewId, sizeId, removeBtnId) {
    const file = input.files[0];
    if (!file) return;

    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    preview.src = URL.createObjectURL(file);
    preview.style.display = "block";

    sizeText.innerHTML = "Size: " + (file.size / 1024).toFixed(2) + " KB";

    removeBtn.style.display = "block";
}

// ================= REMOVE IMAGE =================
function removeImage(inputName, previewId, sizeId, removeBtnId) {
    const preview = document.getElementById(previewId);
    const sizeText = document.getElementById(sizeId);
    const removeBtn = document.getElementById(removeBtnId);

    preview.src = "";
    preview.style.display = "none";
    sizeText.innerHTML = "";
    removeBtn.style.display = "none";

    document.querySelector("input[name='"+inputName+"']").value = "";
}


// ================= ADD ROW =================
function addRow() {
    let colCount = document.querySelectorAll("#tableHeadRow th").length - 1;
    let html = '<tr>';

    for (let i = 0; i < colCount; i++) {
        if (i == 0) {
            html += `<td><textarea name="rows[${rowIndex}][]" class="form-control" required></textarea></td>`;
        } else {
            html += `<td><input type="text" name="rows[${rowIndex}][]" class="form-control"></td>`;
        }
    }

    html += `<td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">×</button></td>`;
    html += '</tr>';

    document.getElementById("tableBody").insertAdjacentHTML('beforeend', html);
    rowIndex++;
}


// ================= REMOVE ROW =================
function removeRow(btn) {
    btn.closest("tr").remove();
}

function removeColumn(colIndex) {

    // remove header column
    let headRow = document.getElementById("tableHeadRow");
    headRow.deleteCell(colIndex);

    // remove column from each row
    let rows = document.querySelectorAll("#tableBody tr");

    rows.forEach(row => {
        row.deleteCell(colIndex);
    });

}

// ================= ADD COLUMN =================
function addColumn() {

    let headRow = document.getElementById("tableHeadRow");

    let th = document.createElement("th");
    th.classList.add("position-relative");

    th.innerHTML = `
        <input type="text" name="columns[]" class="form-control" placeholder="Column">
        <span class="remove-icon" onclick="removeColumn(${headRow.children.length - 1})">×</span>
    `;

    headRow.insertBefore(th, headRow.lastElementChild);

    // add column to rows
    document.querySelectorAll("#tableBody tr").forEach((tr, index) => {
        let td = document.createElement("td");
        td.innerHTML = `<input type="text" name="rows[${index}][]" class="form-control">`;
        tr.insertBefore(td, tr.lastElementChild);
    });
}


</script>


</body>
</html>
