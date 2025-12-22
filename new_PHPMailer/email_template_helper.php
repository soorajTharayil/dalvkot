<?php
/**
 * Email Template Helper
 * 
 * This helper provides functions to:
 * 1. Load email templates from Template.json
 * 2. Render templates with variables
 * 3. Handle UTF-8 encoding properly to prevent encoding issues
 * 4. Safely escape strings for database insertion
 */

class EmailTemplateHelper {
    private static $templates = null;
    private static $templatePath = null;

    /**
     * Initialize template path
     */
    public static function init($templatePath = null) {
        if ($templatePath === null) {
            $templatePath = __DIR__ . '/Template.json';
        }
        self::$templatePath = $templatePath;
    }

    /**
     * Load templates from JSON file
     */
    private static function loadTemplates() {
        if (self::$templates !== null) {
            return self::$templates;
        }

        if (self::$templatePath === null) {
            self::init();
        }

        if (!file_exists(self::$templatePath)) {
            throw new Exception("Template file not found: " . self::$templatePath);
        }

        $jsonContent = file_get_contents(self::$templatePath);
        self::$templates = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error parsing template JSON: " . json_last_error_msg());
        }

        return self::$templates;
    }

    /**
     * Get a template by path (e.g., 'patient.welcome' or 'admin.welcome_role2')
     */
    public static function getTemplate($templatePath) {
        $templates = self::loadTemplates();
        $parts = explode('.', $templatePath);
        
        $current = $templates;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                throw new Exception("Template not found: " . $templatePath);
            }
            $current = $current[$part];
        }

        return $current;
    }

    /**
     * Render a template with variables
     * 
     * @param string $templatePath Template path (e.g., 'patient.welcome')
     * @param array $variables Variables to replace in template
     * @return array Array with 'subject' and 'body' keys
     */
    public static function render($templatePath, $variables = []) {
        $template = self::getTemplate($templatePath);
        
        $subject = self::replaceVariables($template['subject'], $variables);
        $body = self::replaceVariables($template['body'], $variables);

        return [
            'subject' => $subject,
            'body' => $body
        ];
    }

    /**
     * Replace variables in template string
     * Handles UTF-8 encoding properly
     */
    private static function replaceVariables($template, $variables) {
        // Ensure template is UTF-8
        if (!mb_check_encoding($template, 'UTF-8')) {
            $template = mb_convert_encoding($template, 'UTF-8', 'auto');
        }

        foreach ($variables as $key => $value) {
            // Ensure value is UTF-8 and properly encoded
            if (is_string($value)) {
                if (!mb_check_encoding($value, 'UTF-8')) {
                    $value = mb_convert_encoding($value, 'UTF-8', 'auto');
                }
                // Don't escape HTML here - templates may contain HTML
                // But ensure proper UTF-8 encoding
            } elseif (is_object($value) || is_array($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            } else {
                $value = (string)$value;
            }

            $template = str_replace('{{' . $key . '}}', $value, $template);
        }

        return $template;
    }

    /**
     * Safely escape string for database insertion with UTF-8 support
     * This ensures proper encoding for non-ASCII characters
     */
    public static function escapeForDatabase($connection, $string) {
        // Ensure string is UTF-8
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'auto');
        }

        // Set connection charset to UTF-8 if not already set
        if (method_exists($connection, 'set_charset')) {
            $connection->set_charset('utf8mb4');
        } elseif (method_exists($connection, 'query')) {
            $connection->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
        }

        // Escape the string
        return $connection->real_escape_string($string);
    }

    /**
     * Insert notification into database with proper encoding
     */
    public static function insertNotification($conn_g, $type, $message, $email, $subject, $HID) {
        // Ensure UTF-8 encoding
        self::ensureUTF8Connection($conn_g);

        $escapedMessage = self::escapeForDatabase($conn_g, $message);
        $escapedEmail = self::escapeForDatabase($conn_g, $email);
        $escapedSubject = self::escapeForDatabase($conn_g, $subject);

        $query = "INSERT INTO `notification`(`type`, `message`, `status`, `mobile_email`, `subject`, `HID`) 
                  VALUES ('{$type}', '{$escapedMessage}', 0, '{$escapedEmail}', '{$escapedSubject}', '{$HID}')";

        return $conn_g->query($query);
    }

    /**
     * Ensure database connection uses UTF-8
     */
    private static function ensureUTF8Connection($connection) {
        if (method_exists($connection, 'set_charset')) {
            $connection->set_charset('utf8mb4');
        } elseif (method_exists($connection, 'query')) {
            $connection->query("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
            $connection->query("SET CHARACTER SET utf8mb4");
        }
    }

    /**
     * Escape HTML special characters (for user input that shouldn't contain HTML)
     */
    public static function escapeHtml($string) {
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'auto');
        }
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Build reasons HTML from reason array and res mapping
     */
    public static function buildReasonsHtml($reasons, $res) {
        $html = '';
        if ($reasons) {
            foreach ($reasons as $key1 => $value) {
                if ($value && isset($res[$key1])) {
                    $html .= "<br /><strong> Reason: </strong>" . self::escapeHtml($res[$key1]) . " ";
                }
            }
        }
        return $html;
    }

    /**
     * Build comments HTML from comment array
     */
    public static function buildCommentsHtml($comments) {
        $html = '';
        if ($comments && !empty($comments)) {
            foreach ($comments as $key2 => $value) {
                $html .= "<br /><strong> Comment: </strong>" . self::escapeHtml($value) . " ";
            }
        }
        return $html;
    }

    /**
     * Build general comment HTML (handles UTF-8 properly)
     */
    public static function buildGeneralCommentHtml($suggestionText) {
        if (isset($suggestionText) && !empty($suggestionText)) {
            // Ensure UTF-8 encoding
            if (!mb_check_encoding($suggestionText, 'UTF-8')) {
                $suggestionText = mb_convert_encoding($suggestionText, 'UTF-8', 'auto');
            }
            return '<br /><strong>General Comment:</strong>' . self::escapeHtml($suggestionText) . ' <br />';
        }
        return '';
    }

    /**
     * Build complaint/interim ticket table HTML
     */
    public static function buildComplaintTableHtml($data) {
        $html = '<table border="1" cellpadding="5">';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Complaint reported on</b></td></tr>';
        $html .= '<tr><td width="40%">Time & Date</td><td width="60%">' . self::escapeHtml($data['created_on']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Complaint details</b></td></tr>';
        $html .= '<tr><td width="40%">Category</td><td width="60%">' . self::escapeHtml($data['department']) . '</td></tr>';
        $html .= '<tr><td width="40%">Complaint</td><td width="60%">' . self::escapeHtml($data['complaint']) . '</td></tr>';
        
        if (!empty($data['description'])) {
            $html .= '<tr><td width="40%">Description</td><td width="60%">' . self::escapeHtml($data['description']) . '</td></tr>';
        }
        
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Complaint raised in </b></td></tr>';
        $html .= '<tr><td width="40%">Floor/Ward</td><td width="60%">' . self::escapeHtml($data['ward']) . '</td></tr>';
        $html .= '<tr><td width="40%">Site</td><td width="60%">' . self::escapeHtml($data['bed_no']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Complaint raised by</b></td></tr>';
        $html .= '<tr><td width="40%">Patient name</td><td width="60%">' . self::escapeHtml($data['patient_name']) . '</td></tr>';
        $html .= '<tr><td width="40%">Patient UHID</td><td width="60%">' . self::escapeHtml($data['patient_uhid']) . '</td></tr>';
        $html .= '<tr><td width="40%">Mobile number</td><td width="60%">' . self::escapeHtml($data['mobile']) . '</td></tr>';
        $html .= '<tr><td width="40%">Source</td><td width="60%">' . self::escapeHtml($data['source']) . '</td></tr>';
        $html .= '</table>';
        
        return $html;
    }

    /**
     * Build ISR (Service Request) table HTML
     */
    public static function buildISRTableHtml($data) {
        $html = '<table border="1" cellpadding="5">';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Request reported on</b></td></tr>';
        $html .= '<tr><td width="40%">Time & Date</td><td width="60%">' . self::escapeHtml($data['created_on']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Service request details</b></td></tr>';
        $html .= '<tr><td width="40%">Category</td><td width="60%">' . self::escapeHtml($data['department']) . '</td></tr>';
        $html .= '<tr><td width="40%">Service request</td><td width="60%">' . self::escapeHtml($data['service_request']) . '</td></tr>';
        $html .= '<tr><td width="40%">Priority</td><td width="60%">' . self::escapeHtml($data['priority']) . '</td></tr>';
        
        if (!empty($data['description'])) {
            $html .= '<tr><td width="40%">Description</td><td width="60%">' . self::escapeHtml($data['description']) . '</td></tr>';
        }
        
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Request reported in</b></td></tr>';
        $html .= '<tr><td width="40%">Floor/Ward</td><td width="60%">' . self::escapeHtml($data['ward']) . '</td></tr>';
        $html .= '<tr><td width="40%">Site</td><td width="60%">' . self::escapeHtml($data['bed_no']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Request reported by</b></td></tr>';
        $html .= '<tr><td width="40%">Employee name</td><td width="60%">' . self::escapeHtml($data['employee_name']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee ID</td><td width="60%">' . self::escapeHtml($data['employee_id']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee role</td><td width="60%">' . self::escapeHtml($data['employee_role']) . '</td></tr>';
        $html .= '<tr><td width="40%">Mobile number</td><td width="60%">' . self::escapeHtml($data['mobile']) . '</td></tr>';
        $html .= '<tr><td width="40%">Source</td><td width="60%">' . self::escapeHtml($data['source']) . '</td></tr>';
        $html .= '<tr><td width="40%">Email ID</td><td width="60%">' . self::escapeHtml($data['email']) . '</td></tr>';
        $html .= '</table>';
        
        return $html;
    }

    /**
     * Build Incident table HTML
     */
    public static function buildIncidentTableHtml($data) {
        $html = '<table border="1" cellpadding="5">';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Incident reported on</b></td></tr>';
        $html .= '<tr><td width="40%">Time & Date</td><td width="60%">' . self::escapeHtml($data['created_on']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Incident details</b></td></tr>';
        $html .= '<tr><td width="40%">Incident</td><td width="60%">' . self::escapeHtml($data['incident']) . '</td></tr>';
        $html .= '<tr><td width="40%">Category</td><td width="60%">' . self::escapeHtml($data['department']) . '</td></tr>';
        $html .= '<tr><td width="40%">Incident Occured On</td><td width="60%">' . self::escapeHtml($data['incident_occured_in']) . '</td></tr>';
        $html .= '<tr><td width="40%">Assigned Risk</td><td width="60%">' . self::escapeHtml($data['risk_level']) . '</td></tr>';
        $html .= '<tr><td width="40%">Assigned Priority</td><td width="60%">' . self::escapeHtml($data['priority']) . '</td></tr>';
        $html .= '<tr><td width="40%">Assigned Severity</td><td width="60%">' . self::escapeHtml($data['incident_type']) . '</td></tr>';
        
        if (!empty($data['description'])) {
            $html .= '<tr><td width="40%">Description</td><td width="60%">' . self::escapeHtml($data['description']) . '</td></tr>';
        }
        
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Incident reported in</b></td></tr>';
        $html .= '<tr><td width="40%">Floor/Ward</td><td width="60%">' . self::escapeHtml($data['ward']) . '</td></tr>';
        $html .= '<tr><td width="40%">Site</td><td width="60%">' . self::escapeHtml($data['bed_no']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Incident reported by</b></td></tr>';
        $html .= '<tr><td width="40%">Employee name</td><td width="60%">' . self::escapeHtml($data['employee_name']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee ID</td><td width="60%">' . self::escapeHtml($data['employee_id']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee role</td><td width="60%">' . self::escapeHtml($data['employee_role']) . '</td></tr>';
        $html .= '<tr><td width="40%">Mobile number</td><td width="60%">' . self::escapeHtml($data['mobile']) . '</td></tr>';
        $html .= '<tr><td width="40%">Source</td><td width="60%">' . self::escapeHtml($data['source']) . '</td></tr>';
        $html .= '<tr><td width="40%">Email ID</td><td width="60%">' . self::escapeHtml($data['email']) . '</td></tr>';
        
        if (!empty($data['patient_name'])) {
            $html .= '<tr><td colspan="2" style="text-align:center;"><b>Patient Details</b></td></tr>';
            $html .= '<tr><td width="40%">Patient name</td><td width="60%">' . self::escapeHtml($data['patient_name']) . '</td></tr>';
            $html .= '<tr><td width="40%">Patient ID</td><td width="60%">' . self::escapeHtml($data['patient_id']) . '</td></tr>';
        }
        
        $html .= '</table>';
        
        return $html;
    }

    /**
     * Build Grievance table HTML
     */
    public static function buildGrievanceTableHtml($data) {
        $html = '<table border="1" cellpadding="5">';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Grievance reported on</b></td></tr>';
        $html .= '<tr><td width="40%">Time & Date</td><td width="60%">' . self::escapeHtml($data['created_on']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Grievance details</b></td></tr>';
        $html .= '<tr><td width="40%">Category</td><td width="60%">' . self::escapeHtml($data['department']) . '</td></tr>';
        $html .= '<tr><td width="40%">Grievance</td><td width="60%">' . self::escapeHtml($data['grievance']) . '</td></tr>';
        
        if (!empty($data['description'])) {
            $html .= '<tr><td width="40%">Description</td><td width="60%">' . self::escapeHtml($data['description']) . '</td></tr>';
        }
        
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Grievance reported in</b></td></tr>';
        $html .= '<tr><td width="40%">Floor/Ward</td><td width="60%">' . self::escapeHtml($data['ward']) . '</td></tr>';
        $html .= '<tr><td width="40%">Site</td><td width="60%">' . self::escapeHtml($data['bed_no']) . '</td></tr>';
        $html .= '<tr><td colspan="2" style="text-align:center;"><b>Grievance reported by</b></td></tr>';
        $html .= '<tr><td width="40%">Employee name</td><td width="60%">' . self::escapeHtml($data['employee_name']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee ID</td><td width="60%">' . self::escapeHtml($data['employee_id']) . '</td></tr>';
        $html .= '<tr><td width="40%">Employee role</td><td width="60%">' . self::escapeHtml($data['employee_role']) . '</td></tr>';
        $html .= '<tr><td width="40%">Mobile number</td><td width="60%">' . self::escapeHtml($data['mobile']) . '</td></tr>';
        $html .= '<tr><td width="40%">Source</td><td width="60%">' . self::escapeHtml($data['source']) . '</td></tr>';
        $html .= '<tr><td width="40%">Email ID</td><td width="60%">' . self::escapeHtml($data['email']) . '</td></tr>';
        $html .= '</table>';
        
        return $html;
    }
}

// Auto-initialize
EmailTemplateHelper::init();

