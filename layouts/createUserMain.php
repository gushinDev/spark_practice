<h1 class="text-center">Create user</h1>
<!--<form method="POST" action="users/create">-->
<form method="POST" action="/users/create">
    <input type="hidden" name="user_id" value="<?= $_SESSION['createUserForm']['user_id'] ?? '' ?>"/>

    <div class="form-group">
        <label for="username">User name</label>
        <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="username"
               value="<?= $_SESSION['createUserForm']['username'] ?? '' ?>">
    </div>
    <br>

    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email"
               value="<?= $_SESSION['createUserForm']['email'] ?? '' ?>">
    </div>
    <br>

    <div class="form-group">
        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="user" selected>User</option>
        </select>
    </div>
    <br>

    <!-- Password input -->
    <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" name="password"/>
        <label class="form-label" for="form2Example2">Password</label>
    </div>

    <div class="form-outline mb-4">
        <input type="password" id="form2Example2" class="form-control" name="confirm"/>
        <label class="form-label" for="form2Example2">Confirm password</label>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary" name="create">Submit</button>
    </div>
</form>

<br>
<br>

<h2 class="text-center"><a href="/users">Go back</a></h2>

</div>