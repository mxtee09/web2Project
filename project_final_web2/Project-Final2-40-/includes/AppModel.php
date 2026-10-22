<?php
class AppModel
{
    /** @var mysqli */
    private $db;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
    }

    public function addEventImage($event_id, $image_path)
    {
        $sql = "INSERT INTO event_images (event_id, image_path) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $event_id, $image_path);
        return $stmt->execute();
    }

    public function getEventImages($event_id)
    {
        $sql = "SELECT image_path FROM event_images WHERE event_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $images = [];
        while ($row = $res->fetch_assoc()) {
            $images[] = $row['image_path'];
        }
        return $images;
    }

    public function deleteEventImage($event_id, $image_path)
    {
        $sql = "DELETE FROM event_images WHERE event_id = ? AND image_path = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("is", $event_id, $image_path);
        return $stmt->execute();
    }

    public function deleteAllEventImages($event_id)
    {
        $sql = "DELETE FROM event_images WHERE event_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $event_id);
        return $stmt->execute();
    }

    public function syncEventPeopleCount($event_id)
    {
        $event_id = intval($event_id);
        $query = "SELECT COUNT(*) as total FROM registrations WHERE EventID = $event_id AND LOWER(TRIM(Status)) = 'checked_in'";
        $result = $this->db->query($query);
        if ($result) {
            $count = intval($result->fetch_assoc()['total']);
            $this->db->query("UPDATE events SET CurrentPeople = $count WHERE EventID = $event_id");
        }
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE Email = '$email'";
        return $this->db->query($sql)->fetch_assoc();
    }

    public function registerUser($email, $password, $name, $gender, $age, $role, $job)
    {
        $sql = "INSERT INTO user (Email, Password, Name, Gender, Age, Role, Job)
            VALUES ('$email', '$password', '$name', '$gender', '$age', '$role', '$job')";
        return $this->db->query($sql);
    }

    public function getAllActivities($search = "", $creator = "", $dateFrom = "", $dateTo = "")
    {
        $sql = "SELECT e.*, u.Name FROM events e JOIN user u ON e.creator_id = u.UserID WHERE 1=1";

        if ($search != "") {
            $sql .= " AND e.Title LIKE '%$search%'";
        }
        if ($creator != "") {
            $sql .= " AND u.Name LIKE '%$creator%'";
        }
        if ($dateFrom != "" && $dateTo != "") {
            $sql .= " AND DATE(e.StartDate) >= '$dateFrom' AND DATE(e.StartDate) <= '$dateTo'";
        } elseif ($dateFrom != "") {
            $sql .= " AND DATE(e.StartDate) >= '$dateFrom'";
        } elseif ($dateTo != "") {
            $sql .= " AND DATE(e.StartDate) <= '$dateTo'";
        }
        $sql .= " ORDER BY e.StartDate DESC";
        return $this->db->query($sql);
    }

    public function getMyActivities($user_id)
    {
        $sql = "SELECT r.*, e.Title, e.StartDate, u.Name as creator_name 
                FROM registrations r 
                JOIN events e ON r.EventID = e.EventID 
                JOIN user u ON e.creator_id = u.UserID 
                WHERE r.UserID = $user_id 
                AND r.Status != 'rejected_hidden' 
                ORDER BY e.StartDate DESC";
        return $this->db->query($sql);
    }

    public function getActivitiesByCreator($user_id)
    {
        $sql = "SELECT * FROM events WHERE creator_id = $user_id ORDER BY StartDate DESC";
        return $this->db->query($sql);
    }

    public function getJoinedActivityDetail($event_id, $user_id)
    {
        $sql = "SELECT e.*, r.Status, u.Name as creator_name 
                FROM registrations r
                JOIN events e ON r.EventID = e.EventID
                JOIN user u ON e.creator_id = u.UserID 
                WHERE r.UserID = $user_id AND r.EventID = $event_id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getParticipantsByEvent($event_id)
    {
        $sql = "SELECT r.*, u.Name, u.Email FROM registrations r
                JOIN user u ON r.UserID = u.UserID
                WHERE r.EventID = $event_id";
        return $this->db->query($sql);
    }

    public function deleteActivity($event_id, $user_id)
    {
        $this->deleteAllEventImages($event_id);
        $sql = "DELETE FROM events WHERE EventID = $event_id AND creator_id = $user_id";
        return $this->db->query($sql);
    }

    public function joinActivity($event_id, $user_id)
    {
        $res = $this->db->query("SELECT MaxPeople, EndDate FROM events WHERE EventID = $event_id");
        $event = $res->fetch_assoc();

        date_default_timezone_set('Asia/Bangkok');
        if (strtotime($event['EndDate']) < time()) {
            return "ended";
        }

        $countRes = $this->db->query("SELECT COUNT(*) as total FROM registrations WHERE EventID = $event_id AND Status IN ('approved', 'checked_in')");
        $count = $countRes ? intval($countRes->fetch_assoc()['total']) : 0;
        if ($count >= $event['MaxPeople']) {
            return "full";
        }

        $check = $this->db->query("SELECT * FROM registrations WHERE EventID = $event_id AND UserID = $user_id");
        if ($check->num_rows > 0) return "exists";

        $sql = "INSERT INTO registrations (EventID, UserID, Status) VALUES (?, ?, 'pending')";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $event_id, $user_id);

        return $stmt->execute() ? "success" : "error";
    }

    public function manageParticipantStatus($event_id, $user_id, $action)
    {
        $event_id = intval($event_id);
        $user_id = intval($user_id);

        if ($action == 'approve') {
            $res = $this->db->query("SELECT MaxPeople FROM events WHERE EventID = $event_id");
            $event = $res->fetch_assoc();

            $countRes = $this->db->query("SELECT COUNT(*) as total FROM registrations WHERE EventID = $event_id AND Status IN ('approved', 'checked_in')");
            $count = $countRes ? intval($countRes->fetch_assoc()['total']) : 0;
            if ($count >= $event['MaxPeople']) return "full";

            $this->db->query("UPDATE registrations SET Status = 'approved' WHERE EventID = $event_id AND UserID = $user_id");
            $this->syncEventPeopleCount($event_id);
            return "success";
        }  else if ($action == 'reject') {
            $this->db->query("UPDATE registrations SET Status = 'rejected' WHERE EventID = $event_id AND UserID = $user_id");
            $this->syncEventPeopleCount($event_id);
            return "rejected";
        }
        return false;
    }

    public function createActivity($title, $description, $start_date, $end_date, $max_people, $creator_id)
    {
        $sql = "INSERT INTO events (Title, Desciption, StartDate, EndDate, MaxPeople, CurrentPeople, creator_id)
            VALUES ('$title', '$description', '$start_date', '$end_date', $max_people, 0, $creator_id)";
        if ($this->db->query($sql)) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function getActivityByIdAndCreator($event_id, $creator_id)
    {
        $sql = "SELECT * FROM events WHERE EventID = $event_id AND creator_id = $creator_id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function updateActivity($event_id, $creator_id, $title, $description, $max_people, $start_date, $end_date, $image = "")
    {
        $event_id = intval($event_id);
        $max_people = intval($max_people);

        $countRes = $this->db->query("SELECT COUNT(*) as total FROM registrations WHERE EventID = $event_id AND Status IN ('approved', 'checked_in')");
        $approved_or_checked_in = $countRes ? intval($countRes->fetch_assoc()['total']) : 0;

        $eventRes = $this->db->query("SELECT MaxPeople FROM events WHERE EventID = $event_id");
        $event = $eventRes ? $eventRes->fetch_assoc() : null;
        $oldMaxPeople = $event ? intval($event['MaxPeople']) : 0;

        if ($approved_or_checked_in >= $oldMaxPeople && $max_people < $oldMaxPeople) {
            return 'cannot_reduce_when_full';
        }

        $checked_in_res = $this->db->query("SELECT COUNT(*) as total FROM registrations WHERE EventID = $event_id AND Status = 'checked_in'");
        $checked_in = $checked_in_res ? intval($checked_in_res->fetch_assoc()['total']) : 0;
        if ($max_people < $checked_in) {
            return 'cannot_reduce_below_checked_in';
        }

        $sql = "UPDATE events SET 
                Title='$title', 
                Desciption='$description', 
                MaxPeople=$max_people, 
                StartDate='$start_date', 
                EndDate='$end_date'";
                
        if (!empty($image)) {
            $sql .= ", Image='$image'";
        }
        
        $sql .= " WHERE EventID=$event_id AND creator_id=$creator_id";
        return $this->db->query($sql);
    }

    public function isAlreadyJoined($event_id, $user_id)
    {
        $sql = "SELECT * FROM registrations WHERE EventID = '$event_id' AND UserID = '$user_id'";
        $result = $this->db->query($sql);
        return $result && $result->num_rows > 0;
    }

    public function getJoinedEventIDs($user_id)
    {
        $sql = "SELECT EventID FROM registrations WHERE UserID = '$user_id'";
        $result = $this->db->query($sql);
        $joined = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $joined[] = $row['EventID'];
            }
        }
        return $joined;
    }

    public function getJoinedActivities($user_id)
    {
        $sql = "SELECT e.EventID, e.Title, e.StartDate, e.EndDate, r.Status, u.Name as creator_name 
                FROM registrations r
                JOIN events e ON r.EventID = e.EventID
                JOIN user u ON e.creator_id = u.UserID 
                WHERE r.UserID = $user_id ORDER BY e.StartDate DESC";
        return $this->db->query($sql);
    }

    public function markAsCheckedIn($event_id, $user_id)
    {
        $event_id = intval($event_id);
        $user_id = intval($user_id);

        $sql = "UPDATE registrations SET Status = 'checked_in' WHERE EventID = $event_id AND UserID = $user_id";
        $result = $this->db->query($sql);

        if ($result) {
            $this->syncEventPeopleCount($event_id);
        }
        return $result;
    }

    public function getEventStatistics($eventId)
    {
        $stats = [];
        $eventId = intval($eventId);

        $sqlGender = "SELECT u.Gender, COUNT(*) as count 
                    FROM registrations r 
                    JOIN user u ON r.UserID = u.UserID 
                    WHERE r.EventID = $eventId AND r.Status = 'checked_in'
                    GROUP BY u.Gender";
        $stats['gender'] = $this->db->query($sqlGender);

        $sqlAge = "SELECT 
                    CASE 
                        WHEN u.Age BETWEEN 1 AND 9 THEN '1-9'
                        WHEN u.Age BETWEEN 10 AND 19 THEN '10-19'
                        WHEN u.Age BETWEEN 20 AND 29 THEN '20-29'
                        WHEN u.Age BETWEEN 30 AND 39 THEN '30-39'
                        WHEN u.Age BETWEEN 40 AND 49 THEN '40-49'
                        WHEN u.Age BETWEEN 50 AND 59 THEN '50-59'
                        WHEN u.Age BETWEEN 60 AND 69 THEN '60-69'
                        WHEN u.Age BETWEEN 70 AND 79 THEN '70-79'
                        ELSE '80+' 
                    END as AgeRange,
                    COUNT(*) as count 
                    FROM registrations r 
                    JOIN user u ON r.UserID = u.UserID 
                    WHERE r.EventID = $eventId AND r.Status = 'checked_in'
                    GROUP BY AgeRange 
                    ORDER BY MIN(u.Age)";
        $stats['age'] = $this->db->query($sqlAge);

        $sqlJob = "SELECT u.Job, COUNT(*) as count 
                FROM registrations r 
                JOIN user u ON r.UserID = u.UserID 
                WHERE r.EventID = $eventId AND r.Status = 'checked_in'
                GROUP BY u.Job";
        $stats['job'] = $this->db->query($sqlJob);

        return $stats;
    }

    public function getEventById($event_id)
    {
        $sql = "SELECT * FROM events WHERE EventID = $event_id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getUserNameById($user_id)
    {
        $sql = "SELECT Name FROM user WHERE UserID = " . intval($user_id);
        $result = $this->db->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc()['Name'];
        }
        return "ไม่ระบุ";
    }

   public function leaveActivity($event_id, $user_id)
    {
        $event_id = intval($event_id);
        $user_id = intval($user_id);

        $res = $this->db->query("SELECT Status FROM registrations WHERE EventID = $event_id AND UserID = $user_id");
        if ($res && $res->num_rows > 0) {
            $status = trim(strtolower($res->fetch_assoc()['Status']));
            if ($status == 'rejected' || $status == 'rejected_hidden') {
                return $this->db->query("UPDATE registrations SET Status = 'pending' WHERE EventID = $event_id AND UserID = $user_id");
            }
        }

        $del = $this->db->query("DELETE FROM registrations WHERE EventID = $event_id AND UserID = $user_id");

        if ($del) {
            $this->syncEventPeopleCount($event_id);
            return true;
        }
        return false;
    }

    public function getOrGenerateOTP($event_id, $user_id, $force_new = false)
    {
        $event_id = intval($event_id);
        $user_id = intval($user_id);
        
        $sql = "SELECT OTP, OTP_Expires_At FROM registrations WHERE EventID = $event_id AND UserID = $user_id";
        $res = $this->db->query($sql);
        
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            date_default_timezone_set('Asia/Bangkok');
            $now = new DateTime();
            
            $expired = true;
            if (!empty($row['OTP_Expires_At'])) {
                $expiry = new DateTime($row['OTP_Expires_At']);
                if ($now <= $expiry) {
                    $expired = false;
                }
            }

            if (!$force_new && !$expired && !empty($row['OTP'])) {
                return $row['OTP'];
            }

            $new_otp = sprintf("%06d", mt_rand(1, 999999));
            $new_expiry = $now->modify('+30 minutes')->format('Y-m-d H:i:s');
            
            $update_sql = "UPDATE registrations SET OTP = '$new_otp', OTP_Expires_At = '$new_expiry' WHERE EventID = $event_id AND UserID = $user_id";
            $this->db->query($update_sql);
            
            return $new_otp;
        }
        return false;
    }

   public function verifyUserOTP($event_id, $user_id, $input_otp)
    {
        $event_id = intval($event_id);
        $user_id = intval($user_id);
        $input_otp = $this->db->real_escape_string($input_otp);

        $sql = "SELECT OTP, OTP_Expires_At FROM registrations WHERE EventID = $event_id AND UserID = $user_id";
        $res = $this->db->query($sql);
        
        if ($res && $res->num_rows > 0) {
            $row = $res->fetch_assoc();
            date_default_timezone_set('Asia/Bangkok');
            $now = new DateTime();
            $expiry = !empty($row['OTP_Expires_At']) ? new DateTime($row['OTP_Expires_At']) : new DateTime();

            if ($row['OTP'] === $input_otp && $now <= $expiry) {
                return true;
            }
        }
        return false;
    }
    // ==========================================
    // ส่วนที่เพิ่มใหม่สำหรับระบบค้นหาผู้ใช้และกิจกรรม
    // ==========================================

    public function searchUsersWithEventCount($keyword = "", $exclude_user_id = null)
    {
        $sql = "SELECT u.UserID, u.Name, u.Email, u.Gender, u.Age, 
                       (SELECT COUNT(*) FROM events e WHERE e.creator_id = u.UserID) as event_count 
                FROM user u 
                WHERE 1=1";
        
        $conditions = [];
        if (!empty($keyword)) {
            $keyword = $this->db->real_escape_string($keyword);
            // ค้นหาจากชื่อ Name (Username) หรือ Email
            $conditions[] = "(u.Name LIKE '%$keyword%' OR u.Email LIKE '%$keyword%')";
        }
        
        // ถ้ามีการล็อคอิน ให้ตัดตัวเองออกจากการค้นหา
        if ($exclude_user_id !== null) {
            $exclude_user_id = intval($exclude_user_id);
            $conditions[] = "u.UserID != $exclude_user_id";
        }
        
        if (count($conditions) > 0) {
            $sql .= " AND " . implode(" AND ", $conditions);
        }
        
        $sql .= " ORDER BY event_count DESC, u.Name ASC";
        return $this->db->query($sql);
    }

    public function getUserInfoById($user_id)
    {
        $user_id = intval($user_id);
        $sql = "SELECT * FROM user WHERE UserID = $user_id";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }
}
