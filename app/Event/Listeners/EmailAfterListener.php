<?php
/**
 * Created by PhpStorm.
 * User: hu
 * Date: 18-1-5
 * Time: 上午11:47
 */

namespace App\Event\Listeners;
use Swoft\App;
use Swoft\Base\RequestContext;
use App\Event\Events\EmailEvent;
use Swoft\Event\EventInterface;
use Swoft\Bean\Annotation\Listener;
use Swoft\Event\EventHandlerInterface;


/**
 * 任务后置事件
 *
 * @Listener(EmailEvent::ON_EMAIL_AFTER_REQUEST)
 * @uses      EmailBeforeListener
 * @version   2018年01月5日
 * @author    kiwi <roczhmg@163.com>
 * @copyright Copyright 2010-2018 swoft software
 * @license   PHP Version 7.x {@link http://www.php.net/license/3_0.txt}
 */
class EmailAfterListener implements EventHandlerInterface{
    /**
     * 事件回调
     *
     * @param EventInterface $event      事件对象
     */
    public function handle(EventInterface $event)
    {
        $contextData = [
            'requestTime' => microtime(true)
        ];
        RequestContext::setContextData($contextData);

        // 日志初始化
        App::getLogger()->initialize();
    }
}