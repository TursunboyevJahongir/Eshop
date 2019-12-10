<?php

namespace app\modules\Admin\controllers;

use app\controllers\BaseController;

/**
 * Default controller for the `modules` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
