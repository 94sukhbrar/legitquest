<?php

/**
 *
 *@copyright : ToXSL Technologies Pvt. Ltd. < www.toxsl.com >
 *@author	 : Shiv Charan Panjeta < shiv@toxsl.com >
 *
 * All Rights Reserved.
 * Proprietary and confidential :  All information contained herein is, and remains
 * the property of ToXSL Technologies Pvt. Ltd. and its partners.
 * Unauthorized copying of this file, via any medium is strictly prohibited.
 */

namespace app\base;

use app\models\User;
use Yii;
use yii\web\Controller;

class TBaseController extends Controller
{

    public $layout = '//legitquest';

    public $menu = [];

    public $_author = '@amusoftech';

    public $top_menu = [];

    public $side_menu = [];

    public $user_menu = [];

    public $tabs_data = null;

    public $tabs_name = null;

    public $dryRun = false;

    public $assetsDir = '@webroot/assets';

    public $ignoreDirs = [];

    public $nav_left = [];

    // nav-left-medium';
    protected $_pageCaption;

    protected $_pageDescription;

    protected $_pageKeywords;


    public function beforeAction($action)
    {
        ini_set('memory_limit', '-1');
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (!Yii::$app->user->isGuest) {
            $this->layout = 'main';
        }

        return true;
    }

    public static function addmenu($label, $link, $icon, $visible = null, $list = null)
    {
        if (!$visible)
            return null;
        $item = [
            'label' => '<i
							class="fa fa-' . $icon . '"></i> <span>' . $label . '</span>',
            'url' => [
                $link
            ]
        ];
        if ($list != null) {
            $item['options'] = [
                'class' => 'menu-list'
            ];

            $item['items'] = $list;
        }

        return $item;
    }

    public function renderNav()
    {
        $this->nav_left = [
            self::addMenu(Yii::t('app', 'Dashboard'), '//dashboard/index', 'home', !User::isGuest()),
            self::addMenu(Yii::t('app', 'User'), '//user', 'user', (User::isAdmin())),

            'Manage' => self::addMenu(Yii::t('app', 'Manage'), '#', 'tasks', User::isAdmin(), [
                self::addMenu(Yii::t('app', 'Email Queue'), '//email-queue/index', 'envelope', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Notices'), '//notice/index', 'tasks', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Login History'), '//login-history/index', 'history', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Feeds'), '//feed/index', 'tasks', User::isAdmin()),
                self::addMenu(Yii::t('app', 'Settings'), '//setting/index', 'tasks', User::isAdmin())
            ])
        ];

        $this->nav_left = array_merge($this->nav_left, $this->renderModuleNev());
        return $this->nav_left;
    }

    public function renderModuleNev()
    {
        $config = include(DB_CONFIG_PATH . 'web.php');
        $nav = [];
        if (!empty($config['modules'])) {
            foreach ($config['modules'] as $modules) {
                $class = isset($modules['class']) ? $modules['class'] : null;
                if (class_exists("$class") && method_exists($class, 'subNav')) {
                    if (!empty($class::subNav())) {
                        $nav[] = $class::subNav();
                    }
                }
            }
        }
        return $nav;
    }
}
