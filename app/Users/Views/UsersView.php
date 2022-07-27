<?php
use app\Access\Controllers\AccessController;

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php';

if (AccessController::checkUserIsAdmin()) : ?>
    <a href="/users/create" style="font-size:24px">Create new user</a>
<?php
endif; ?>
    <h1>Users</h1>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($userList as $user) : ?>
            <tr>
                <td><?= $user['user_id'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['role'] ?></td>

                <?php
                if (AccessController::checkUserIsAdmin()) : ?>
                    <td><a href="/users/<?= $user['user_id'] ?>">watch</a></td>
                    <td><a href="/users/<?= $user['user_id'] ?>/update">update</a></td>

                    <td>
                        <?php
                        if ((int)$_SESSION['user_id'] !== (int)$user['user_id']) : ?>
                            <a href="/users/<?= $user['user_id'] ?>/delete" class='delete-btn'">delete</a>
                        <?php
                        endif; ?>
                    </td>
                <?php
                endif; ?>

            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>

    <div style="text-align:center; font-size: 20px;">
        <a href="?page=<?= $pagination['pageStart'] ?>">start</a>
        <a href="?page=<?= $pagination['currentPage'] - 1 ?>">prev</a>
        <?= $pagination['currentPage'] ?>
        <a href="?page=<?= $pagination['currentPage'] + 1 ?>">next</a>
        <a href="?page=<?= $pagination['pageEnd'] ?>">end</a>
    </div>

<?php
require_once '../app/includes/footer.php'; ?>