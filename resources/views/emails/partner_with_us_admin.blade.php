<!DOCTYPE html>
<html>
<body>
    <p>Hello Support Team,</p>

    <p>A new partner submission has been received:</p>

    <ul>
        <li><strong>Company:</strong> {{ $form->company_name }}</li>
        <li><strong>Contact:</strong> {{ $form->name }} ({{ $form->job }})</li>
        <li><strong>Email:</strong> {{ $form->email }}</li>
        <li><strong>Phone:</strong> {{ $form->phone }}</li>
        <li><strong>City:</strong> {{ $form->city }}, {{ $form->state }}</li>
        <li><strong>Monthly Sales:</strong> {{ $form->monthly_sales }}</li>
        <li><strong>Preferred Partnership Model:</strong> {{ $form->preferred_partnership_model }}</li>
    </ul>

    <p>View all submissions in the admin panel for more details.</p>

    <p>– Zoiko Mobile Notification</p>
</body>
</html>
