<?php
/**
 * Created by PhpStorm.
 * User: hu
 * Date: 18-1-5
 * Time: 上午11:06
 */

namespace App\Event\Events;


class EmailEvent
{
    /**
     * email发送前
     */
    const EMAIL_BEFORE_REQUEST = 'emailBeforeRequest';
    /**
     * email发送后
     */
    const EMAIL_AFTER_REQUEST = 'emailAfterRequest';
}