<?php

namespace local_fakesmarts;

class logs
{
    /**
     * Insert a log record
     *
     * @param int $fakesmarts_id
     * @param string $prompt
     * @param string $message
     * @param string $prompt_tokens
     * @param string $response_tokens
     * @param int $cost
     * @throws \dml_exception
     */
    public static function insert($fakesmarts_id, $prompt, $message, $prompt_tokens, $completion_tokens, $total_tokens, $cost) {
        global $DB;
        // Get client IP
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $data = [
            'fakesmarts_id' => $fakesmarts_id,
            'prompt' => $prompt,
            'message' => $message,
            'prompt_tokens' => $prompt_tokens,
            'completion_tokens' => $completion_tokens,
            'total_tokens' => $total_tokens,
            'cost' => $cost,
            'ip' => $ip,
            'timecreated' => time()
        ];

        $DB->insert_record('local_fakesmarts_logs', $data);
    }

    /**
     * Get logs for a given fakesmarts_id
     *
     * @param int $fakesmarts_id
     * @return array
     */
    public static function get_logs($fakesmarts_id) {
        global $DB;
        $sql = "SELECT 
                    id, 
                    fakesmarts_id, 
                    prompt, 
                    message,
                    prompt_tokens,
                    completion_tokens,
                    total_tokens,
                    cost,
                    DATE_FORMAT(FROM_UNIXTIME(timecreated), '%m/%d/%Y %h:%i') as timecreated,
                    ip
                FROM 
                    {local_fakesmarts_logs} 
                WHERE 
                    fakesmarts_id = :fakesmarts_id 
                ORDER BY 
                    timecreated DESC";
        $params = [
            'fakesmarts_id' => $fakesmarts_id
        ];
        $logs = $DB->get_records_sql($sql, $params);
        return array_values($logs);
    }

}