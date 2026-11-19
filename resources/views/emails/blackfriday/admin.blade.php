<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <h2>New Black Friday Submission</h2>

<p><strong>Name:</strong> {{ $data['firstName'] }} {{ $data['lastName'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Company:</strong> {{ $data['company'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] }}</p>
<p><strong>Message:</strong> {{ $data['message'] ?? 'N/A' }}</p>

<p>Received on {{ now() }}</p>

</body>
</html>
