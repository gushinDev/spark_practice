<?php

use app\Access\Controllers\AccessController;

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php' ?>
    <h1 class="text-center">Update user</h1>

    <div class="container">
        <img src="/img/<?= $userImg ?>" height="200px">
        <form method="POST" action="/users/<?= $_SESSION['updateUserForm']['user_id'] ?>/update">

            <div class="form-group">
                <label for="username">User name</label>
                <input type="text" class="form-control" id="username" aria-describedby="usernameHelp"
                       placeholder="Enter your name" name="username"
                       value="<?= $_SESSION['updateUserForm']['username'] ?? '' ?>">
            </div>
            <br>

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="Enter email" name="email" value="<?= $_SESSION['updateUserForm']['email'] ?? '' ?>">
            </div>
            <br>

            <?php
            if (AccessController::checkUserIsAdmin()): ?>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role">
                        <option value="user">User</option>
                        <option value="admin" <?= $_SESSION['updateUserForm']['role'] == 'admin' ? 'selected' : '' ?>>
                            Admin
                        </option>
                    </select>
                </div>
                <br>
            <?php
            endif ?>

            <a href="/users/<?= $_SESSION['updateUserForm']['user_id'] ?? '' ?>/update_password">Change password</a>

            <br>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" name="update_user">Submit</button>
            </div>
        </form>

        <h2 class="text-center"><a href="/profile">Go back</a></h2>
    </div>
<?php
require_once '../app/includes/footer.php';
