<x-mail::message>
# 🛑 Outage Occurred

<b>An incident has been detected.</b><br>
The site {{ $site->name }} ({{ $site->url }}) is currently down.<br><br>

Check the dashboard for more details!

<x-mail::button :url="config('app.url')">
Dashboard
</x-mail::button>

Thank You,<br>
{{ config('app.name') }}
</x-mail::message>
