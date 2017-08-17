<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\repositories;

use setrun\sys\entities\manage\Language;
use setrun\sys\interfaces\i18nInterface;
use setrun\sys\exceptions\NotFoundException;

/**
 * Class LanguageRepository.
 */
class LanguageRepository
{
    /**
    * @var i18nInterface
    */
    protected $i18n;

    public function __construct(i18nInterface $i18n)
    {
        $this->i18n = $i18n;
    }

    /**
     * Find a language item.
     * @param $id
     * @return Language
     */
    public function get($id): Language
    {
        if (!$model = Language::findOne($id)) {
            throw new NotFoundException($this->i18n->t('setrun/sys/language', 'Language is not found'));
        }
        return $model;
    }

    /**
     * Save a language item.
     * @param Language $model
     * @return void
     */
    public function save(Language $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException($this->i18n->t('setrun/sys', 'Saving error'));
        }
    }

    /**
     * Remove a language item.
     * @param Language $model
     * @return void
     */
    public function remove(Language $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException($this->i18n->t('setrun/sys', 'Removing error'));
        }
    }
}