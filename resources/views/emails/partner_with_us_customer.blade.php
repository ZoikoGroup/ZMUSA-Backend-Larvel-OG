<!DOCTYPE html>
<html>
<body>
    <p>Dear {{ $form->name }},</p>

    <p>Thank you for your interest in partnering with <strong>Zoiko Mobile</strong>!  
    We have received your application and our team will get back to you soon.</p>

    <p><strong>Summary of your submission:</strong></p>
    <ul>
        <li>Company: {{ $form->company_name }}</li>
        <li>Email: {{ $form->email }}</li>
        <li>Phone: {{ $form->phone }}</li>
        <li>City: {{ $form->city }}, {{ $form->state }}</li>
    </ul>

    <p>Best regards,<br>
    <strong>Zoiko Mobile Team</strong></p>
</body>
</html>
