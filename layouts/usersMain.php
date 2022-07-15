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
             <a href="updateUser.php?update&user_id=<?= $row['user_id'] ?>">Update</a>
           </td>

           <td>
             <?php if ($_SESSION['user_id'] != $row['user_id']) : ?>
               <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                 <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>" />
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