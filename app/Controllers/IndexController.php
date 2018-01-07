<?php

namespace App\Controllers;

use Swoft\App;
use App\Event\Events\EmailEvent;
use Swoft\Bean\Annotation\Controller;
use Swoft\Bean\Annotation\RequestMapping;
use Swoft\Bean\Annotation\View;
use Swoft\Contract\Arrayable;
use Swoft\Exception\Http\BadRequestException;
use Swoft\Web\Response;
use Swoft\Web\Request;
use App\Tasks\EmailTask;
use Swoft\Task\Task;
/**
 * Class IndexController
 * @Controller()
 *
 * @package App\Controllers
 */
class IndexController
{

    public function index()
    {

        App::trigger(EmailEvent::EMAIL_BEFORE_SEND,null,["asd"]);
//        echo phpinfo();
        $result = Task::deliver('email', 'sendEmail', ['1102861547@qq.com','hellowwrew', '你好,ddddd!!!'], Task::TYPE_COR);
        $error = App::trigger(EmailEvent::EMAIL_AFTER_SEND,null,["fgh"]);
        $result['error']= $error;
        return $result;
////        return "dsd";
//        if($result){
//            return $result;
//        }else{
//            return "no";
//        }
    }


    public function svg($money,$num,$day){
         if($day <=$num) {
             $vs = $num / $day;

             $svgnum = $vs * $day;

             $surnum = $num - $svgnum;

             $arr = [];
             for ($i = 0; $i < $day; $i++) {
                 $arr[$i] = $vs;
             }

             for ($i = 0; $i < $surnum; $i++) {
                 $rand = mt_srand(0,$day);
                 $arr[$rand]+=1;
             }

             print_r($arr);
         }
    }


    public function arrayable()
    {
        return (new class implements Arrayable
        {
            /**
             * @return array
             */
            public function toArray(): array
            {
                return [
                    'name' => 'Swoft',
                    'notes' => ['New Generation of PHP Framework', 'Hign Performance, Coroutine and Full Stack'],
                    'links' => [
                        [
                            'name' => 'Home',
                            'link' => 'http://www.swoft.org',
                        ],
                        [
                            'name' => 'Documentation',
                            'link' => 'http://doc.swoft.org',
                        ],
                        [
                            'name' => 'Case',
                            'link' => 'http://swoft.org/case',
                        ],
                        [
                            'name' => 'Issue',
                            'link' => 'https://github.com/swoft-cloud/swoft/issues',
                        ],
                        [
                            'name' => 'GitHub',
                            'link' => 'https://github.com/swoft-cloud/swoft',
                        ],
                    ]
                ];
            }

        });
    }

    /**
     * @RequestMapping()
     * @param \Swoft\Web\Response $response
     * @return Response
     */
    public function absolutePath(Response $response)
    {
        $template = '@res/views/index/index.php';
        return $response->view([
            'name' => 'Swoft',
            'notes' => ['New Generation of PHP Framework', 'Hign Performance, Coroutine and Full Stack'],
            'links' => [
                [
                    'name' => 'Home',
                    'link' => 'http://www.swoft.org',
                ],
                [
                    'name' => 'Documentation',
                    'link' => 'http://doc.swoft.org',
                ],
                [
                    'name' => 'Case',
                    'link' => 'http://swoft.org/case',
                ],
                [
                    'name' => 'Issue',
                    'link' => 'https://github.com/swoft-cloud/swoft/issues',
                ],
                [
                    'name' => 'GitHub',
                    'link' => 'https://github.com/swoft-cloud/swoft',
                ],
            ]
        ], $template);
    }

    /**
     * @RequestMapping()
     * @return string
     */
    public function raw()
    {
        $name = 'Swoft';
        return $name;
    }

    /**
     * @RequestMapping()
     */
    public function exception()
    {
        throw new BadRequestException();
    }

    /**
     * @RequestMapping()
     * @param \Swoft\Web\Response $response
     * @return \Swoft\Base\Response
     */
    public function redirect(Response $response)
    {
        return $response->redirect('/');
    }

}
