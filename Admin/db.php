<?php
ini_set('error_reporting', E_ERROR);
ini_set('display_errors', 'on');
session_start();
if ($_SESSION['userLogin']['role'] != 'admin') {
  header("Location: ../index.php");
}
$pageName = 'Dashboard';
// ===
include '../model/database.php';
$db = new Database();
$userList = $db->getUsers();
$cans = $db->getCans();
$votes = $db->getVotes();
$votesRc = $db->getVotesRecent(6);
$rankList = $db->getRanking();

?>
<?php include './ad_compo/ad_header.php' ?>
<main>
  <div class="cards">
    <div class="card-single">
      <div>
        <h1><?php echo count($userList) ?></h1>
        <span>Users</span>
      </div>
      <div>
        <span class="las la-users"> </span>
      </div>
    </div>

    <div class="card-single">
      <div>
        <h1><?php echo count($votes) ?></h1>
        <span>Voting</span>
      </div>
      <div>
        <span class="las la-receipt"> </span>
      </div>
    </div>

    <div class="card-single">
      <div>
        <h1><?php echo count($cans) ?></h1>
        <span>Candidates</span>
      </div>
      <div>
        <span class="las la-clipboard-list"> </span>
      </div>
    </div>

  </div>

  <div class="recent-grid">
    <div class="projects">
      <div class="card">
        <div class="card-header">
          <h3>Ranking</h3>
          <a href="./candi.php">
            See Info <span class="las la-arrow-right"> </span>
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table width="100%">
              <thead>
                <tr>
                  <td>Rank</td>
                  <td>SBD</td>
                  <td >Candidates Name</td>
                  <td style='justify-content: center;'>Votes</td>
                </tr>
              </thead>

              <tbody>
                <?php
                foreach ($rankList as $index => $rank) {
                  echo "<tr>";
                  echo "<td> Top " . $index + 1 . "</td>";
                  echo "<td>" . $rank['can_id'] . "</td>";
                  echo "<td >" . $rank['can_name'] . "</td>";
                  echo "<td style='justify-content: center;''>" . $rank['votes'] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="customers">
      <div class="card">
        <div class="card-header">
          <h3>Recent vote</h3>
          <a href="./votes.php">
            See All <span class="las la-arrow-right"> </span>
          </a>
        </div>
        <div class="card-body">
          <?php 
            foreach( $votesRc as $vote) {
                echo "<div class='customer'>
                <div class='info'>
                  <img src='./images/formUserImg.png' width='40px' height='40px' alt='' />
                  <div>
                    <h4><p>[ ".$vote['created']." ] </p>".$vote['username']."<p> đã vote cho</p>
                    </h4>
                    <small>".$vote['can_name']."</small>
                  </div>
                </div>
              </div>";
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include './ad_compo/ad_footer.php' ?>