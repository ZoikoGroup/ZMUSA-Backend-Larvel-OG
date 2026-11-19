<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $forAdmin ? 'New Registration' : 'Registration Confirmation' }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    @if($forAdmin)
        <h2>🐾 New Animal Worker Registration</h2>
        <p>A new Animal Worker has registered.</p>

        <p><strong>Name:</strong> {{ $record->fname }}</p>
        <p><strong>Email:</strong> {{ $record->email }}</p>
        <p><strong>Phone:</strong> {{ $record->countrycode }} {{ $record->phone }}</p>
        <p><strong>Organization:</strong> {{ $record->orgname }}</p>
        <p><strong>Job Title:</strong> {{ $record->jobtitle }}</p>
        <p><strong>Address:</strong> {{ $record->street }}, {{ $record->city }}, {{ $record->state }} - {{ $record->zipcode }}</p>

        <p>The uploaded status proof (if any) is attached with this email.</p>
    @else
        <h2>Thank You, {{ $record->fname }}!</h2>
        <p>Your Animal Worker registration has been received successfully.</p>

        <p>Our team will review your details and contact you soon.</p>

        <h3>Your Details</h3>
        <ul>
            <li><strong>Organization:</strong> {{ $record->orgname }}</li>
            <li><strong>Job Title:</strong> {{ $record->jobtitle }}</li>
            <li><strong>Email:</strong> {{ $record->email }}</li>
            <li><strong>Phone:</strong> {{ $record->countrycode }} {{ $record->phone }}</li>
        </ul>

        <p>Thank you for joining us!</p>
        <p>– {{ config('app.name') }}</p>
    @endif
</body>
</html>
