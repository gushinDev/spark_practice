<?php

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php'; ?>

    <h1>Update course</h1>
    <form method="POST" action="/courses/<?= $courseId ?>/update">
        <div class="form-outline mb-4">
            <label class="form-label" for="form2Example2">Course title</label>
            <input type="text" id="form2Example2" class="form-control" name="title" value="<?= $courseTitle ?>"/>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="update_course">Submit</button>
        </div>
    </form>

    <br>
    <br>

    <h2 class="text-center"><a href="/courses">Go back</a></h2>


<?php
require_once '../app/includes/footer.php';
