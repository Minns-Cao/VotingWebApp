<?php

ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 'on');
session_start();
if ($_SESSION['userLogin']['role'] != 'admin') {
  header("Location: ../index.php");
}
$pageName = 'Candidates';
// ===
include '../model/database.php';
$db = new Database();
$cans = $db->getCans();

?>
<?php include './ad_compo/ad_header.php' ?>
<main>
  <div class="cards">
    <div class="card-single">
      <div>
        <h1><?php echo count($cans); ?></h1>
        <span>Candidates</span>
      </div>
      <div>
        <span class="las la-users"> </span>
      </div>
    </div>

    <div class="card-single" id="btnAddCan">
      <div>
        <h1>Add New</h1>
        <span>Candidates</span>
      </div>
      <div>
        <span class="las la-receipt"> </span>
      </div>
    </div>

    <div class="card-single">
      <div>
        <h1>Search</h1>
        <span>Candidates</span>
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
          <h3>Candidates Management</h3>
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
                  <td>ID</td>
                  <td>Name</td>
                  <td>Address</td>
                  <td>Description</td>
                  <td>Create at</td>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($cans as $_can) {
                  echo "<tr>";
                  echo "<td>" . $_can['can_id'] . "</td>";
                  echo "<td>" . $_can['can_name'] . "</td>";
                  echo "<td>" . $_can['can_adr'] . "</td>";
                  echo "<td style='white-space: unset;'>" . $_can['can_desc'] . "</td>";

                  echo "<td>" . $_can['created_at'] . "</td>";
                  echo "<td class='btnControls' style='--x: 40px; --y: 40px;'>
                  <a class='btnDelete' href='./ad_func/deleteCan.php?can_id=" . $_can['can_id'] . "'>
                    Delete <span class='las la-arrow-right'> </span>
                  </a>
                  <a class='btnUpdate' data-id='" . $_can['can_id'] . "'>
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
  <?php include './ad_compo/formAddCan.php' ?>
  <?php include './ad_compo/formUpdateCan.php' ?>
  <?php include '../components/notication.php' ?>
</main>

<?php include './ad_compo/ad_footer.php' ?>