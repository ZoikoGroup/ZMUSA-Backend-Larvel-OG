<h2>New Animal Partnership Application</h2>

<p><strong>Organization Name:</strong> {{ $data['orgname'] }}</p>
<p><strong>Organization Type:</strong> {{ $data['orgtype'] }}</p>
<p><strong>Focus:</strong> {{ $data['focus'] }}</p>
<p><strong>Website:</strong> {{ $data['website'] }}</p>
<p><strong>Contact Name:</strong> {{ $data['name'] }}</p>
<p><strong>Role:</strong> {{ $data['role'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] }}</p>

<p><strong>Mission:</strong></p>
<p>{{ $data['mission'] }}</p>

@if(!empty($data['statusproof']))
<p><strong>Status Proof:</strong> Uploaded file is stored at: {{ asset('storage/' . $data['statusproof']) }}</p>
@endif

<p>--<br>Zoiko Admin Notification System</p>
