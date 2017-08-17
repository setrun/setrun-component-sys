<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\services;

use setrun\sys\entities\manage\Language;
use setrun\sys\forms\backend\LanguageForm;
use setrun\sys\repositories\LanguageRepository;
use setrun\sys\exceptions\DomainFormException;

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
            $form->icon_id,
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
            $form->icon_id,
            $form->status
        );
        $this->assertIsNotDefault($model);
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
        $this->repository->remove($model);
    }

    /**
     * @param Language $model
     */
    private function assertIsNotDefault(Language $model): void
    {
        if ($model->status == Language::STATUS_DRAFT && $model->bydefault == 1) {
            throw new DomainFormException(['status' => 'Unable to manage the default language']);
        }
    }
}