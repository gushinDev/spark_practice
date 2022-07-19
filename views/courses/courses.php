<h1><a href="/courses/create">Create new course</a></h1>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Course</th>
        <th scope="col">Author</th>
        <th scope="col">Content</th>
    </tr>
    </thead>

    <tbody>
    <?php foreach ($userCourses as $userCourse) :?>
        <tr>
            <td><?= $userCourse['course_id']?></td>
            <td><?= $userCourse['title']?></td>
            <td><?= $userCourse['username']?></td>
            <td><a href="/courses/<?= $userCourse['course_id']?>/add_section">Add new section</a></td>
            <td><a href="/courses/<?= $userCourse['course_id']?>">Watch course</a></td>
            <td><a href="/courses/<?= $userCourse['course_id']?>/update">Update</a></td>
            <td><a href="/courses/<?= $userCourse['course_id']?>/delete">Delete</a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

