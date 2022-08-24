<?php

if(1) {
    $error_code = 0;
    define('ERR_A_REWARD_MASK', 0x00590000);

    define('ERR_A_REWARD_UNKNOWN_ERROR', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_UNKNOWN_ERROR] = 'Незвестная ошибка.';

    define('ERR_A_REWARD_WORKER_NAME_IS_EMPTY', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_WORKER_NAME_IS_EMPTY] = 'Не указано имя сотрудника';

    define('ERR_A_REWARD_WORKER_NOT_FOUND', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_WORKER_NOT_FOUND] = 'Указанный сотрудник не найден';

    define('ERR_A_PHOTO_ERROR_UPLOAD_IMAGE', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_PHOTO_ERROR_UPLOAD_IMAGE] = 'Указанный сотрудник не найден';

    define('ERR_A_REWARD_REWARD_NOT_FOUND', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_REWARD_NOT_FOUND] = 'Награда не найдена';

    define('ERR_A_REWARD_REWARD_TITLE_IS_EMPTY', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_REWARD_TITLE_IS_EMPTY] = 'Не указано название награды';

    define('ERR_A_REWARD_OPINION_NOT_FOUND', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_OPINION_NOT_FOUND] = 'Отзыв не найден';

    define('ERR_A_REWARD_OPINION_NAME_IS_EMPTY', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_OPINION_NAME_IS_EMPTY] = 'Не указано имя';

    define('ERR_A_REWARD_OPINION_TEXT_IS_EMPTY', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_OPINION_TEXT_IS_EMPTY] = 'Текст отзыва указано имя';

    define('ERR_A_REWARD_WORKER_HAS_ASSIGNED_REWARDS', ERR_A_REWARD_MASK | $error_code++);
    UserError::$Errors[ERR_A_REWARD_WORKER_HAS_ASSIGNED_REWARDS] = 'Нельзя удалить сотрудника, которому назначена награда';
}

class AdminModule
{
    static $TITLE = 'Награды';

    private $_db;

    private $_config;

    private $_page;
    private $_id;
    private $_title;
    private $rewardMgr;

    function __construct($config, $aconfig, $id)
    {
        global $OBJECTS;

        $this->_id = &$id;
        $this->_config = &$config;
        $this->_aconfig = &$aconfig;
        $this->_db = DBFactory::GetInstance($this->_config['db']);

        LibFactory::GetMStatic('reward', 'rewardmgr');
        $this->rewardMgr = RewardMgr::GetInstance();

        LibFactory::GetStatic("data");
        LibFactory::GetStatic("ustring");

        LibFactory::GetStatic('cache');
        LibFactory::GetStatic('data');

        App::$Title->AddScript('http://maps.api.2gis.ru/1.0');
        App::$Title->AddScript('/resources/scripts/modules/cities/cities.js');


        App::$Title->AddStyle('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/css/ui-lightness/jquery-ui-1.10.4.custom.min.css');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-1.10.2.js');
        App::$Title->AddScript('/resources/scripts/themes/frameworks/jquery/jquery-ui-1.10.4/js/jquery-ui-1.10.4.custom.min.js');

        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap.css');
        App::$Title->AddStyle('/resources/bootstrap/css/bootstrap-theme.css');

        App::$Title->AddScript('/resources/bootstrap/js/bootstrap.min.js');
        App::$Title->AddScript('http://api-maps.yandex.ru/2.1/?lang=ru_RU');
    }

    // обязательные функции
    function Action()
    {
        if($this->_PostAction()) return;
        $this->_GetAction();
    }

    function GetPage()
    {
        switch($this->_page) {
            case 'workers':
                $this->_title = "Сотрудники";
                $html = $this->_GetWorkers();
                break;
             case 'new_worker':
                $this->_title = "Добавить сотрудника";
                $html = $this->_GetWorkerNew();
                break;
            case 'edit_worker':
                $this->_title = "Изменить сотрудника";
                $html = $this->_GetWorkerEdit();
                break;
            case 'delete_worker':
                $this->_GetWorkerDelete();
                Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=workers');
                break;
            // rewards
            case 'rewards':
                $this->_title = "Награды";
                $html = $this->_GetRewards();
                break;
             case 'new_reward':
                $this->_title = "Добавить награду";
                $html = $this->_GetRewardNew();
                break;
            case 'edit_reward':
                $this->_title = "Изменить награду";
                $html = $this->_GetRewardEdit();
                break;
            case 'delete_reward':
                $this->_GetRewardDelete();
                Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=rewards');
                break;
            case 'ajax_reward_toggle_visibility':
                $this->_GetAjaxToggleVisibility();
                break;
            // opinions
            case 'opinions':
                $this->_title = "Отзывы";
                $html = $this->_GetOpinions();
                break;
             case 'new_opinion':
                $this->_title = "Добавить отзыв";
                $html = $this->_GetOpinionNew();
                break;
            case 'edit_opinion':
                $this->_title = "Изменить отзыв";
                $html = $this->_GetOpinionEdit();
                break;
            case 'delete_opinion':
                $this->_GetOpinionDelete();
                Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=opinions');
                break;
            case 'ajax_opinion_toggle_visibility':
                $this->_GetAjaxOpinionToggleVisibility();
                break;
            // ==============================

            default:
                $this->_title = "Список сотрудников";
                $html = $this->_GetWorkers();
                break;
        }
        return $html;
    }

    function GetTabs()
    {
        return [
            'tabs' => [
                ['name' => 'action', 'value' => 'workers', 'text' => 'Сотрудники'],
                ['name' => 'action', 'value' => 'rewards', 'text' => 'Награды'],
                ['name' => 'action', 'value' => 'opinions', 'text' => 'Отзывы'],
            ],
            'selected' => $this->_page
        ];
    }

    function GetTitle()
    {
        return $this->_title;
    }

    // обработка запросов
    private function _PostAction()
    {
        global $DCONFIG, $OBJECTS;

        switch($_POST['action']) {
            // worker actions
            case 'new_worker':
                if ($this->_PostWorker())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=workers');
                break;
            case 'edit_worker':
                if ($this->_PostWorker())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=workers');
                break;
            // reward actions
            case 'new_reward':
                if ($this->_PostReward()) {
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=rewards');
                }
                break;
            case 'edit_reward':
                if ($this->_PostReward())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=rewards');
                break;
            case 'save_reward_orders':
                if($this->_PostSaveRewardsOrders()) {
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=rewards');
                break;
                }
            // opinoins actions
            case 'new_opinion':
                if ($this->_PostOpinion()) {
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=opinions');
                }
                break;
            case 'edit_opinion':
                if ($this->_PostOpinion())
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=opinions');
                break;
            case 'save_opinion_orders':
                if($this->_PostSaveOpinionsOrders()) {
                    Response::Redirect('?' . $DCONFIG['SECTION_ID_URL'] . '&action=opinions');
                break;
                }
        }

        return false;
    }

    private function _GetAction()
    {
        global $DCONFIG;
        switch ($_GET['action']) {
            default:
                $this->_page = $_GET['action'];
                break;
        }
    }

    private function _GetWorkers()
    {
        // $filter = [
        //     'flags' => [
        //         'objects' => true,
        //     ],
        //     'dbg' => 0,
        // ];

        // $workers = $this->rewardMgr->GetWorkers($filter);
        $workers = $this->_get_workers();

        return STPL::Fetch('admin/modules/reward/workers_list', [
            'section_id' => $this->_id,
            'workers' => $workers,
            'action' => 'new_worker',
        ]);
    }

    private function _GetWorkerNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = [];
        $form['section_id'] = $this->_id;

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['name']     = App::$Request->Post['name']->Value(Request::OUT_HTML);
            $form['position'] = App::$Request->Post['position']->Value(Request::OUT_HTML);
            // $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0, 1]);

        } else {
            $form['name']     = '';
            $form['position'] = '';
            // $form['is_visible'] = 0;
        }

        return STPL::Fetch('admin/modules/reward/worker_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'new_worker',
        ]);
    }

    private function _GetWorkerEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $worker = $this->rewardMgr->GetWorker($id);
        if($worker === null) {
            UserError::AddErrorIndexed('global', ERR_A_REWARD_WORKER_NOT_FOUND);
            return STPL::Fetch('admin/modules/reward/worker_edit');
        }

        $form['id'] = $worker->id;
        $form['section_id'] = $this->_id;
        $form['image']      = $worker->image;
        $form['thumb']      = $worker->thumb;

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['name'] = App::$Request->Post['name']->Value(Request::OUT_HTML);
            $form['position'] = App::$Request->Post['position']->Value(Request::OUT_HTML);
            // $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0, 1]);
        } else {
            $form['name']     = $worker->name;
            $form['position'] = $worker->position;
        }

        return STPL::Fetch('admin/modules/reward/worker_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'edit_worker',
        ]);
    }

    /**
     * @return array|bool|null
     */
    private function _PostWorker()
    {
        global $CONFIG, $OBJECTS;

        $id       = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $name     = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN );
        $position = App::$Request->Post['position']->Value();
        // $is_visible    = App::$Request->Post['is_visible']->Enum(0, [0, 1]);

        if($name == "") {
            UserError::AddErrorIndexed('name', ERR_A_REWARD_WORKER_NAME_IS_EMPTY);
        }

        if(UserError::IsError()) {
            return false;
        } 


        if($id > 0) {
            $worker = $this->rewardMgr->GetWorker($id);

            if($worker === null) {
                UserError::AddErrorIndexed('global', ERR_A_REWARD_WORKER_NOT_FOUND);
                return false;
            }

            $worker->name     = $name;
            $worker->position = $position;

        } else {
            $data = [
                'name'       => $name,
                'position'   => $position,
                'is_visible' => $is_visible,
                'section_id' => $this->_id,
            ];

            $worker = new Worker($data);
        }

        // ============================
        $arr_photos = [
            'image' => ['image'],
            'thumb' => ['thumb'],
        ];

        foreach($arr_photos as $key => $photos) {
            foreach($photos as $photoName) {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, [0, 1]);

                if($del_file || is_file($_FILES[$key]['tmp_name'])) {
                    $worker->$photoName = null;
                }

                try {
                    $worker->Upload($key, $photoName);
                } catch(MyException $e) {
                    if( $e->getCode() >  0 )
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    else
                        UserError::AddErrorIndexed($key, ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);

                    $worker->$photoName = null;
                    return false;
                }
            }
        }

        $worker->Update();

        return $worker->id;
    }

    private function _GetWorkerDelete()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $worker = $this->rewardMgr->GetWorker($id);
        $isRewardAssign = $worker->checkRewardAssign();

        if($isRewardAssign) {
            $rewards = $worker->rewards;
            $rewardList = [];
            foreach($rewards as $reward) {
                $rewardList[] = $reward->title;
            }

            $json->send([
                'status' => 'error',
                'message' => "Нельзя удалить сотрудника, которому назначена награда.\nНазначены следующие награды: ",
                'more' => $rewardList
            ]);
            exit;
        }

        if($worker === null) {
            $json->send([
                'status' => 'error',
                'message' => 'Указанный сотрудник не найден',
            ]);
            exit;
        }

        $worker->Remove();
        
        $json->send([
            'status' => 'ok',
        ]);
        exit;
    }

    // -------------------------------

    private function _GetRewards()
    {
        $filter = [
            'flags' => [
                'objects' => true,
            ],
            'field' => ['ord'],
            'dir' => ['asc'],
            'dbg' => 0,
        ];

        $rewards = $this->rewardMgr->GetRewards($filter);

        return STPL::Fetch('admin/modules/reward/rewards_list', [
            'section_id' => $this->_id,
            'rewards'    => $rewards,
            'action'     => 'new_reward',
        ]);
    }

    private function _GetRewardNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = [];
        $form['section_id'] = $this->_id;

        $workers = $this->_get_workers();

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['title']      = App::$Request->Post['title']->Value(Request::OUT_HTML);
            $form['text']       = App::$Request->Post['text']->Value(Request::OUT_HTML);
            $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0,1]);
            $form['worker_id']  = App::$Request->Post['worker_id']->Enum(0, array_keys($workers));

        } else {
            $form['title']      = '';
            $form['text']       = '';
            $form['is_visible'] = 0;
            $form['worker_id']  = 0;
        }

        return STPL::Fetch('admin/modules/reward/reward_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'new_reward',
            'workers'    => $workers,
        ]);
    }

    private function _GetRewardEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $reward = $this->rewardMgr->GetReward($id);

        if($reward === null) {
            UserError::AddErrorIndexed('global', ERR_A_REWARD_REWARD_NOT_FOUND);
            return STPL::Fetch('admin/modules/reward/reward_edit');
        }

        $workers = $this->_get_workers();

        $form['id']         = $reward->id;
        $form['section_id'] = $this->_id;
        $form['image']      = $reward->image;
        $form['thumb']      = $reward->thumb;

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['title']      = App::$Request->Post['title']->Value(Request::OUT_HTML);
            $form['text']       = App::$Request->Post['text']->Value(Request::OUT_HTML);
            $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0, 1]);
            $form['worker_id']  = App::$Request->Post['worker_id']->Enum(0, array_keys($workers));
        } else {
            $form['title']      = $reward->title;
            $form['text']       = $reward->text;
            $form['is_visible'] = $reward->is_visible;
            $form['worker_id']  = $reward->worker_id;
        }

        return STPL::Fetch('admin/modules/reward/reward_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'edit_reward',
            'workers'    => $workers,
        ]);
    }

    /**
     * @return array|bool|null
     */
    private function _PostReward()
    {
        global $CONFIG, $OBJECTS;

        $workers = $this->_get_workers();

        $id         = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $title      = App::$Request->Post['title']->Value(Request::OUT_HTML_CLEAN );
        $text       = App::$Request->Post['text']->Value();
        $is_visible = App::$Request->Post['is_visible']->Enum(0, [0, 1]);
        $worker_id  = App::$Request->Post['worker_id']->Enum(0, array_keys($workers));

        if($title == "") {
            UserError::AddErrorIndexed('title', ERR_A_REWARD_REWARD_TITLE_IS_EMPTY);
        }

        if(UserError::IsError()) {
            return false;
        } 

        if($id > 0) {
            $reward = $this->rewardMgr->GetReward($id);

            if ($reward === null) {
                UserError::AddErrorIndexed('global', ERR_A_REWARD_REWARD_NOT_FOUND);
                return false;
            }

            $reward->title      = $title;
            $reward->text       = $text;
            $reward->is_visible = $is_visible;
            $reward->worker_id  = $worker_id;

        } else {
            $data = [
                'title'      => $title,
                'text'       => $text,
                'is_visible' => $is_visible,
                'worker_id'  => $worker_id,
                'section_id' => $this->_id,
            ];

            $reward = new Reward($data);
        }

        // ============================
        $arr_photos = [
            'image' => ['image'],
            'thumb' => ['thumb'],
        ];

        foreach ($arr_photos as $key => $photos) {
            foreach ($photos as $photoName) {
                $del_file = App::$Request->Post[ 'del_'.$key ]->Enum(0, [0, 1]);

                if ($del_file || is_file($_FILES[$key]['tmp_name'])) {
                    $reward->$photoName = null;
                }

                try {
                    $reward->Upload($key, $photoName);
                } catch(MyException $e) {
                    if($e->getCode() >  0) {
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    } else {
                        UserError::AddErrorIndexed($key, ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);
                    }

                    $reward->$photoName = null;
                    return false;
                }
            }
        }

        $reward->Update();

        return $reward->id;
    }

    private function _get_workers()
    {
        $filter = [
            'flags' => [
                'objects' => true,
            ],
            'dbg' => 0
        ];

        return $this->rewardMgr->GetWorkers($filter);
    }

    private function _GetAjaxToggleVisibility()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $reward = $this->rewardMgr->GetReward($id); 

        if($reward === null) {
            $json->send(['status' => 'error']);
            exit;
        }

        $visibility = !$reward->is_visible;
        $visibility = (int) $visibility;

        $this->rewardMgr->UpdateRewardVisibility($visibility, $reward->id);

        $json->send([
            'status'     => 'ok',
            'is_visible' => (int) $visibility,
            'id'         => $id,
        ]);
        exit;
    }

    private function _GetRewardDelete()
    {
        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $reward = $this->rewardMgr->GetReward($id);
        if($reward === null) {
            return;
        }

        $reward->Remove();
        return;
    }

    private function _PostSaveRewardsOrders()
    {
        $orders = App::$Request->Post['orders']->AsArray([], Request::UNSIGNED_NUM);

        if(!is_array($orders) || count($orders) == 0) {
            return true;
        }

        foreach($orders as $id => $ord) {
            $reward = $this->rewardMgr->GetReward($id);
            if($reward === null) {
                continue;
            }

            $reward->ord = $ord;
            $reward->Update();
        }
        return true;
    }

    // --- --- --- OPINONS --- --- ---
    private function _GetOpinions()
    {
        $filter = [
            'flags' => [
                'objects' => true,
            ],
            'field' => ['ord'],
            'dir' => ['asc'],
            'dbg' => 0,
        ];

        $opinions = $this->rewardMgr->GetOpinions($filter);

        return STPL::Fetch('admin/modules/reward/opinions_list', [
            'section_id' => $this->_id,
            'opinions'   => $opinions,
            'action'     => 'new_opinion',
        ]);
    }

    private function _GetOpinionNew()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $form = [];
        $form['section_id'] = $this->_id;

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['name']       = App::$Request->Post['name']->Value(Request::OUT_HTML);
            $form['position']   = App::$Request->Post['position']->Value(Request::OUT_HTML);
            $form['text']       = App::$Request->Post['text']->Value(Request::OUT_HTML);
            $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0, 1]);

        } else {
            $form['name']       = '';
            $form['position']   = '';
            $form['text']       = '';
            $form['is_visible'] = 0;
        }

        return STPL::Fetch('admin/modules/reward/opinion_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'new_opinion',
        ]);
    }

    private function _GetOpinionEdit()
    {
        global $DCONFIG, $CONFIG, $OBJECTS;

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $opinion = $this->rewardMgr->GetOpinion($id);
        if($opinion === null) {
            UserError::AddErrorIndexed('global', ERR_A_REWARD_OPINION_NOT_FOUND);
            return STPL::Fetch('admin/modules/reward/opinion_edit');
        }

        $form['id'] = $opinion->id;
        $form['section_id'] = $this->_id;
        $form['image']      = $opinion->image;
        $form['thumb']      = $opinion->thumb;

        if(App::$Request->requestMethod === Request::M_POST) {
            $form['name']       = App::$Request->Post['name']->Value(Request::OUT_HTML);
            $form['position']   = App::$Request->Post['position']->Value(Request::OUT_HTML);
            $form['text']       = App::$Request->Post['text']->Value(Request::OUT_HTML);
            $form['is_visible'] = App::$Request->Post['is_visible']->Enum(0, [0, 1]);
        } else {
            $form['name']       = $opinion->name;
            $form['position']   = $opinion->position;
            $form['text']       = $opinion->text;
            $form['is_visible'] = $opinion->is_visible;
        }

        return STPL::Fetch('admin/modules/reward/opinion_edit', [
            'section_id' => $this->_id,
            'form'       => $form,
            'action'     => 'edit_opinion',
        ]);
    }

    /**
     * @return array|bool|null
     */
    private function _PostOpinion()
    {
        global $CONFIG, $OBJECTS;

        $id         = App::$Request->Post['id']->Int(0, Request::UNSIGNED_NUM);
        $name       = App::$Request->Post['name']->Value(Request::OUT_HTML_CLEAN );
        $position   = App::$Request->Post['position']->Value(Request::OUT_HTML_CLEAN );
        $text       = App::$Request->Post['text']->Value();
        $is_visible = App::$Request->Post['is_visible']->Enum(0, [0, 1]);

        if($name == "") {
            UserError::AddErrorIndexed('name', ERR_A_REWARD_OPINION_NAME_IS_EMPTY);
        }

        if($text == "") {
            UserError::AddErrorIndexed('text', ERR_A_REWARD_OPINION_TEXT_IS_EMPTY);
        }

        if(UserError::IsError()) {
            return false;
        } 

        if($id > 0) {
            $opinion = $this->rewardMgr->GetOpinion($id);

            if($opinion === null) {
                UserError::AddErrorIndexed('global', ERR_A_REWARD_OPINION_NOT_FOUND);
                return false;
            }

            $opinion->name       = $name;
            $opinion->position   = $position;
            $opinion->text       = $text;
            $opinion->is_visible = $is_visible;
        } else {
            $data = [
                'name'       => $name,
                'position'   => $position,
                'text'       => $text,
                'is_visible' => $is_visible,
                'section_id' => $this->_id,
            ];

            $opinion = new Opinion($data);
        }

        // ============================
        $arr_photos = [
            'image' => ['image'],
            'thumb' => ['thumb'],
        ];

        foreach($arr_photos as $key => $photos) {
            foreach ($photos as $photoName) {
                $del_file   = App::$Request->Post[ 'del_'.$key ]->Enum(0, [0, 1]);

                if($del_file || is_file($_FILES[$key]['tmp_name'])) {
                    $opinion->$photoName = null;
                }

                try {
                    $opinion->Upload($key, $photoName);
                } catch(MyException $e) {
                    if( $e->getCode() >  0 ) {
                        UserError::AddErrorWithArgsIndexed($key, $e->getCode(), $e->getUserErrorArgs());
                    } else {
                        UserError::AddErrorIndexed($key, ERR_A_PHOTO_ERROR_UPLOAD_IMAGE);
                    }

                    $opinion->$photoName = null;
                    return false;
                }
            }
        }

        $opinion->Update();

        return $opinion->id;
    }

    private function _GetAjaxOpinionToggleVisibility()
    {
        include_once ENGINE_PATH.'include/json.php';
        $json = new Services_JSON();

        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);

        $opinion = $this->rewardMgr->GetOpinion($id); 
        if($opinion === null) {
            $json->send(['status' => 'error']);
            exit;
        }

        $opinion->is_visible = !$opinion->is_visible;
        $opinion->Update();

        $json->send([
            'status'     => 'ok',
            'is_visible' => (int) $opinion->is_visible,
            'id'         => $id,
        ]);
        exit;
    }

    private function _PostSaveOpinionsOrders()
    {
        $orders = App::$Request->Post['orders']->AsArray([], Request::UNSIGNED_NUM);

        if (!is_array($orders) || count($orders) == 0) {
            return true;
        }

        foreach($orders as $id => $ord) {
            $opinion = $this->rewardMgr->GetOpinion($id);
            if($opinion === null) {
                continue;
            }

            $opinion->ord = $ord;
            $opinion->Update();
        }
        return true;
    }

    private function _GetOpinionDelete()
    {
        $id = App::$Request->Get['id']->Int(0, Request::UNSIGNED_NUM);
        $opinion = $this->rewardMgr->GetOpinion($id);
        if($opinion === null) {
            return;
        }

        $opinion->Remove();
        return;
    }
}
