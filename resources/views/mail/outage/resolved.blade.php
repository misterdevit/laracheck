<x-mail::message>
# 🚀 Outage Resolved

The latest incident has been resolved!<br>
The site {{ $site->name }} is up!

<x-mail::table>
| <span style="font-size: 16px; color: #000;">Outage #{{ $outage->id }}</span> |
| :------------ |
| <b>URL          </b><br>{{ $site->url }} |
| <b>Occurred At  </b><br>{{ $outage->occurred_at }} ({{ config('app.timezone') }})|
| <b>Resolved At  </b><br>{{ $outage->resolved_at }} ({{ config('app.timezone') }})|
| <b>Duration    </b><br><i>{{ $outage->duration }}</i> |
</x-mail::table>

Check the dashboard for more details!

<x-mail::button :url="config('app.url')">
Dashboard
</x-mail::button>

Thank You,<br>
{{ config('app.name') }}
</x-mail::message>
