<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
    <form action="/users/create" method="POST">
        <button type="submit" style="font-size:25px">Create new</button>
    </form>
<?php endif; ?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
    </tr>
    </thead>

  <?php $userList = findAllUsers($pdo, $_GET['page']); ?>
    <tbody>
    <?php while ($row = $userList->fetch()) : ?>
        <tr>
            <th scope="row"><?= $row['user_id'] ?></th>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['role'] ?></td>

          <?php if (checkUserIsAdmin()) : ?>
              <td>
                  <a href="/users/<?= $row['user_id'] ?>/update">Update</a>
              </td>

              <td>
                <?php if ($_SESSION['user_id'] != $row['user_id']) : ?>
                    <script>
                        function deleteName(evt) {
                            if (confirm("Вы уверены, что хотите удалить запись?")) {
                                evt.preventDefault();
                                window.history.back();
                            } else {
                                evt.submit();
                            }
                        }
                    </script>
                    <form action="/users" method="post" onsubmit='deleteName(this); return false'>
                        <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>"/>
                        <button type="submit" name="deleteUser">Delete</button>
                    </form>
                <?php endif; ?>
              </td>

          <?php endif; ?>

        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<div style="text-align:center; font-size: 20px;">
    <a href="?page=<?= $pagination['pageStart'] ?>">start</a>
    <a href="?page=<?= $pagination['currentPage'] - 1 ?>">prev</a>
  <?= $pagination['currentPage'] ?>
    <a href="?page=<?= $pagination['currentPage'] + 1 ?>">next</a>
    <a href="?page=<?= $pagination['pageEnd'] ?>">end</a>
</div>

