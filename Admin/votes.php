<?php

ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 'on');
session_start();
if ($_SESSION['userLogin']['role'] != 'admin') {
  header("Location: ../index.php");
}
$pageName = 'Votes';
// ===
include '../model/database.php';
$db = new Database();
$votes = $db->getVotes();

?>
<?php include './ad_compo/ad_header.php' ?>
<main>
  <div class="cards">
    <div class="card-single">
      <div>
        <h1><?php echo count($votes); ?></h1>
        <span>Votes</span>
      </div>
      <div>
        <span class="las la-users"> </span>
      </div>
    </div>

    <div class="card-single" id="btnAddCan">
      <div>
        <h1>Add New</h1>
        <span>Votes</span>
      </div>
      <div>
        <span class="las la-receipt"> </span>
      </div>
    </div>

    <div class="card-single">
      <div>
        <h1>Search</h1>
        <span>Votes</span>
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
                  <td>Vote ID</td>
                  <td>Candidates</td>
                  <td>Voter</td>
                  <td>Create at</td>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($votes as $vote) {
                  echo "<tr>";
                  echo "<td>" . $vote['vote_id'] . "</td>";
                  echo "<td>" . $vote['can_name'] . "</td>";
                  echo "<td>" . $vote['username'] . "</td>";
                  echo "<td>" . $vote['created'] . "</td>";
                  echo "<td class='btnControls' style='--x: 40px; --y: 40px;'>
                  <a class='btnDelete' href='./ad_func/deleteCan.php?can_id=" . $vote['can_id'] . "'>
                    Delete <span class='las la-arrow-right'> </span>
                  </a>
                  <a class='btnUpdate' data-id='" . $vote['can_id'] . "'>
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
  <?php include './ad_compo/formAddVote.php' ?>
  <?php include './ad_compo/formUpdateCan.php' ?>
  <?php include '../components/notication.php' ?>
</main>

<?php include './ad_compo/ad_footer.php' ?>