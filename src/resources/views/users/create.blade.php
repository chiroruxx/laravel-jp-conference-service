<!DOCTYPE html>

<form action="{{ route('users.store') }}" method="post">
    {!! csrf_field() !!}
    <label>
        お名前：
        <input type="text" name="name">
    </label>
    <label>
        メールアドレス
        <input type="email" name="mail_address">
    </label>
    <input type="submit" value="登録する">
</form>
