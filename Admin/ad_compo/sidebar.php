<input type="checkbox" id="nav-toggle" checked/>
<div class="sidebar">

    <div class="sidebar-brand">
        <a href="../index.php">
            <h2><span class="lab la-accusoft"></span> <span>Stripe</span></h2>
        </a>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="./db.php" class="<?php if ($pageName == 'Dashboard') echo "active"; ?>"><span class="las la-igloo"> </span> <span>Dashboard</span></a>
            </li>

            <li>
                <a href="./users.php" class="<?php if ($pageName == 'Users') echo "active"; ?>"><span class="las la-users"></span> <span>Users</span></a>
            </li>

            <li>
                <a href="./votes.php" class="<?php if ($pageName == 'Votes') echo "active"; ?>"><span class="las la-receipt"></span> <span>Votes</span></a>
            </li>

            <li>
                <a href="./candi.php" class="<?php if ($pageName == 'Candidates') echo "active"; ?>"><span class="las la-clipboard-list"></span>
                    <span>Candidates</span></a>
            </li>
        </ul>
    </div>
</div>