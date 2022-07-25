<?php require_once '../app/includes/header.php'; ?>
<?php require_once '../app/includes/navigation.php' ?>

<?php if (!$user) : ?>
    <h1>User not found</h1>
<?php else : ?>
    <h1>User <?= $user['username'] ?></h1>
    <ul class="list-group">
        <li class="list-group-item">id: <?= $user['user_id'] ?></li>
        <li class="list-group-item">username: <?= $user['username'] ?></li>
        <li class="list-group-item">email: <?= $user['email'] ?></li>
    </ul>
<?php endif; ?>

<h3><a href="/users">Go back</a></h3>

<?php require_once '../app/includes/footer.php'; ?>