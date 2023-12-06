<?php

ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 'on');
session_start();
if ($_SESSION['userLogin']['role'] != 'admin') {
  header("Location: ../index.php");
}
$pageName = 'Users';
// ===
include '../model/database.php';
$db = new Database();
$userList = $db->getUsers();


?>
<?php include './ad_compo/ad_header.php' ?>
<main>
  <div class="cards">
    <div class="card-single">
      <div>
        <h1><?php echo count($userList); ?></h1>
        <span>Users</span>
      </div>
      <div>
        <span class="las la-users"> </span>
      </div>
    </div>

    <div class="card-single" id="btnAddUser">
      <div>
        <h1>Add New</h1>
        <span>User</span>
      </div>
      <div>
        <span class="las la-receipt"> </span>
      </div>
    </div>

    <div class="card-single">
      <div>
        <h1>Search</h1>
        <span>User</span>
      </div>
      <div>
        <span class="las la-clipboard-list"> </span>
      </div>
    </div>


  </div>

  <div class="recent-grid" style="display: block;">
    <div class="projects" id="userTable">
      <div class="card">
        <div class="card-header">
          <h3>User Management</h3>
          <button>
            Filtter <span class="las la-arrow-right"> </span>
          </button>
        </div>
        <!-- Userlist -->
        <div class="card-body">
          <div class="table-responsive">
            <table width="100%">
              <thead>
                <tr>
                  <td>Username</td>
                  <td>Role</td>
                  <td>Password</td>
                  <td>Email</td>
                  <td>Active</td>
                  <td>Created At</td>
                </tr>
              </thead>

              <tbody>
                <?php
                foreach ($userList as $_user) {
                  echo "<tr>";
                  echo "<td>" . $_user['username'] . "</td>";
                  echo "<td>" . $_user['role'] . "</td>";
                  echo "<td>" . $_user['password'] . "</td>";
                  echo "<td>" . $_user['email'] . "</td>";

                  if ($_user['active'] == 'yes') echo "<td><span class='status green'></span>" . $_user['active'] . "</td>";
                  else echo "<td><span class='status red'></span>" . $_user['active'] . "</td>";

                  echo "<td>" . $_user['created_at'] . "</td>";
                  echo "<td class='btnControls' style='--x: 40px; --y: 40px;'>
                  <a class='btnDelete' href='./ad_func/deleteUser.php?username=".$_user['username']."'>
                    Delete <span class='las la-arrow-right'> </span>
                  </a>
                  <a class='btnUpdate' data-email='".$_user['email']."'>
                    Update <span class='las la-arrow-right'> </span>
                  </a>
                </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include './ad_compo/formAddUser.php'?>
  <?php include './ad_compo/formUpdateUser.php'?>
  <?php include '../components/notication.php'?>
</main>

<?php include './ad_compo/ad_footer.php' ?>