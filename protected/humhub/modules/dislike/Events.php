<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2015 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\dislike;

use humhub\components\ActiveRecord;
use humhub\components\Event;
use humhub\modules\dislike\models\Dislike;
use Yii;

/**
 * Events provides callbacks to handle events.
 *
 * @author luke
 */
class Events extends \yii\base\BaseObject
{

    /**
     * On User delete, also delete all comments
     *
     * @param Event $event
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function onUserDelete($event)
    {
        foreach (Dislike::findAll(['created_by' => $event->sender->id]) as $dislike) {
            /** @var Like $like */
            $dislike->delete();
        }

        return true;
    }

    /**
     * On any ActiveRecord deletion check for assigned likes
     *
     * @param $event
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function onActiveRecordDelete($event)
    {
        /** @var ActiveRecord $record */
        $record = $event->sender;
        if ($record->hasAttribute('id')) {
            foreach (Dislike::findAll(['object_id' => $record->id, 'object_model' => $record->className()]) as $dislike) {
                $dislike->delete();
            }
        }

        return true;
    }

    /**
     * Callback to validate module database records.
     *
     * @param Event $event
     */
    public static function onIntegrityCheck($event)
    {
        $integrityController = $event->sender;
        $integrityController->showTestHeadline("Dislike (" . Dislike::find()->count() . " entries)");

        foreach (Dislike::find()->each() as $dislike) {
            if ($like->source === null) {
                if ($integrityController->showFix("Deleting dislike id " . $dislike->id . " without existing target!")) {
                    $dislike->delete();
                }
            }
            // User exists
            if ($dislike->user === null) {
                if ($integrityController->showFix("Deleting dislike id " . $dislike->id . " without existing user!")) {
                    $dislike->delete();
                }
            }
        }
    }

    /**
     * On initalizing the wall entry controls also add the like link widget
     *
     * @param Event $event
     */
    public static function onWallEntryLinksInit($event)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('dislike');

        if ($module->canLike($event->sender->object)) {
            $event->sender->addWidget(widgets\DislikeLink::class, ['object' => $event->sender->object], ['sortOrder' => 20]);
        }
    }


    /**
     * @return Module the like module
     */
    private static function getModule()
    {
        return Yii::$app->getModule('dislike');
    }

}
