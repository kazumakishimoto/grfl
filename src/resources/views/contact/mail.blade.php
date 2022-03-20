お問い合わせメールを受け付けました。<br>
<br>
■お名前<br>
{!! $name !!}<br>
<br>
■メールアドレス<br>
{!! $email !!}<br>
<br>
■タイトル<br>
@if ($title !== null)
{!! $title !!}<br>
@else
無題<br>
@endif
<br>

■お問い合わせ内容<br>
{!! nl2br($body) !!}<br>
