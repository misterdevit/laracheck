<x-mail::message>
# 🛑 Outage Occurred

<b>An incident has been detected.</b><br>
The site {{ $site->name }} is currently down.

<x-mail::table>
| <span style="font-size: 16px; color: #000;">Outage #{{ $outage->id }}</span> |
| :------------ |
| <b>URL          </b><br>{{ $site->url }} |
| <b>Occurred At  </b><br>{{ $outage->occurred_at }} ({{ config('app.timezone') }})|
</x-mail::table>

Check the dashboard for more details!

<x-mail::button :url="config('app.url')">
Dashboard
</x-mail::button>

Thank You,<br>
{{ config('app.name') }}
</x-mail::message>
