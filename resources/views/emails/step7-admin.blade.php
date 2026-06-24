<h3>Step 7 Submitted - Designated Body Details</h3>

<p><strong>Name:</strong> {{ $name }}</p>
<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>DD Reference:</strong> {{ $ddReference }}</p>

<hr>

<h4>Step 7 Details:</h4>

@foreach($step7 as $key => $value)
    <p><strong>{{ ucfirst(str_replace('_',' ',$key)) }}:</strong> {{ $value }}</p>
@endforeach