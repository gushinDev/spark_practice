<?php

require_once '../app/includes/header.php';
require_once '../app/includes/navigation.php'; ?>
    <h1 class="text-center">Add section</h1>

    <form method="POST" action="/courses/<?= $courseId ?>/add_section">
        <h2 class="">Content</h2>
        <div class="form-group">
            <label for="role">Type :</label>
            <select name="type" id="role">
                <option value="text" selected>Text</option>
                <option value="link">Link</option>
                <option value="video">Video</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleFormControlTextarea1">Content</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="content"></textarea>
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-primary" name="add_section">Submit</button>
        </div>
    </form>

    <br>
    <br>

    <h2 class="text-center"><a href="/courses">Go back</a></h2>

    </div>

<?php
require_once '../app/includes/footer.php';

