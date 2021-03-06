<?php

use app\Access\Controllers\AccessController;

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php'; ?>

    <h1><?= $currentCourse['title'] ?></h1>

    <ul class="list-group" style="width: 95%">
        <?php
        foreach ($courseContent as $row) : ?>
            <li class="list-group-item"><h3><?= $row['type'] ?></h3></li>
            <li class="list-group-item"><?= $row['content'] ?></li>


            <?php
            if (AccessController::checkItIsCurrentUser($authorId)): ?>
                <li class="list-group-item">
                    <a href="/courses/<?= $courseId ?>/sections/<?= $row['section_id'] ?>/update">Update</a>
                    <a href="/courses/<?= $courseId ?>/sections/<?= $row['section_id'] ?>/delete" class="delete-btn">Delete</a>
                </li>
            <?php
            endif; ?>
            <br>
        <?php
        endforeach; ?>
    </ul>

<?php
require_once '../app/includes/footer.php';
