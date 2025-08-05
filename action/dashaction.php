<?php
/**
 * Dashboard Action Functions
 * 
 * Provides real-time statistics for the dashboard
 */

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Class' . DIRECTORY_SEPARATOR . 'config.php';

/**
 * Get total number of active bugs
 * 
 * @return int Number of active bugs
 */
function get_bugs() {
    global $connect;
    
    try {
        $query = "SELECT COUNT(*) as bug_count FROM bugs WHERE status != 'Fixed' AND status != 'Closed'";
        $result = $connect->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['bug_count'];
        }
        
        return 0;
    } catch (Exception $e) {
        error_log("Error getting bug count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get total number of fixed bugs
 * 
 * @return int Number of fixed bugs
 */
function get_fixed_bugs() {
    global $connect;
    
    try {
        $query = "SELECT COUNT(*) as fixed_count FROM bugs WHERE status = 'Fixed'";
        $result = $connect->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['fixed_count'];
        }
        
        return 0;
    } catch (Exception $e) {
        error_log("Error getting fixed bug count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get total number of applications tested
 * 
 * @return int Number of applications tested
 */
function get_apps_tested() {
    global $connect;
    
    try {
        $query = "SELECT COUNT(*) as app_count FROM applications WHERE status = 'Tested'";
        $result = $connect->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['app_count'];
        }
        
        return 0;
    } catch (Exception $e) {
        error_log("Error getting app count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get total number of follow-ups
 * 
 * @return int Number of follow-ups
 */
function get_followup() {
    global $connect;
    
    try {
        $query = "SELECT COUNT(*) as followup_count FROM follow_ups WHERE status = 'Pending'";
        $result = $connect->query($query);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['followup_count'];
        }
        
        return 0;
    } catch (Exception $e) {
        error_log("Error getting followup count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get recent bugs for dashboard
 * 
 * @param int $limit Number of recent bugs to return
 * @return array Array of recent bugs
 */
function get_recent_bugs($limit = 5) {
    global $connect;
    
    try {
        $limit = (int)$limit;
        $query = "SELECT b.*, a.name as app_name, u.username as reported_by 
                  FROM bugs b 
                  LEFT JOIN applications a ON b.application_id = a.id 
                  LEFT JOIN users u ON b.reported_by = u.id 
                  ORDER BY b.created_at DESC 
                  LIMIT ?";
        
        $stmt = $connect->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $bugs = [];
        while ($row = $result->fetch_assoc()) {
            $bugs[] = $row;
        }
        
        return $bugs;
    } catch (Exception $e) {
        error_log("Error getting recent bugs: " . $e->getMessage());
        return [];
    }
}

/**
 * Get user performance statistics
 * 
 * @param int $user_id User ID
 * @return array Performance statistics
 */
function get_user_performance($user_id) {
    global $connect;
    
    try {
        $user_id = (int)$user_id;
        
        // Get bugs reported by user
        $query1 = "SELECT COUNT(*) as bugs_reported FROM bugs WHERE reported_by = ?";
        $stmt1 = $connect->prepare($query1);
        $stmt1->bind_param("i", $user_id);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $bugs_reported = $result1->fetch_assoc()['bugs_reported'];
        
        // Get bugs fixed by user (if developer)
        $query2 = "SELECT COUNT(*) as bugs_fixed FROM bugs WHERE assigned_to = ? AND status = 'Fixed'";
        $stmt2 = $connect->prepare($query2);
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $bugs_fixed = $result2->fetch_assoc()['bugs_fixed'];
        
        return [
            'bugs_reported' => $bugs_reported,
            'bugs_fixed' => $bugs_fixed
        ];
    } catch (Exception $e) {
        error_log("Error getting user performance: " . $e->getMessage());
        return ['bugs_reported' => 0, 'bugs_fixed' => 0];
    }
}
?>