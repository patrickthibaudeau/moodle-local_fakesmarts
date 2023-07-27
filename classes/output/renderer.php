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

    public function render_content(\templatable $content) {
        $data = $content->export_for_template($this);
        return $this->render_from_template('local_fakesmarts/content', $data);
    }


}
