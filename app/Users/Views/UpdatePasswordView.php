<?php

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php' ?>

    <h1>Update password</h1>
    <form method="POST" action="/users/<?= $userId ?>/update_password">
        <div class="form-outline mb-4">
            <input type="password" id="form2Example2" class="form-control" name="current_password"/>
            <label class="form-label" for="form2Example2">Current password</label>
        </div>

        <div class="form-outline mb-4">
            <input type="password" id="form2Example2" class="form-control" name="new_password"/>
            <label class="form-label" for="form2Example2">New password</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="update_password">Update password</button>
        </div>

        <a href="/users/<?= $userId ?>/update" style="font-size: 20px">Go to user</a>
    </form>
<?php
require_once '../app/includes/footer.php'; ?>