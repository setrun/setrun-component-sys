<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\services;

use setrun\sys\exceptions\YiiException;
use setrun\sys\entities\manage\Language;
use setrun\sys\forms\backend\LanguageForm;
use setrun\sys\repositories\LanguageRepository;

/**
 * Class LanguageService.
 */
class LanguageService
{
    /**
     * @var DomainRepository
     */
    protected $repository;

    /**
     * LanguageService constructor.
     */
    public function __construct(LanguageRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Language item create.
     * @param  LanguageForm $form
     * @return Language
     */
    public function create(LanguageForm $form): Language
    {
        $model = Language::create(
            $form->name,
            $form->slug,
            $form->locale,
            $form->alias,
            $form->icon,
            $form->status
        );
        $this->repository->save($model);
        return $model;
    }

    /**
     * Language item edit.
     * @param  $id
     * @param  LanguageForm $form
     * @return void
     */
    public function edit($id, LanguageForm $form): void
    {
        $model = $this->repository->get($id);
        $model->edit(
            $form->name,
            $form->slug,
            $form->locale,
            $form->alias,
            $form->icon,
            $form->status
        );
        $this->assertIsNotDefaultDraft($model);
        $this->repository->save($model);
    }

    /**
     * Domain item remove.
     * @param $id
     * @return void
     */
    public function remove($id): void
    {
        $model = $this->repository->get($id);
        $this->assertIsNotDefault($model);
        $this->repository->remove($model);
    }

    public function default($id) : void
    {
        $model = $this->repository->get($id);
        $this->assertIsNotDraft($model);
        $model->default();
        $this->repository->save($model);
    }

    public function status($id, $status) : void
    {
        $model = $this->repository->get($id);
        $this->assertIsStatusExists($status);
        $model->status($status);
        $this->assertIsNotDefaultDraft($model);
        $this->repository->save($model);
    }

    /**
     * @param Language $model
     */
    private function assertIsNotDefaultDraft(Language $model): void
    {
        if ($model->status == Language::STATUS_DRAFT && $model->is_default == 1) {
            throw new YiiException([
                'status' => 'Unable to manage the default language is status draft'
            ]);
        }
    }

    /**
     * @param Language $model
     */
    private function assertIsNotDefault(Language $model): void
    {
        if ($model->is_default == 1) {
            throw new YiiException([
                'Unable to remove the default language'
            ]);
        }
    }

    /**
     * @param Language $model
     */
    private function assertIsNotDraft(Language $model): void
    {
        if ($model->status == Language::STATUS_DRAFT) {
            throw new YiiException([
                'status' => 'Unable to manage the language is status draft'
            ]);
        }
    }

    /**
     * @param $status
     */
    private function assertIsStatusExists($status)
    {
        if (!isset(Language::getStatuses()[$status])) {
            throw new YiiException([
                'status' => 'Status is not exists'
            ]);
        }
    }
}