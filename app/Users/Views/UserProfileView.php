<?php

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php' ?>

    <h1><?= $user['username'] ?></h1>
    <p>Email: <?= $user['email'] ?></p>
    <p>ID: <?= $user['user_id'] ?></p>
    <img src="/img/<?= $userImg ?>" height="200px">

    <div>
        <form action="/profile" method="POST" enctype="multipart/form-data">
            <input type="file" name="image">
            <br>
            <br>
            <button type="submit" name="set_new_avatar" style="width:20%">Set new avatar</button>
        </form>
        <br>
        <form action="/profile" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="fileName" value="./img/<?= $userImg ?>">
            <button type="submit" name="delete_avatar" style="width:20%">Delete avatar</button>
        </form>

        <a href="/users/<?= $user['user_id'] ?>/update ">Update user</a>
    </div>
<?php
require_once '../app/includes/footer.php';
