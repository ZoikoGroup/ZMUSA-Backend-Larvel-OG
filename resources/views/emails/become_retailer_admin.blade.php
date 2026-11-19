<h2>New Become Retailer Submission</h2>

<p><strong>Company:</strong> {{ $form->companyName }}</p>
<p><strong>Website:</strong> {{ $form->website }}</p>
<p><strong>Contact Name:</strong> {{ $form->name }}</p>
<p><strong>Email:</strong> {{ $form->email }}</p>
<p><strong>Phone:</strong> {{ $form->countrycode }} {{ $form->phone }}</p>
<p><strong>Address:</strong> {{ $form->street }}, {{ $form->city }}, {{ $form->state }} {{ $form->zip }}</p>

<h3>Business Type(s):</h3>
<ul>
@foreach($form->businessTypes ?? [] as $type)
  <li>{{ $type }}</li>
@endforeach
</ul>

<h3>Marketing Channels:</h3>
<ul>
@foreach($form->marketingChannels ?? [] as $channel)
  <li>{{ $channel }}</li>
@endforeach
</ul>

<h3>Plans to Promote:</h3>
<ul>
@foreach($form->planToPromotes ?? [] as $plan)
  <li>{{ $plan }}</li>
@endforeach
</ul>

<p><strong>Monthly Traffic:</strong> {{ $form->monthlyTraffic }}</p>
<p><strong>Promote Brands:</strong> {{ $form->promotoBrands }}</p>
<p><strong>Monthly Activations:</strong> {{ $form->monthlyActivations }}</p>
