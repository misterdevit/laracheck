<x-mail::message>
# 🪲 Bugs in last five minutes

@foreach ($bugs as $bug)
<x-mail::table>
| <span style="font-size: 16px; color: #000;">Bug #{{ $bug->id }} @ <br>{{ $bug->site->name }}</span> |
| :------------ |
| <b>Logged At  </b><br>{{ $bug->logged_at }} |
| <b>URL        </b><br>{{ $bug->url }} |
| <b>Path       </b><br>{{ $bug->method }} @ {{ $bug->path }} |
| <b>File       </b><br>{{ $bug->file }}:{{ $bug->line }} |
| <b>Message    </b><br><i>{{ $bug->message }}</i> |
</x-mail::table>
@endforeach

Check the dashboard for more details!

<x-mail::button :url="config('app.url')">
Dashboard
</x-mail::button>

Thank You,<br>
{{ config('app.name') }}
</x-mail::message>
