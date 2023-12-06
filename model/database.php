<?php
//điều chỉnh múi giờ
date_default_timezone_set('Asia/Saigon');
class Database
{
    //getConnection: tạo ra kết nối với database
    public function getConnection()
    {
        define('DATABASE_SERVER', 'localhost');
        define('DATABASE_USER', 'root');
        define('DATABASE_PASSWORD', '');
        define('DATABASE_NAME', 'voting');
        $connection = null;
        try {
            $connection = new PDO("mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASSWORD);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected suscessfuly";
            return $connection;
        } catch (PDOException $e) {
            echo "Lỗi nè " . $e->getMessage();
            $connection = null;
            return -1;
        }
    }

    //getUsers: lấy ra danh sách các users
    public function getUsers()
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $users = $statement->fetchAll();
            return $users;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }
    //getUsersByEmail: lấy ra user bằng email
    public function getUserByEmail($email)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users WHERE email='$email'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $user = $statement->fetchAll();
            if (!empty($user[0])) {
                return $user[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //checkUser: kiểm tra user có tồn lại không
    public function checkUser($email, $password)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users WHERE email='" . $email . "' AND password='" . $password . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $users = $statement->fetchAll();
            return $users[0];
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //isDupUsername: kiểm tra xem tên user có bị trùng không
    public function isDupUsername($username)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users WHERE username='" . $username . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $user = $statement->fetchAll();
            if (!empty($user[0])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //isDupEmail: kiểm tra xem tên user có bị trùng không
    public function isDupEmail($email)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM users WHERE email='" . $email . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $user = $statement->fetchAll();
            if (!empty($user[0])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //newUser: tạo ra 1 user mới
    public function addUser($user, $otp)
    {
        $conn = $this->getConnection();
        $sql = "INSERT INTO users(username,role,email,password,otp) VALUES('" . $user->username . "','user','" . $user->email . "','" . $user->password . "','" . $otp . "')";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //newUserByAdmin: admin tạo ra 1 user mới (dont need verified)
    public function addUserByAdmin($username, $role, $email, $password)
    {
        $conn = $this->getConnection();
        $sql = "INSERT INTO users(username,role,email,password,active,otp) VALUES('" . $username . "','" . $role . "','" . $email . "','" . $password . "','yes','0')";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //deleteUserByUsername: xoá 1 user bằng username
    public function deleteUserByUsername($username)
    {
        $conn = $this->getConnection();
        $sql = "DELETE FROM users WHERE username = '" . $username . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //updUserResend: update lại user khi gửi lại mã otp
    public function updUserResend($user, $otp)
    {
        $conn = $this->getConnection();
        // lấy timestemp hiện tại cộng 10 phút
        $timestamp = time() + (10 * 60);
        $now = date('Y-m-d H:i:s', $timestamp);
        $sql = "UPDATE users SET otp='$otp', expiretime='$now' WHERE email='" . $user->email . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //updUserResend: update lại user khi gửi lại mã otp
    public function updUser($username, $role, $password, $email, $usernameOld)
    {
        $conn = $this->getConnection();
        $sql = "UPDATE `users` SET `username` = '$username', `role` = '$role', `email` = '$email', `password` = '$password' WHERE `users`.`username` = '$usernameOld'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //confirmUser: chuyển trạng thái user.active thành yes
    public function confirmUser($email, $otpCode)
    {
        $conn = $this->getConnection();
        $sql = "UPDATE users SET active = 'yes', otp = '0' WHERE email='$email' AND otp='$otpCode'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            return true;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
            return false;
        }
    }

    // ============= candidates
    public function getCans()
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM candidates";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $cans = $statement->fetchAll();
            return $cans;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //updUserResend: update lại user khi gửi lại mã otp
    public function updCan($can_id, $can_name, $can_desc, $can_adr, $can_avt)
    {
        $conn = $this->getConnection();
        $sql = "UPDATE `candidates` SET `can_name` = '$can_name', `can_avt` = '$can_avt', `can_desc` = '$can_desc', `can_adr` = '$can_adr' WHERE `candidates`.`can_id` = '$can_id'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    public function getCansRank()
    {
        $conn = $this->getConnection();
        $sql = "SELECT A.*, COALESCE(B.count, 0) as votes FROM candidates as A 
        LEFT JOIN (SELECT can_id, count(*) AS count FROM votes GROUP BY can_id) as B ON B.can_id = A.can_id
        ORDER BY votes DESC";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $cans = $statement->fetchAll();
            return $cans;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }
    //newCanByAdmin: admin tạo ra 1 candidates mới
    public function addCanByAdmin($can_id, $can_name, $can_desc, $can_adr, $can_avt)
    {
        $conn = $this->getConnection();
        $sql = "INSERT INTO candidates(`can_id`, `can_name`, `can_desc`, `can_adr`, `can_avt`) VALUES('" . $can_id . "','" . $can_name . "','" . $can_desc . "','" . $can_adr . "','".$can_avt."')";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }


    //isDupCanId: kiểm tra id của candidate có bị trùng không
    public function isDupCanId($can_id)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM candidates WHERE can_id='" . $can_id . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $can = $statement->fetchAll();
            if (!empty($can[0])) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //deleteCanById: xoá 1 candidates bằng id
    public function deleteCanById($can_id)
    {
        $conn = $this->getConnection();
        $sql = "DELETE FROM candidates WHERE can_id = '" . $can_id . "'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //getUsersByEmail: lấy ra user bằng email
    public function getCanById($can_id)
    {
        $conn = $this->getConnection();
        $sql = "SELECT * FROM candidates WHERE can_id='$can_id'";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $can = $statement->fetchAll();
            if (!empty($can[0])) {
                return $can[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //rank
    public function getRanking()
    {
        $conn = $this->getConnection();
        $sql = "SELECT A.can_id, A.can_name, COALESCE(B.count, 0) as votes FROM candidates as A LEFT JOIN (SELECT can_id, count(*) AS count FROM votes GROUP BY can_id) as B ON B.can_id = A.can_id ORDER BY votes DESC";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $rank = $statement->fetchAll();
            return $rank;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }
    //rank
    public function getVotesRecent($limit = 5)
    {
        $conn = $this->getConnection();
        $sql = "SELECT A.`vote_id` , B.`username` , C.can_name, A.created_at as created FROM `votes` AS A 
                LEFT JOIN `users` AS B ON B.`id` = A.`user_id` 
                LEFT JOIN `candidates` as C on C.can_id = A.can_id
                ORDER BY created DESC LIMIT 0, ".$limit;
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $votesRc = $statement->fetchAll();
            return $votesRc;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }


    // getVotes

    public function getVotes()
    {
        $conn = $this->getConnection();
        $sql = "SELECT A.`vote_id` , B.`username` , C.can_name, A.created_at as created, B.id as user_id, C.can_id as can_id  FROM `votes` AS A 
                LEFT JOIN `users` AS B ON B.`id` = A.`user_id` 
                LEFT JOIN `candidates` as C on C.can_id = A.can_id
                ORDER BY created DESC";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
            $votes = $statement->fetchAll();
            return $votes;
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    //tạo 1 vote mới
    public function addVote($user_id, $can_id)
    {
        $conn = $this->getConnection();
        $sql = "INSERT INTO votes(user_id, can_id) VALUES('".$user_id."','".$can_id."')";
        try {
            $statement = $conn->prepare($sql);
            $statement->execute();
        } catch (PDOException $e) {
            echo "Lỗi đây: " . $e->getMessage();
        }
    }

    public function isVoted($user_id, $can_id)
    {
        $votes = $this->getVotes();
        foreach ($votes as $vote) {
            if($vote["user_id"] == $user_id && $vote["can_id"] == $can_id) {
                return true;
            }
        }
        return false;
    }
}
