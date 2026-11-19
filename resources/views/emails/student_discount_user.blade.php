<h2>🎓 Thank You for Registering for the Zoiko Student Discount Program!</h2>

<p>Dear {{ $data['fname'] }},</p>

<p>We’ve received your application for the <strong>Zoiko Mobile College Student Discount Program</strong>. Our team will review your submission and contact you shortly.</p>

<h4>Your Submission Summary:</h4>
<ul>
  <li><strong>Email:</strong> {{ $data['email'] }}</li>
  <li><strong>Phone:</strong> {{ $data['countrycode'] }} {{ $data['phone'] }}</li>
  <li><strong>School:</strong> {{ $data['school'] }}</li>
  <li><strong>Year of Study:</strong> {{ $data['yos'] }}</li>
  <li><strong>Plan:</strong> {{ ucfirst($data['plan']) }}</li>
  <li><strong>Category:</strong> {{ ucfirst($data['cat']) }}</li>
</ul>

<p>Thank you for choosing <strong>Zoiko Mobile</strong> — empowering students to stay connected affordably!</p>

<p>Best Regards,<br>Team Zoiko Mobile</p>
