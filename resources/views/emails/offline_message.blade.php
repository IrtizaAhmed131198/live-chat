<h3>New Offline Message</h3>
<p>Name: {{ $offline->name }}</p>
<p>Email: {{ $offline->email }}</p>
<p>Message: {{ $offline->message }}</p>
<hr>
<footer style="text-align: center; color: #666; font-size: 12px; margin-top: 20px;">
    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    <p>
        <a href="{{ config('app.url') }}" style="color: #007bff; text-decoration: none;">Visit our website</a>
    </p>
</footer>
