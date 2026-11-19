<h2>🎓 New Student Discount Application Received</h2>

<p><strong>Name:</strong> {{ $data['fname'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['countrycode'] }} {{ $data['phone'] }}</p>
<p><strong>School:</strong> {{ $data['school'] }}</p>
<p><strong>Year of Study:</strong> {{ $data['yos'] }}</p>
<p><strong>Keep Current Number:</strong> {{ ucfirst($data['keepnumber']) }}</p>
<p><strong>Selected Plan:</strong> {{ ucfirst($data['plan']) }}</p>
<p><strong>Category:</strong> {{ ucfirst($data['cat']) }}</p>

@if(!empty($data['statusproof']))
<p><strong>Student ID:</strong> <a href="{{ asset('storage/'.$data['statusproof']) }}" target="_blank">View File</a></p>
@endif

<p>Consent Given: {{ $data['concent'] ? 'Yes' : 'No' }}</p>
<p>Agreed to Terms: {{ $data['terms'] ? 'Yes' : 'No' }}</p>

<hr>
<p>Submitted on {{ now()->format('d M Y, h:i A') }}</p>
