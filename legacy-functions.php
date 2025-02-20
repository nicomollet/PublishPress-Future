<?php

/**
 * This file provides access to all legacy functions that are now deprecated.
 */

if (! function_exists('_scheduleExpiratorEvent')) {
    /**
     * Schedules the single event.
     *
     * @since 2.4.3
     * @deprecated 2.4.3
     */
    function _scheduleExpiratorEvent($id, $ts, $opts)
    {
        postexpirator_schedule_event($id, $ts, $opts);
    }
}


if (! function_exists('_unscheduleExpiratorEvent')) {
    /**
     * Unschedules the single event.
     *
     * @since 2.4.3
     * @deprecated 2.4.3
     */
    function _unscheduleExpiratorEvent($id)
    {
        postexpirator_unschedule_event($id);
    }
}


if (! function_exists('postExpiratorExpire')) {
    /**
     * Expires the post.
     *
     * @since 2.4.3
     * @deprecated 2.4.3
     */
    function postExpiratorExpire($id)
    {
        postexpirator_expire_post($id);
    }
}


if (! function_exists('_postExpiratorExpireType')) {
    /**
     * Get the HTML for expire type.
     *
     * @since 2.5.0
     * @deprecated 2.5.0
     */
    function _postExpiratorExpireType($opts)
    {
        ob_start();
        _postexpirator_expire_type($opts);

        return ob_get_clean();
    }
}
