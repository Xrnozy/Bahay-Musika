<?php
class Auth
{
    private $conn;
    private $session_duration = 3600;

    public function __construct($database_connection)
    {
        $this->conn = $database_connection;
        $this->startSession();
    }

    private function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Authenticate user login
     */
    public function login($username, $password)
    {
        try {
            $stmt = $this->conn->prepare("SELECT id, username, email, password, role, status, first_name, last_name, is_blocked FROM admin_users WHERE (username = ? OR email = ?) AND status = 'active'");
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if ($user['is_blocked']) {
                    return [
                        'success' => false,
                        'message' => 'Your account is blocked. Please contact the head admin.'
                    ];
                }

                if (password_verify($password, $user['password'])) {
                    // Update last login
                    $this->updateLastLogin($user['id']);

                    // Create session
                    $this->createSession($user);

                    // Log activity
                    $this->logActivity($user['id'], 'login', null, null);

                    return [
                        'success' => true,
                        'user' => $user,
                        'message' => 'Login successful'
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Invalid password'
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'User not found or inactive'
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Login error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Create user session
     */
    private function createSession($user)
    {
        $session_token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', time() + $this->session_duration);
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        // Store in database
        $stmt = $this->conn->prepare("INSERT INTO user_sessions (user_id, session_token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user['id'], $session_token, $ip_address, $user_agent, $expires_at);
        $stmt->execute();

        // Store in PHP session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['session_token'] = $session_token;
        $_SESSION['expires_at'] = $expires_at;
        $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated()
    {
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
            return false;
        }

        // Check if session exists and is valid
        $stmt = $this->conn->prepare("SELECT expires_at FROM user_sessions WHERE user_id = ? AND session_token = ? AND is_active = 1");
        $stmt->bind_param("is", $_SESSION['user_id'], $_SESSION['session_token']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $session = $result->fetch_assoc();
            if (strtotime($session['expires_at']) > time()) {
                // Extend session
                $this->extendSession();
                return true;
            } else {
                // Session expired
                $this->logout();
                return false;
            }
        }

        return false;
    }

    /**
     * Check user role permissions
     */
    public function hasPermission($required_role)
    {
        if (!$this->isAuthenticated()) {
            return false;
        }

        $user_role = $_SESSION['role'];

        // Define role hierarchy
        $role_hierarchy = [
            'head_admin' => 3,
            'content_manager' => 2,
            'social_manager' => 1
        ];

        return isset($role_hierarchy[$user_role]) &&
            isset($role_hierarchy[$required_role]) &&
            $role_hierarchy[$user_role] >= $role_hierarchy[$required_role];
    }

    /**
     * Check specific permissions based on role
     */
    public function canManageContent()
    {
        return in_array($_SESSION['role'] ?? '', ['head_admin', 'content_manager']);
    }

    public function canViewDonations()
    {
        return in_array($_SESSION['role'] ?? '', ['head_admin', 'social_manager']);
    }

    public function canViewComments()
    {
        return in_array($_SESSION['role'] ?? '', ['head_admin', 'social_manager']);
    }

    public function canManageUsers()
    {
        return ($_SESSION['role'] ?? '') === 'head_admin';
    }

    /**
     * Extend session
     */
    private function extendSession()
    {
        $new_expires = date('Y-m-d H:i:s', time() + $this->session_duration);

        $stmt = $this->conn->prepare("UPDATE user_sessions SET expires_at = ? WHERE user_id = ? AND session_token = ?");
        $stmt->bind_param("sis", $new_expires, $_SESSION['user_id'], $_SESSION['session_token']);
        $stmt->execute();

        $_SESSION['expires_at'] = $new_expires;
    }

    /**
     * Update last login time
     */
    private function updateLastLogin($user_id)
    {
        $stmt = $this->conn->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    /**
     * Logout user
     */
    public function logout()
    {
        if (isset($_SESSION['user_id']) && isset($_SESSION['session_token'])) {
            // Log activity
            $this->logActivity($_SESSION['user_id'], 'logout', null, null);

            // Deactivate session in database
            $stmt = $this->conn->prepare("UPDATE user_sessions SET is_active = 0 WHERE user_id = ? AND session_token = ?");
            $stmt->bind_param("is", $_SESSION['user_id'], $_SESSION['session_token']);
            $stmt->execute();
        }

        // Clear PHP session
        session_unset();
        session_destroy();

        return true;
    }

    /**
     * Get current user info
     */
    public function getCurrentUser()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }

        $stmt = $this->conn->prepare("SELECT id, username, email, role, first_name, last_name, last_login FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Get online users
     */
    public function getOnlineUsers()
    {
        $stmt = $this->conn->prepare("
            SELECT DISTINCT u.id, u.username, u.role, u.first_name, u.last_name, s.created_at as login_time
            FROM admin_users u 
            JOIN user_sessions s ON u.id = s.user_id 
            WHERE s.is_active = 1 AND s.expires_at > NOW()
            ORDER BY s.created_at DESC
        ");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Log user activity
     */
    public function logActivity($user_id, $action, $table_name = null, $record_id = null, $old_values = null, $new_values = null)
    {
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

        $stmt = $this->conn->prepare("INSERT INTO activity_logs (user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $old_json = $old_values ? json_encode($old_values) : null;
        $new_json = $new_values ? json_encode($new_values) : null;

        $stmt->bind_param("ississss", $user_id, $action, $table_name, $record_id, $old_json, $new_json, $ip_address, $user_agent);
        $stmt->execute();
    }

    /**
     * Change password
     */
    public function changePassword($user_id, $old_password, $new_password)
    {
        // Verify old password
        $stmt = $this->conn->prepare("SELECT password FROM admin_users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($old_password, $user['password'])) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $this->conn->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $hashed_password, $user_id);

                if ($stmt->execute()) {
                    $this->logActivity($user_id, 'password_change', 'admin_users', $user_id);
                    return ['success' => true, 'message' => 'Password changed successfully'];
                } else {
                    return ['success' => false, 'message' => 'Failed to update password'];
                }
            } else {
                return ['success' => false, 'message' => 'Current password is incorrect'];
            }
        }

        return ['success' => false, 'message' => 'User not found'];
    }

    /**
     * Clean expired sessions
     */
    public function cleanExpiredSessions()
    {
        $stmt = $this->conn->prepare("UPDATE user_sessions SET is_active = 0 WHERE expires_at < NOW()");
        $stmt->execute();
        return $stmt->affected_rows;
    }

    /**
     * Check specific permissions for roles
     */
    public function hasPermissions($role, $permission)
    {
        $permissions = [
            'admin' => ['all'],
            'content-manager' => ['manage-content', 'view-content'],
            'social-manager' => ['manage-social', 'view-social']
        ];

        if (isset($permissions[$role])) {
            return in_array('all', $permissions[$role]) || in_array($permission, $permissions[$role]);
        }

        return false;
    }

    /**
     * Check if the role can edit login-related functionalities
     */
    public function canEditLogin($role)
    {
        $restrictedRoles = ['content-manager', 'social-manager'];
        return !in_array($role, $restrictedRoles);
    }
}
