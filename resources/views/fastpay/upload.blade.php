
<div class="container mt-5">
    <h3>FastPay CSV Upload</h3>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('fastpay.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Upload CSV File</label>
            <input type="file" name="file" class="form-control" required accept=".csv">
        </div>

        <button type="submit" class="btn btn-primary">
            Upload to FastPay
        </button>
    </form>

<form id="addressForm">
  <label>Pincode / Postal Code:</label>
  <input type="text" id="pincode" placeholder="Enter Pincode" />

  <label>State:</label>
  <input type="text" id="state" readonly />

  <label>City:</label>
  <input type="text" id="city" readonly />

  <label>Country:</label>
  <input type="text" id="country_name" readonly />

  <button type="submit">Submit</button>
</form>
<form>
    <label>Education Level</label>
    <select id="level">
        <option value="">Select Level</option>
        <option value="10">Class 10</option>
        <option value="12">Class 12</option>
        <option value="ug">Undergraduate</option>
        <option value="pg">Postgraduate</option>
        <option value="phd">Doctorate</option>
    </select>

    <br><br>

    <label>Course</label>
    <select id="course">
        <option value="">Select Course</option>
    </select>
</form>
<script>
const courseDropdown = document.getElementById("course");
const levelDropdown = document.getElementById("level");

levelDropdown.addEventListener("change", () => {
    const level = levelDropdown.value;
    courseDropdown.innerHTML = '<option>Loading...</option>';

    // Class 10 & 12 – fixed courses (no global API exists)
    if (level === "10" || level === "12") {
        courseDropdown.innerHTML = `
            <option>Science</option>
            <option>Commerce</option>
            <option>Arts / Humanities</option>
        `;
        return;
    }

    // UG / PG / PhD – fetch from FREE API
    fetch("https://api.openskills.world/skills")
        .then(res => res.json())
        .then(data => {
            courseDropdown.innerHTML = '<option value="">Select Course</option>';

            data.slice(0, 200).forEach(skill => {
                let opt = document.createElement("option");
                opt.value = skill.name;
                opt.textContent = skill.name;
                courseDropdown.appendChild(opt);
            });
        })
        .catch(err => {
            courseDropdown.innerHTML = '<option>Error loading courses</option>';
            console.error(err);
        });
});
</script>


   <script>
const OPENCAGE_API_KEY = "d6edaba93898443e89ddab2be5bdf9cd"; // Replace with your OpenCage API key

document.getElementById("pincode").addEventListener("blur", function () {
    let pin = this.value.trim();

    if (!pin) return;

    // 1️⃣ India - 6-digit numeric pincode
    if (/^\d{6}$/.test(pin)) {
        fetch(`https://api.postalpincode.in/pincode/${pin}`)
            .then(res => res.json())
            .then(data => {
                if (data[0].Status !== "Success") throw new Error("Invalid Pincode");

                let postOffice = data[0].PostOffice[0];
                document.getElementById("state").value = postOffice.State;
                document.getElementById("city").value = postOffice.District;
                document.getElementById("country_name").value = postOffice.Country;
            })
            .catch(err => {
                alert("Invalid Indian Pincode!");
                document.getElementById("state").value = "";
                document.getElementById("city").value = "";
                document.getElementById("country_name").value = "";
            });
    } else {
        // 2️⃣ Other countries - use OpenCageData
        fetch(`https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(pin)}&key=${OPENCAGE_API_KEY}`)
            .then(res => res.json())
            .then(data => {
                if (!data.results || data.results.length === 0) throw new Error("Pincode not found");

                let components = data.results[0].components;
                document.getElementById("state").value = components.state || components.county || "";
                document.getElementById("city").value = components.city || components.town || components.village || "";
                document.getElementById("country_name").value = components.country || "";
            })
            .catch(err => {
                alert("Pincode not found in any country!");
                document.getElementById("state").value = "";
                document.getElementById("city").value = "";
                document.getElementById("country_name").value = "";
            });
    }
});
</script>


</div>

