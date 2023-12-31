<?php

namespace local_fakesmarts\output;

/**
 * Description of renderer
 *
 * @author patrick
 */
class renderer extends \plugin_renderer_base {

    /**
     * Used with root/index.php
     * @param \templatable $dashboard
     * @return type
     */
    public function render_dashboard(\templatable $dashboard) {
        $data = $dashboard->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/dashboard', $data);
    }

    /**
     * Used with root/index.php
     * @param \templatable $dashboard
     * @return type
     */
    public function render_bot_config(\templatable $bot_config) {
        $data = $bot_config->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/bot_config', $data);
    }

    /**
     * @param \templatable $content
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_content(\templatable $content) {
        $data = $content->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/content', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_bot_types(\templatable $bot_types) {
        $data = $bot_types->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/bot_types', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_test_bot(\templatable $test_bot) {
        $data = $test_bot->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/test_bot', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_bot_logs(\templatable $logs) {
        $data = $logs->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/bot_logs', $data);
    }


    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_bot_models(\templatable $models) {
        $data = $models->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/bot_models', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_minutes_master(\templatable $message) {
        $data = $message->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/minutes_master', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_bot_app(\templatable $bot) {
        $data = $bot->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/bot_app', $data);
    }

    /**
     * @param \templatable $bot_types
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_translate(\templatable $message) {
        $data = $message->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/translate', $data);
    }
}
