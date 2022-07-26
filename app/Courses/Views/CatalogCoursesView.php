<?php

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php'; ?>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Course</th>
            <th scope="col">Author</th>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($courses as $course) : ?>
            <tr>
                <td><?= $course['course_id'] ?></td>
                <td><?= $course['title'] ?></td>
                <td><?= $course['author'] ?></td>
                <td><a href="/courses/<?= $course['course_id'] ?>">Watch course</a></td>
            </tr>
        <?php
        endforeach; ?>
        </tbody>
    </table>


<?php
require_once '../app/includes/footer.php'; ?>