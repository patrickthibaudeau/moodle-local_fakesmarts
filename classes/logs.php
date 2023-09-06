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
    public static function insert($fakesmarts_id, $prompt, $message, $prompt_tokens, $completion_tokens, $total_tokens, $cost, $context = '') {
        global $DB, $USER;
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
            'userid' => $USER->id,
            'prompt' => $prompt,
            'message' => $message,
            'prompt_tokens' => $prompt_tokens,
            'completion_tokens' => $completion_tokens,
            'total_tokens' => $total_tokens,
            'cost' => $cost,
            'index_context' => $context,
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
        global $DB, $USER;

        $sql = "Select
                    fl.id,
                    fl.fakesmarts_id,
                    f.name As bot_name,
                    fl.userid,
                    u.firstname,
                    u.lastname,
                    u.idnumber,
                    u.email,
                    fl.prompt,
                    fl.message,
                    fl.index_context,
                    fl.prompt_tokens,
                    fl.completion_tokens,
                    fl.total_tokens,
                    fl.cost,
                    fl.ip,
                    DATE_FORMAT(FROM_UNIXTIME(fl.timecreated), '%m/%d/%Y %h:%i') as timecreated
                From
                    {local_fakesmarts_logs} fl Inner Join
                    {user} u On u.id = fl.userid Inner Join
                    {local_fakesmarts} f On f.id = fl.fakesmarts_id
                WHERE 
                    fakesmarts_id = ? ";

        $params = [
            'fakesmarts_id' => $fakesmarts_id
        ];

        // Site admins can see all logs, users can only see their own
        if (!is_siteadmin()) {
            $sql .= " AND f.userid = ?";
            $params['userid'] = $USER->id;
        }

        $sql .= " ORDER BY f.timecreated DESC";

        $logs = $DB->get_records_sql($sql, $params);
        return array_values($logs);
    }

    /**
     * Get total usage cost for a given fakesmarts_id
     *
     * @param int $fakesmarts_id
     * @return array
     */
    public static function get_total_usage_cost($fakesmarts_id, $currency = 'CAD') {
        global $DB;
        $sql = "SELECT 
                    SUM(cost) as total_cost
                FROM 
                    {local_fakesmarts_logs}
                WHERE
                    fakesmarts_id = ?";
        $logs = $DB->get_records_sql($sql, [$fakesmarts_id]);
        $fmt = new \NumberFormatter( 'en_CA', \NumberFormatter::CURRENCY );
        $value = $fmt->formatCurrency(array_values($logs)[0]->total_cost, $currency);
        return $value;
    }

}