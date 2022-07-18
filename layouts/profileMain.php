<p>Username: <?= $user['username'] ?></p>
<p>Email: <?= $user['email'] ?></p>
<p>ID: <?= $user['user_id'] ?></p>
<img src="/img/<?= $userImg ?>" alt="img" width="200px">

<br>
<br>
<br>

<div>
    <form action="profile" method="POST" enctype="multipart/form-data">
        <input type="file" name="image">
        <br>
        <br>
        <button type="submit" name="setAvatar" style="width:20%">Set new avatar</button>
    </form>
    <br>
    <form action="/profile" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="fileName" value="/img/<?= $userImg ?>">
        <button type="submit" name="deleteAvatar" style="width:20%">Delete avatar</button>
    </form>

    <a href="/users/<?= $user['user_id'] ?>/update ">Update user</a>
</div>